<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Kendaraan;
use App\Models\AreaParkir;
use App\Models\Tarif;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class TransaksiController extends Controller
{
    public function halaman_transaksi() {
        $query = Transaksi::query()
            ->with([
                'kendaraan:id,jenis_kendaraan,plat_nomor,pemilik',
                'area:id,nama_area',
            ])
            ->latest('waktu_masuk');

        $transaksiMasuk = (clone $query)
            ->where('status', 'masuk')
            ->get()
            ->map(function ($item) {
                return [
                    'id'              => $item->id,
                    'jenis_kendaraan' => $item->kendaraan?->jenis_kendaraan ?? '-',
                    'plat_nomor'      => $item->kendaraan?->plat_nomor ?? '-',
                    'pemilik'         => $item->kendaraan?->pemilik ?? '-',
                    'area_parkir'     => $item->area?->nama_area ?? '-',
                    'waktu_masuk'     => $item->waktu_masuk?->format('Y-m-d H:i:s'),
                ];
            });

        $transaksiKeluar = (clone $query)
            ->where('status', 'keluar')
            ->latest('waktu_keluar')
            ->get()
            ->map(function ($item) {
                return [
                    'id'              => $item->id,
                    'jenis_kendaraan' => $item->kendaraan?->jenis_kendaraan ?? '-',
                    'plat_nomor'      => $item->kendaraan?->plat_nomor ?? '-',
                    'pemilik'         => $item->kendaraan?->pemilik ?? '-',
                    'area_parkir'     => $item->area?->nama_area ?? '-',
                    'waktu_masuk'     => $item->waktu_masuk?->format('Y-m-d H:i:s'),
                    'waktu_keluar'    => $item->waktu_keluar?->format('Y-m-d H:i:s'),
                    'durasi'          => $item->durasi,
                    'biaya_total'     => $item->biaya_total,
                ];
            });

        $jenisKendaraanList = ['motor', 'mobil', 'lainnya'];

        $kendaraanSedangMasuk = DB::table('transaksi')
            ->where('status', 'masuk')
            ->pluck('id_kendaraan');

        $platByJenis = Kendaraan::query()
            ->select(['id', 'plat_nomor', 'jenis_kendaraan'])
            ->whereIn('jenis_kendaraan', $jenisKendaraanList)
            ->whereNotIn('id', $kendaraanSedangMasuk)
            ->orderBy('plat_nomor')
            ->get()
            ->groupBy('jenis_kendaraan')
            ->map(fn ($items) => $items->map(fn ($item) => [
                'id'         => $item->id,
                'plat_nomor' => $item->plat_nomor,
            ])->values());

        $areaParkir = AreaParkir::query()
            ->select([
                'id',
                'nama_area',
                'kapasitas',
                'terisi',
            ])
            ->whereColumn('terisi', '<', 'kapasitas')
            ->orderBy('nama_area')
            ->get()
            ->map(function ($area) {
                $sisaKapasitas = max(0, $area->kapasitas - $area->terisi);

                return [
                    'id'              => $area->id,
                    'nama_area'       => $area->nama_area,
                    'sisa_kapasitas'  => $sisaKapasitas
                ];
            });

        return view('halaman-transaksi', [
            'transaksiMasuk' => $transaksiMasuk,
            'transaksiKeluar' => $transaksiKeluar,
            'jenisKendaraanList' => $jenisKendaraanList,
            'platByJenis' => $platByJenis,
            'areaParkir' => $areaParkir
            ]);
    }

    public function simpan_transaksi(Request $request) {
        $validasi = $request->validate([
            'jenis_kendaraan' => ['required', 'in:motor,mobil,lainnya'],
            'id_kendaraan'    => ['required', 'exists:kendaraan,id'],
            'area_parkir'     => ['required', 'exists:area_parkir,id'],
        ]);

        $masihAktif = DB::table('transaksi')
            ->where('id_kendaraan', $validasi['id_kendaraan'])
            ->where('status', 'masuk')
            ->exists();

        if ($masihAktif) {
            throw ValidationException::withMessages([
                'id_kendaraan' => 'Kendaraan ini masih memiliki transaksi aktif (status masuk) dan belum keluar.',
            ]);
        }

        $tarif = Tarif::where('jenis_kendaraan', $validasi['jenis_kendaraan'])->firstOrFail();

        try {
            DB::transaction(function () use ($validasi, $tarif) {
                $area = AreaParkir::where('id', $validasi['area_parkir'])
                ->lockForUpdate()
                ->firstOrFail();

                if ($area->terisi >= $area->kapasitas) {
                    throw ValidationException::withMessages([
                        'area_parkir' => 'Kapasitas area parkir sudah penuh.',
                    ]);
                }

                Transaksi::create([
                    'id_kendaraan' => $validasi['id_kendaraan'],
                    'waktu_masuk'  => now(),
                    'waktu_keluar' => null,
                    'id_tarif'     => $tarif->id,
                    'durasi'       => 0,
                    'biaya_total'  => 0,
                    'status'       => 'masuk',
                    'id_user'      => Auth::id(),
                    'id_area'      => $area->id,
                ]);

                $area->increment('terisi');
            });

            return redirect('transaksi')->with('success', 'Transaksi masuk berhasil disimpan.');
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Throwable $th) {
            report($th);

            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['error' => 'Gagal menyimpan transaksi: ' . $th->getMessage()]);
        }
    }

    public function update_transaksi(int $id) {
        try {
            $transaksi = DB::transaction(function () use ($id) {
                $trx = Transaksi::with(['tarif', 'area'])
                    ->where('id', $id)
                    ->lockForUpdate()
                    ->firstOrFail();

                if ($trx->status === 'keluar') {
                    throw ValidationException::withMessages([
                        'transaksi' => 'Transaksi ini sudah berstatus keluar.',
                    ]);
                }

                $waktuMasuk = Carbon::parse($trx->waktu_masuk);
                $waktuKeluar = now();

                $durasiMenit = max(1, (int) $waktuMasuk->diffInMinutes($waktuKeluar));
                $durasiTagihanJam = (int) ceil($durasiMenit / 60);

                $tarifPerJam = (float) ($trx->tarif?->tarif_perjam ?? 0);
                $biayaTotal = $durasiTagihanJam * $tarifPerJam;

                $trx->update([
                    'waktu_keluar' => $waktuKeluar,
                    'durasi'       => $durasiMenit,
                    'biaya_total'  => $biayaTotal,
                    'status'       => 'keluar',
                ]);

                if ($trx->id_area) {
                    $area = AreaParkir::where('id', $trx->id_area)
                        ->lockForUpdate()
                        ->first();

                    if ($area && $area->terisi > 0) {
                        $area->decrement('terisi');
                    }
                }

                return $trx;
            });

            return redirect('transaksi')
                ->with('success', 'Kendaraan berhasil keluar. Durasi: ' . $transaksi->durasi . ' jam, Total: Rp ' . number_format((float) $transaksi->biaya_total, 0, ',', '.'))
                ->with('cetak_transaksi_id', $transaksi->id);
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Throwable $th) {
            report($th);

            return redirect()
                ->back()
                ->withErrors(['error' => 'Gagal memproses transaksi keluar: ' . $th->getMessage()]);
        }
    }

    public function pdf(int $transaksi) {
        $transaksi = Transaksi::with(['kendaraan', 'area', 'tarif', 'user'])
            ->where('id', $transaksi)
            ->where('status', 'keluar')
            ->firstOrFail();

        $timezone = config('app.timezone', 'Asia/Jakarta');
        $waktuCetak = now($timezone)->format('YmdHi');

        $filename = 'struk-transaksi-' . $transaksi->id . '_' . $waktuCetak . '.pdf';

        $pdf = Pdf::loadView('pdf', ['transaksi' => $transaksi])
            ->setPaper([0, 0, 226.77, 453.54], 'portrait');

        return $pdf->download($filename);
    }
}

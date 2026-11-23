<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RekapController extends Controller
{
    /**
     * Halaman awal rekap (saat pertama kali dibuka / GET).
     */
    public function halaman_rekap()
    {
        $timezone = config('app.timezone', 'Asia/Jakarta');

        $start = now($timezone)->startOfMonth();
        $end = now($timezone)->endOfDay();

        return $this->renderRekap($start, $end, $timezone);
    }

    /**
     * Memproses filter rekap saat tombol "Cari" ditekan (POST).
     */
    public function cari_rekap(Request $request)
    {
        $timezone = config('app.timezone', 'Asia/Jakarta');

        $request->validate([
            'date_range' => ['required', 'string', 'max:100'],
        ]);

        // Default fallback jika parsing gagal
        $start = now($timezone)->startOfMonth();
        $end = now($timezone)->endOfDay();

        $rawRange = trim((string) $request->input('date_range', ''));
        $parts = preg_split('/\s+(?:to|-)\s+/i', $rawRange);

        try {
            if (count($parts) === 2) {
                $start = Carbon::parse($parts[0], $timezone)->startOfDay();
                $end = Carbon::parse($parts[1], $timezone)->endOfDay();
            } elseif (count($parts) === 1 && $parts[0] !== '') {
                $start = Carbon::parse($parts[0], $timezone)->startOfDay();
                $end = Carbon::parse($parts[0], $timezone)->endOfDay();
            }
        } catch (\Throwable $e) {
            return redirect()
                ->route('rekap.index')
                ->withInput()
                ->withErrors(['date_range' => 'Format rentang tanggal tidak valid.']);
        }

        if ($start->gt($end)) {
            [$start, $end] = [$end->copy()->startOfDay(), $start->copy()->endOfDay()];
        }

        return $this->renderRekap($start, $end, $timezone);
    }

    /**
     * Helper internal untuk mengambil data rekap dan me-render view.
     */
    private function renderRekap(Carbon $start, Carbon $end, string $timezone)
    {
        $transaksiRows = Transaksi::query()
            ->with([
                'kendaraan:id,jenis_kendaraan,plat_nomor,pemilik',
                'area:id,nama_area',
                'tarif:id,jenis_kendaraan,tarif_perjam',
                'user:id,nama_lengkap',
            ])
            ->where('status', 'keluar')
            ->whereNotNull('waktu_keluar')
            ->whereBetween('waktu_keluar', [$start, $end])
            ->orderByDesc('waktu_keluar')
            ->get();

        $rekapTransaksi = $transaksiRows->map(function ($item) use ($timezone) {
            return [
                'id'              => $item->id,
                'jenis_kendaraan' => $item->kendaraan?->jenis_kendaraan ?? '-',
                'plat_nomor'      => $item->kendaraan?->plat_nomor ?? '-',
                'pemilik'         => $item->kendaraan?->pemilik ?? '-',
                'area_parkir'     => $item->area?->nama_area ?? '-',
                'petugas'         => $item->user?->nama_lengkap ?? '-',
                'waktu_masuk'     => $item->waktu_masuk
                    ? Carbon::parse($item->waktu_masuk)->timezone($timezone)->format('Y-m-d H:i:s')
                    : '-',
                'waktu_keluar'    => $item->waktu_keluar
                    ? Carbon::parse($item->waktu_keluar)->timezone($timezone)->format('Y-m-d H:i:s')
                    : '-',
                'durasi'          => (int) $item->durasi,
                'biaya_total'     => (float) $item->biaya_total,
            ];
        });

        $ringkasan = [
            'jumlah_transaksi' => $rekapTransaksi->count(),
            'total_durasi'     => (int) $rekapTransaksi->sum('durasi'),
            'total_pendapatan' => (float) $rekapTransaksi->sum('biaya_total'),
        ];

        $dateRange = $start->format('Y-m-d') . ' to ' . $end->format('Y-m-d');
        
        return view('halaman-rekap', compact(
            'rekapTransaksi',
            'ringkasan',
            'dateRange',
            'start',
            'end'
        ));
    }
}
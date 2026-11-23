<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Kendaraan;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function halaman_dashboard() {
        $timezone = config('app.timezone', 'Asia/Jakarta');
        $bulanSekarang = now($timezone)->format('Y-m');

        $bulanDefault = [
            $bulanSekarang => [
                'bulan_key'        => $bulanSekarang,
                'bulan_label'      => now($timezone)->translatedFormat('F Y'),
                'jumlah_transaksi' => 0,
                'pendapatan'       => 0.0,
            ],
        ];

        $dariTransaksi = Transaksi::query()
            ->where('status', 'keluar')
            ->whereNotNull('waktu_keluar')
            ->get()
            ->groupBy(fn ($item) => Carbon::parse($item->waktu_keluar)->timezone($timezone)->format('Y-m'))
            ->map(function ($items, $bulanKey) use ($timezone) {
                return [
                    'bulan_key'        => $bulanKey,
                    'bulan_label'      => Carbon::createFromFormat('Y-m', $bulanKey, $timezone)->translatedFormat('F Y'),
                    'jumlah_transaksi' => $items->count(),
                    'pendapatan'       => (float) $items->sum('biaya_total'),
                ];
            })
            ->all();

        $statistikBulanan = collect(array_replace($bulanDefault, $dariTransaksi))
            ->sortByDesc('bulan_key')
            ->values();

        $dataBulanIni = $statistikBulanan->firstWhere('bulan_key', $bulanSekarang);

        $kendaraan = Kendaraan::count();

        return view('halaman-dashboard', [
            'dataBulanIni' => $dataBulanIni,
            'kendaraan' => $kendaraan
            ]);
    }
}

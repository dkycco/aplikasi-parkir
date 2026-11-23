<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kendaraan;

class KendaraanController extends Controller
{
    public function halaman_kendaraan() {
        $kendaraan = Kendaraan::query()
            ->select([
                'id',
                'plat_nomor',
                'jenis_kendaraan',
                'warna',
                'pemilik'
            ])->get();

        return view('halaman-kendaraan', ['kendaraan' => $kendaraan]);
    }

    public function tambah_kendaraan() {
        return view('form-kendaraan');
    }

    public function simpan_kendaraan(Request $request) {
        $validasi = $request->validate([
            'plat-nomor' => 'required',
            'jenis-kendaraan' => 'required',
            'warna' => 'required',
            'pemilik' => 'required'
        ]);

        try {
           Kendaraan::create([
                'plat_nomor' => $validasi['plat-nomor'],
                'jenis_kendaraan' => $validasi['jenis-kendaraan'],
                'warna' => $validasi['warna'],
                'pemilik' => $validasi['pemilik']
           ]);

           return redirect('kendaraan');
        } catch (\Thowable) {
            return redirect()->back();
        }
    }

    public function edit_kendaraan(Kendaraan $kendaraan) {
        $data = [
            'id' => $kendaraan->id,
            'plat_nomor' => $kendaraan->plat_nomor,
            'jenis_kendaraan' => $kendaraan->jenis_kendaraan,
            'warna' => $kendaraan->warna,
            'pemilik' => $kendaraan->pemilik
        ];

        return view('form-kendaraan', ['data' => $data]);
    }

    public function update_kendaraan(Request $request, Kendaraan $kendaraan) {
        $validasi = $request->validate([
            'plat-nomor' => 'required',
            'jenis-kendaraan' => 'required',
            'warna' => 'required',
            'pemilik' => 'required'
        ]);

        try {
            $kendaraan->plat_nomor = $validasi['plat-nomor'];
            $kendaraan->jenis_kendaraan = $validasi['jenis-kendaraan'];
            $kendaraan->warna = $validasi['warna'];
            $kendaraan->pemilik = $validasi['pemilik'];
            $kendaraan->save();

            return redirect('kendaraan');
        } catch (\Throwable) {
            return redirect()->back();
        }
    }

    public function hapus_kendaraan(Kendaraan $kendaraan) {
        try {
            $kendaraan->delete();

            return redirect('kendaraan');
        } catch (\Throwable) {
            return redirect()->back();
        }
    }
}

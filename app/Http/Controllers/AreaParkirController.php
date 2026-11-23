<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AreaParkir;

class AreaParkirController extends Controller
{
    public function halaman_area() {
        $area_parkir = AreaParkir::query()
            ->select([
                'id',
                'nama_area',
                'kapasitas',
                'terisi'
            ])->get();

        return view('halaman-area', ['area_parkir' => $area_parkir]);
    }

    public function tambah_area() {
        return view('form-area');
    }

    public function simpan_area(Request $request) {
        $validasi = $request->validate([
            'nama-area' => 'required',
            'kapasitas' => 'required'
        ]);

        try {
           AreaParkir::create([
                'nama_area' => $validasi['nama-area'],
                'kapasitas' => $validasi['kapasitas']
           ]);

           return redirect('area');
        } catch (\Thowable) {
            return redirect()->back();
        }
    }

    public function edit_area(AreaParkir $area) {
        $data = [
            'id' => $area->id,
            'nama_area' => $area->nama_area,
            'kapasitas' => $area->kapasitas
        ];

        return view('form-area', ['data' => $data]);
    }

    public function update_area(Request $request, AreaParkir $area) {
        $validasi = $request->validate([
            'nama-area' => 'required',
            'kapasitas' => 'required'
        ]);

        try {
            $area->nama_area = $validasi['nama-area'];
            $area->kapasitas = $validasi['kapasitas'];
            $area->save();

            return redirect('area');
        } catch (\Throwable) {
            return redirect()->back();
        }
    }

    public function hapus_area(AreaParkir $area) {
        try {
            $area->delete();

            return redirect('area');
        } catch (\Throwable) {
            return redirect()->back();
        }
    }
    
}

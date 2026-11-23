<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tarif;

class TarifController extends Controller
{
    public function halaman_tarif() {
        $tarif = Tarif::query()
            ->select([
                'id',
                'jenis_kendaraan',
                'tarif_perjam'
            ])->get();

        return view('halaman-tarif', ['tarif' => $tarif]);
    }

    public function edit_tarif(Tarif $tarif) {
        $data = [
            'id' => $tarif->id,
            'jenis_kendaraan' => $tarif->jenis_kendaraan,
            'tarif_perjam' => $tarif->tarif_perjam
        ];

        return view('form-tarif', ['data' => $data]);
    }

    public function update_tarif(Request $request, Tarif $tarif) {
        $validasi = $request->validate([
            'tarif-perjam' => 'required'
        ]);

        try {
            $tarif->tarif_perjam = $validasi['tarif-perjam'];
            $tarif->save();

            return redirect('tarif');
        } catch (\Throwable) {
            return redirect()->back();
        }
    }
}

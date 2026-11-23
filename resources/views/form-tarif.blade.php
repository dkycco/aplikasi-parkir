@extends('layouts.main-layout')
@section ('isi')
@php
    $isEdit = !empty($data['id']);
@endphp

<div class="page-header">
  <div>
    <h1 class="page-title">{{ $isEdit ? 'Edit' : 'Tambah' }} Tarif</h1>
    <p class="page-subtitle">Buat transaksi parkiranmu lebih mudah.</p>
  </div>
</div>

<div>
    <div class="card border-light shadow-sm p-4 h-100">
        <h5 class="card-title mb-4">Form {{ $isEdit ? 'Edit' : 'Tambah' }} Tarif</h5>

        <form action="{{ $isEdit ? route('update_tarif', $data['id']) : route('simpan_tarif') }}" method="POST">
            @csrf

            <h6 class="mb-3">Jenis Kendaraan</h6>
            <div class="mb-4">
                @php
                    $currentRadio = old('jenis-kendaraan', $data['jenis_kendaraan'] ?? '');
                @endphp

                <div class="form-check-custom">
                    <input type="radio" class="form-check-input-custom" id="motor" value="motor" name="jenis-kendaraan" {{ $currentRadio === 'motor' ? 'checked' : '' }} disabled>
                    <label for="motor" class="form-label-custom">Motor</label>
                </div>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  
 
                <div class="form-check-custom">
                    <input type="radio" class="form-check-input-custom" id="mobil" value="mobil" name="jenis-kendaraan" {{ $currentRadio === 'mobil' ? 'checked' : '' }} disabled>
                    <label for="mobil" class="form-label-custom">Mobil</label>
                </div>

                <div class="form-check-custom">
                    <input type="radio" class="form-check-input-custom" id="lainnya" value="lainnya" name="jenis-kendaraan" {{ $currentRadio === 'lainnya' ? 'checked' : '' }} disabled>
                    <label for="lainnya" class="form-label-custom">Lainnya</label>
                </div>
            </div>
            
            <div class="mb-3">
                <label for="tarif-perjam" class="form-label-custom">Tarif PerJam</label>
                <input type="text" class="form-control-custom" id="tarif-perjam" name="tarif-perjam" value="{{ old('tarif_perjam', $data['tarif_perjam'] ?? '') }}">
            </div>

            <button class="btn-custom btn-custom-primary" type="submit">Simpan Tarif</button>
        </form>
    </div>
</div>
@endsection
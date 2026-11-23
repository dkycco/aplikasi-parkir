@extends('layouts.main-layout')
@section ('isi')
@php
    $isEdit = !empty($data['id']);
@endphp

<div class="page-header">
  <div>
    <h1 class="page-title">{{ $isEdit ? 'Edit' : 'Tambah' }} Kendaraan</h1>
    <p class="page-subtitle">Buat transaksi parkiranmu lebih mudah.</p>
  </div>
</div>

<div>
    <div class="card border-light shadow-sm p-4 h-100">
        <h5 class="card-title mb-4">Form {{ $isEdit ? 'Edit' : 'Tambah' }} Kendaraan</h5>

        <form action="{{ $isEdit ? route('update_kendaraan', $data['id']) : route('simpan_kendaraan') }}" method="POST">
            @csrf

            <h6 class="mb-3">Jenis Kendaraan</h6>
            <div class="mb-4">
                @php
                    $currentRadio = old('jenis-kendaraan', $data['jenis_kendaraan'] ?? '');
                @endphp

                <div class="form-check-custom">
                    <input type="radio" class="form-check-input-custom" id="motor" value="motor" name="jenis-kendaraan" {{ $currentRadio === 'motor' ? 'checked' : '' }}>
                    <label for="motor" class="form-label-custom">Motor</label>
                </div>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  
 
                <div class="form-check-custom">
                    <input type="radio" class="form-check-input-custom" id="mobil" value="mobil" name="jenis-kendaraan" {{ $currentRadio === 'mobil' ? 'checked' : '' }}>
                    <label for="mobil" class="form-label-custom">Mobil</label>
                </div>

                <div class="form-check-custom">
                    <input type="radio" class="form-check-input-custom" id="lainnya" value="lainnya" name="jenis-kendaraan" {{ $currentRadio === 'lainnya' ? 'checked' : '' }}>
                    <label for="lainnya" class="form-label-custom">Lainnya</label>
                </div>
            </div>
            
            <div class="mb-3">
                <label for="plat-nomor" class="form-label-custom">Plat Nomor</label>
                <input type="text" class="form-control-custom" id="plat-nomor" name="plat-nomor" maxlength="12"
                    value="{{ old('plat-nomor', $data['plat_nomor'] ?? '') }}">
            </div>

            <script>
                document.getElementById('plat-nomor').addEventListener('input', function () {
                    let raw = this.value.toUpperCase().replace(/[^A-Z0-9]/g, '');

                    const match = raw.match(/^([A-Z]{1,2})(\d{0,4})([A-Z]{0,3})/);

                    if (!match) {
                        this.value = raw;
                        return;
                    }

                    const depan = match[1] || '';
                    const angka = match[2] || '';
                    const belakang = match[3] || '';

                    let hasil = depan;
                    if (angka) hasil += ' ' + angka;
                    if (belakang) hasil += ' ' + belakang;

                    this.value = hasil;
                });
            </script>

            <div class="mb-3">
                <label for="warna" class="form-label-custom">Warna</label>
                <input type="text" class="form-control-custom" id="warna" name="warna" value="{{ old('warna', $data['warna'] ?? '') }}">
            </div>

            <div class="mb-3">
                <label for="pemilik" class="form-label-custom">Pemilik</label>
                <input type="text" class="form-control-custom" id="pemilik" name="pemilik" value="{{ old('pemilik', $data['pemilik'] ?? '') }}">
            </div>

            <button class="btn-custom btn-custom-primary" type="submit">Simpan Kendaraan</button>
        </form>
    </div>
</div>
@endsection
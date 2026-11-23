@extends('layouts.main-layout')
@section ('isi')
@php
    $isEdit = !empty($data['id']);
@endphp

<div class="page-header">
  <div>
    <h1 class="page-title">{{ $isEdit ? 'Edit' : 'Tambah' }} Area Parkir</h1>
    <p class="page-subtitle">Buat transaksi parkiranmu lebih mudah.</p>
  </div>
</div>

<div>
    <div class="card border-light shadow-sm p-4 h-100">
        <h5 class="card-title mb-4">Form {{ $isEdit ? 'Edit' : 'Tambah' }} Area Parkir</h5>

        <form action="{{ $isEdit ? route('update_area', $data['id']) : route('simpan_area') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label for="nama-area" class="form-label-custom">Nama Area</label>
                <input type="text" class="form-control-custom" id="nama-area" name="nama-area" value="{{ old('nama-area', $data['nama_area'] ?? '') }}">
            </div>

            <div class="mb-3">
                <label for="kapasitas" class="form-label-custom">Kapasitas</label>
                <input type="text" class="form-control-custom" id="kapasitas" name="kapasitas" value="{{ old('kapasitas', $data['kapasitas'] ?? '') }}">
            </div>

            <button class="btn-custom btn-custom-primary" type="submit">Simpan Area Parkir</button>
        </form>
    </div>
</div>
@endsection
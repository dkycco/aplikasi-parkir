@extends('layouts.main-layout')
@section ('isi')
@php
    $isEdit = !empty($data['id']);
@endphp

<div class="page-header">
  <div>
    <h1 class="page-title">{{ $isEdit ? 'Edit' : 'Tambah' }} User</h1>
    <p class="page-subtitle">Buat transaksi parkiranmu lebih mudah.</p>
  </div>
</div>

<div>
    <div class="card border-light shadow-sm p-4 h-100">
        <h5 class="card-title mb-4">Form {{ $isEdit ? 'Edit' : 'Tambah' }} User</h5>

        <form action="{{ $isEdit ? route('update_user', $data['id']) : route('simpan_user') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label for="nama-lengkap" class="form-label-custom">Nama Lengkap</label>
                <input type="text" class="form-control-custom" id="nama-lengkap" name="nama-lengkap" value="{{ old('nama-lengkap', $data['nama_lengkap'] ?? '') }}">
            </div>

            <div class="mb-3">
                <label for="username" class="form-label-custom">Username</label>
                <input type="text" class="form-control-custom" id="username" name="username" value="{{ old('username', $data['username'] ?? '') }}">
            </div>

            <div class="mb-3">
                <label for="password" class="form-label-custom">Password</label>
                <input type="text" class="form-control-custom" id="password" name="password">
            </div>

            <h6 class="mb-3">Role</h6>
            <div class="mb-4">
                @php
                    $currentRole = old('role', $data['role'] ?? '');
                @endphp

                <div class="form-check-custom">
                    <input type="radio" class="form-check-input-custom" id="admin" value="admin" name="role" {{ $currentRole === 'admin' ? 'checked' : '' }}>
                    <label for="admin" class="form-label-custom">Admin</label>
                </div>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  
 
                <div class="form-check-custom">
                    <input type="radio" class="form-check-input-custom" id="petugas" value="petugas" name="role" {{ $currentRole === 'petugas' ? 'checked' : '' }}>
                    <label for="petugas" class="form-label-custom">Petugas</label>
                </div>

                <div class="form-check-custom">
                    <input type="radio" class="form-check-input-custom" id="owner" value="owner" name="role" {{ $currentRole === 'owner' ? 'checked' : '' }}>
                    <label for="owner" class="form-label-custom">Owner</label>
                </div>
            </div>

            <button class="btn-custom btn-custom-primary" type="submit">Simpan User</button>
        </form>
    </div>
</div>
@endsection
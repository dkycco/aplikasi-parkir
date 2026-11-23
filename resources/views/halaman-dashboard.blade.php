@extends('layouts.main-layout')
@section('isi')
<div class="page-header">
  <div>
    <h1 class="page-title">Dashboard</h1>
    <p class="page-subtitle">Buat transaksi parkiranmu lebih mudah.</p>
  </div>
</div>

<div class="row g-4">
  <div class="col-12">
    <div class="row g-4">
      <div class="col-md-4">
        <div class="card card-stat d-flex flex-column justify-content-between">
          <div>
            <div class="card-header">
              <span class="stat-label">Pendapatan</span>
            </div>
            <div class="stat-value">Rp <span>{{ number_format((float) $dataBulanIni['pendapatan'], 0, ',', '.') }}</span></div>
            <div class="stat-label">
              <span>{{ $dataBulanIni['bulan_label'] }}</span>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card card-stat d-flex flex-column justify-content-between">
          <div>
            <div class="card-header">
              <span class="stat-label">Transaksi</span>
            </div>
            <div class="stat-value">{{ $dataBulanIni['jumlah_transaksi'] }}</div>
            <div class="stat-label">
              <span>{{ $dataBulanIni['bulan_label'] }}</span>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card card-stat d-flex flex-column justify-content-between">
          <div>
            <div class="card-header">
              <span class="stat-label">Kendaraan</span>
            </div>
            <div class="stat-value">{{ $kendaraan }}</div>
              <div class="stat-label">
              <span>{{ $dataBulanIni['bulan_label'] }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
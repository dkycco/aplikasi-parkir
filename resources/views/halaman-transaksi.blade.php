@extends('layouts.main-layout')
@section('isi')
<div class="page-header">
    <div>
        <h1 class="page-title">Transaksi</h1>
        <p class="page-subtitle">Buat transaksi parkiranmu lebih mudah.</p>
    </div>
</div>

@if (session('success'))
  <div class="alert alert-success d-flex justify-content-between align-items-center">
    <span>{{ session('success') }}</span>

    @if (session('cetak_transaksi_id'))
      <a href="{{ route('pdf', session('cetak_transaksi_id')) }}" class="btn btn-sm btn-dark">
        <i class="bi bi-printer"></i> Cetak Struk PDF
      </a>
    @endif
  </div>
@endif

<div class="table-card-custom">
    <div class="table-header-control">
        <form action="{{ route('simpan_transaksi') }}" method="POST">
            @csrf

            @if ($errors->any())
                <div class="alert alert-danger mb-3">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="d-flex gap-4">
                <div class="mb-3">
                    <label for="jenis-kendaraan" class="form-label-custom">Jenis Kendaraan</label>
                    <select class="form-select-custom" id="jenis-kendaraan" name="jenis_kendaraan">
                        <option value="" selected disabled>Pilih Jenis Kendaraan...</option>
                        @foreach ($jenisKendaraanList as $item)
                            <option value="{{ $item }}">
                                {{ ucfirst($item) }}
                            </option>
                        @endforeach
                    </select>
                </div>
    
                <div class="mb-3">
                    <label for="plat-nomor" class="form-label-custom">Plat Nomor</label>
                    <select class="form-select-custom" id="plat-nomor" name="id_kendaraan">
                        <option selected disabled>Pilih Plat Nomor...</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="area-parkir" class="form-label-custom">Area Parkir</label>
                    <select class="form-select-custom" id="area-parkir" name="area_parkir">
                        <option value="" selected disabled>Pilih Area Parkir...</option>
                        @foreach ($areaParkir as $item)
                            <option value="{{ $item['id'] }}">
                                {{ $item['nama_area'] }} - {{ $item['sisa_kapasitas'] }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const platByJenis = @json($platByJenis);
                    const oldJenis = @json(old('jenis_kendaraan'));
                    const oldKendaraanId = @json(old('id_kendaraan'));

                    const jenisSelect = document.getElementById('jenis-kendaraan');
                    const platSelect = document.getElementById('plat-nomor');

                    function renderPlatOptions(jenis, selectedId = null) {
                        const daftarPlat = platByJenis[jenis] || [];

                        platSelect.innerHTML = daftarPlat.length
                            ? '<option value="" selected disabled>Pilih Plat Nomor...</option>'
                            : '<option value="" selected disabled>Tidak ada plat tersedia</option>';

                        platSelect.disabled = daftarPlat.length === 0;

                        daftarPlat.forEach(function (item) {
                            const option = document.createElement('option');
                            option.value = item.id;
                            option.textContent = item.plat_nomor;
                            option.selected = selectedId && String(selectedId) === String(item.id);
                            platSelect.appendChild(option);
                        });
                    }

                    jenisSelect.addEventListener('change', function () {
                        renderPlatOptions(this.value);
                    });

                    if (oldJenis) {
                        renderPlatOptions(oldJenis, oldKendaraanId);
                    }
                });
            </script>

            <button class="btn-custom btn-custom-primary" type="submit">Simpan Transaksi</button>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table-custom">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Jenis Kendaraan</th>
                    <th>Plat Nomor</th>
                    <th>Pemilik</th>
                    <th>Area Parkir</th>
                    <th>Waktu Masuk</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($transaksiMasuk as $item)
                    <tr>
                        <td>{{ $item['id'] }}</td>
                        <td>{{ ucfirst($item['jenis_kendaraan']) }}</td>
                        <td>{{ $item['plat_nomor'] }}</td>
                        <td>{{ $item['pemilik'] }}</td>
                        <td>{{ $item['area_parkir'] }}</td>
                        <td>{{ $item['waktu_masuk'] }}</td>
                        <td>
                            <div class="d-flex justify-content-center gap-1">
                                <form action="{{ route('update_transaksi', $item['id']) }}" method="POST"
                                    onsubmit="return confirm('Yakin proses kendaraan {{ $item['plat_nomor'] }} keluar sekarang?')">
                                    @csrf
                                    @method('PATCH')
                                <button type="submit" class="table-btn-action" title="Update row"><i class="bi bi-box-arrow-right"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">Tidak ada data transaksi masuk.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="table-card-custom">
    <div class="table-header-control">
        <b>Transaksi Selesai</b>
    </div>

    <div class="table-responsive">
        <table class="table-custom">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Jenis Kendaraan</th>
                    <th>Plat Nomor</th>
                    <th>Pemilik</th>
                    <th>Area Parkir</th>
                    <th>Waktu Masuk</th>
                    <th>Waktu Keluar</th>
                    <th>Durasi</th>
                    <th>Biaya Total</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($transaksiKeluar as $item)
                    <tr>
                        <td>{{ $item['id'] }}</td>
                        <td>{{ ucfirst($item['jenis_kendaraan']) }}</td>
                        <td>{{ $item['plat_nomor'] }}</td>
                        <td>{{ $item['pemilik'] }}</td>
                        <td>{{ $item['area_parkir'] }}</td>
                        <td>{{ $item['waktu_masuk'] }}</td>
                        <td>{{ $item['waktu_keluar'] }}</td>
                        <td>{{ $item['durasi'] }}m</td>
                        <td>Rp {{ number_format((float) $item['biaya_total'], 0, ',', '.') }}</td>
                        <td>
                            <div class="d-flex justify-content-center gap-1">
                                <a href="{{ route('pdf', $item['id']) }}" class="table-btn-action" title="Cetak Struk" >
                                    <i class="bi bi-printer"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">Tidak ada data user.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

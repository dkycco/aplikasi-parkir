@extends('layouts.main-layout')
@section('isi')
<div class="page-header">
    <div>
        <h1 class="page-title">Kendaraan</h1>
        <p class="page-subtitle">Buat transaksi parkiranmu lebih mudah.</p>
    </div>
</div>

<div class="table-card-custom">
    <div class="table-header-control">
        <a href="{{ url('kendaraan/tambah-kendaraan') }}" class="btn-quick-action">
            <i class="bi bi-plus-lg"></i>
            <span>Tambah</span>
        </a>
    </div>

    <div class="table-responsive">
        <table class="table-custom">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Plat Nomor</th>
                    <th>Jenis Kendaraan</th>
                    <th>Warna</th>
                    <th>Pemilik</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kendaraan as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->plat_nomor }}</td>
                        <td>{{ ucfirst($item->jenis_kendaraan) }}</td>
                        <td>{{ ucfirst($item->warna) }}</td>
                        <td>{{ ucfirst($item->pemilik) }}</td>
                        <td>
                            <div class="d-flex justify-content-center gap-1">
                                <a href="{{ route('edit_kendaraan', $item->id) }}"
                                    class="table-btn-action" title="Edit row"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('hapus_kendaraan', $item->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="table-btn-action delete" title="Delete row"><i
                                            class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">Tidak ada data kendaraan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@extends('layouts.main-layout')
@section('isi')
<div class="page-header">
    <div>
        <h1 class="page-title">Tarif</h1>
        <p class="page-subtitle">Buat transaksi parkiranmu lebih mudah.</p>
    </div>
</div>

<div class="table-card-custom">
    <div class="table-responsive">
        <table class="table-custom">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Jenis Kendaraan</th>
                    <th>Tarif PerJam</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tarif as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ ucfirst($item->jenis_kendaraan) }}</td>
                        <td>Rp {{ number_format((float) $item->tarif_perjam, 0, ',', '.') }}</td>
                        <td>
                            <div class="d-flex justify-content-center gap-1">
                                <a href="{{ route('edit_tarif', $item->id) }}"
                                    class="table-btn-action" title="Edit row"><i class="bi bi-pencil"></i></a>
                            </div>
                        </td>
                    </tr>
                @empty
                  <tr>
                      <td colspan="5">Tidak ada data tarif.</td>
                  </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

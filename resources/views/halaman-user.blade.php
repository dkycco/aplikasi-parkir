@extends('layouts.main-layout')
@section('isi')
<div class="page-header">
  <div>
    <h1 class="page-title">User</h1>
    <p class="page-subtitle">Buat transaksi parkiranmu lebih mudah.</p>
  </div>
</div>

<div class="table-card-custom">
  <div class="table-header-control">
    <a href="{{ url('user/tambah-user') }}" class="btn-quick-action">
      <i class="bi bi-plus-lg"></i>
      <span>Tambah</span>
    </a>
  </div>

  <div class="table-responsive">
    <table class="table-custom">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nama Lengkap</th>
          <th>Username</th>
          <th>Role</th>
          <th class="text-center">Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($user as $item)
          <tr>
            <td>{{ $item->id }}</td>
            <td>{{ $item->nama_lengkap }}</td>
            <td>{{ $item->username }}</td>
            <td>{{ $item->role }}</td>
            <td>
              <div class="d-flex justify-content-center gap-1">
                <a href="{{ route('edit_user', $item->id) }}" class="table-btn-action" title="Edit row"><i class="bi bi-pencil"></i></a>
                <form action="{{ route('hapus_user', $item->id) }}" method="POST"
                  onsubmit="return confirm('Yakin ingin menghapus data {{ $item->nama_lengkap }}?')">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="table-btn-action delete {{ Auth::id() == $item->id ? 'd-none' : '' }}" title="Delete row"><i class="bi bi-trash"></i></button>
                </form>
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
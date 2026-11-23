@extends('layouts.main-layout')
@section('isi')
<div class="page-header">
    <div>
        <h1 class="page-title">Log Aktivitas</h1>
        <p class="page-subtitle">Buat transaksi parkiranmu lebih mudah.</p>
    </div>
</div>

<div class="table-card-custom">
    <div class="table-header-control">
        <span><strong>User Sedang Online:</strong> {{ $onlineCount }} / {{ $users->count() }}</span>
        <span><small>(Dianggap online jika aktif dalam {{ $thresholdMinutes }} menit terakhir)</small></span>
    </div>

    <div class="table-responsive">
        <table class="table-custom">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Lengkap</th>
                    <th>Username</th>
                    <th>Status</th>
                    <th>Aktivitas Terakhir</th>
                    <th>Terakhir Dilihat</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $item)
                    <tr>
                        <td>{{ $item['id'] }}</td>
                        <td>{{ $item['nama_lengkap'] }}</td>
                        <td>{{ $item['username'] }}</td>
                        <td>
                            @if($item['is_online'])
                                <span id="status-dot"></span> Online
                            @else
                                <span id="status-dot-red"></span> Offline
                            @endif
                        </td>
                        <td>{{ $item['last_activity_at'] ?? '-' }}
                        </td>
                        <td>{{ $item['last_seen_human'] }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">Tidak ada data sesi untuk user ini.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

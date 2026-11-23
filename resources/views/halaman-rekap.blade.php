@extends('layouts.main-layout')
@section('isi')
<div class="page-header">
    <div>
        <h1 class="page-title">Rekap</h1>
        <p class="page-subtitle">Buat transaksi parkiranmu lebih mudah.</p>
    </div>
</div>

<div class="table-card-custom">
    <div class="table-header-control">
        <form action="{{ route('cari_rekap') }}" method="POST" class="d-flex gap-4">
            @csrf
            <input type="hidden" name="date_range" id="date-range-input" value="">

            <div class="btn-date-picker" id="date-picker-trigger">
                <i class="bi bi-calendar4-event"></i>
                <span id="selected-date-range"></span>
                <i class="bi bi-chevron-down ms-1"></i>
            </div>
            <button type="submit" class="btn-quick-action">
                <i class="bi bi-search"></i>
                <span>Cari</span>
            </button>
        </form>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const triggerEl = document.getElementById('date-picker-trigger');
                const rangeTextEl = document.getElementById('selected-date-range');
                const rangeInputEl = document.getElementById('date-range-input');

                function formatToIsoDate(dateStr) {
                    const parsed = new Date(dateStr);
                    if (Number.isNaN(parsed.getTime())) {
                        return '';
                    }

                    const year = parsed.getFullYear();
                    const month = String(parsed.getMonth() + 1).padStart(2, '0');
                    const day = String(parsed.getDate()).padStart(2, '0');

                    return `${year}-${month}-${day}`;
                }

                function handleDateRangeChange() {
                    const rangeText = rangeTextEl ? rangeTextEl.textContent.trim() : '';
                    console.log('Rentang tanggal berubah:', rangeText);

                    if (!rangeInputEl) {
                        return;
                    }

                    if (!rangeText) {
                        rangeInputEl.value = '';
                        return;
                    }

                    const parts = rangeText.split(' - ').map(part => part.trim()).filter(Boolean);

                    if (parts.length === 2) {
                        const startIso = formatToIsoDate(parts[0]);
                        const endIso = formatToIsoDate(parts[1]);
                        rangeInputEl.value = (startIso && endIso) ? `${startIso} to ${endIso}` : rangeText;
                    } else if (parts.length === 1) {
                        const singleIso = formatToIsoDate(parts[0]);
                        rangeInputEl.value = singleIso || rangeText;
                    }
                }

                if (rangeTextEl) {
                    handleDateRangeChange();

                    const observer = new MutationObserver(function () {
                        handleDateRangeChange();
                    });

                    observer.observe(rangeTextEl, {
                        childList: true,
                        characterData: true,
                        subtree: true
                    });
                }
            });

        </script>
    </div>

    <div class="">
        <div class="row g-3 mt-2 px-4">
            <div class="col-md-4">
                <div class="table-card-custom p-3">
                    <small class="text-muted d-block">Total Transaksi</small>
                    <h4 class="mb-0 mt-1">
                        {{ number_format($ringkasan['jumlah_transaksi'] ?? 0, 0, ',', '.') }}
                    </h4>
                </div>
            </div>
            <div class="col-md-4">
                <div class="table-card-custom p-3">
                    <small class="text-muted d-block">Total Durasi</small>
                    <h4 class="mb-0 mt-1">
                        {{ number_format($ringkasan['total_durasi'] ?? 0, 0, ',', '.') }} menit
                    </h4>
                </div>
            </div>
            <div class="col-md-4">
                <div class="table-card-custom p-3">
                    <small class="text-muted d-block">Total Pendapatan</small>
                    <h4 class="mb-0 mt-1">Rp
                        {{ number_format($ringkasan['total_pendapatan'] ?? 0, 0, ',', '.') }}
                    </h4>
                </div>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table-custom">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Plat Nomor</th>
                    <th>Jenis Kendaraan</th>
                    <th>Pemilik</th>
                    <th>Area Parkir</th>
                    <th>Waktu Masuk</th>
                    <th>Waktu Keluar</th>
                    <th>Durasi</th>
                    <th class="text-end">Biaya Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse($rekapTransaksi as $index => $row)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><strong>{{ $row['plat_nomor'] }}</strong></td>
                        <td class="text-capitalize">{{ $row['jenis_kendaraan'] }}</td>
                        <td>{{ $row['pemilik'] }}</td>
                        <td>{{ $row['area_parkir'] }}</td>
                        <td>{{ $row['waktu_masuk'] }}</td>
                        <td>{{ $row['waktu_keluar'] }}</td>
                        <td>{{ $row['durasi'] }}m</td>
                        <td class="text-end">Rp
                            {{ number_format($row['biaya_total'], 0, ',', '.') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center py-4 text-muted">
                            Tidak ada data transaksi pada rentang tanggal ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

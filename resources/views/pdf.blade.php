<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    {{-- <title>Struk Parkir #{{ $transaksi->id }}</title> --}}
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            color: #111827;
            margin: 10px;
        }

        .center {
            text-align: center;
        }

        .title {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 2px;
        }

        .muted {
            color: #4b5563;
            font-size: 12px;
        }

        .divider {
            border-top: 1px dashed #6b7280;
            margin: 8px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            padding: 3px 0;
            vertical-align: top;
        }

        .text-end {
            text-align: right;
        }

        .total-row td {
            font-size: 13px;
            font-weight: bold;
            padding-top: 6px;
        }

    </style>
</head>

<body>
    <div class="center">
        <div class="title">STRUK PARKIR</div>
        {{-- <div class="muted">No. Transaksi: #{{ $transaksi->id }}</div>
        <div class="muted">Area: {{ $transaksi->area?->nama_area ?? '-' }}</div> --}}
    </div>

    <div class="divider"></div>

    <table>
        <tr>
            <td class="muted">Plat Nomor</td>
            <td class="text-end">
                {{-- <strong>{{ $transaksi->kendaraan?->plat_nomor ?? '-' }}</strong></td> --}}
        </tr>
        <tr>
            <td class="muted">Jenis Kendaraan</td>
            <td class="text-end">
                {{-- {{ ucfirst($transaksi->kendaraan?->jenis_kendaraan ?? '-') }}</td> --}}
        </tr>
        <tr>
            <td class="muted">Pemilik</td>
            {{-- <td class="text-end">{{ $transaksi->kendaraan?->pemilik ?? '-' }}</td> --}}
        </tr>
        <tr>
            <td class="muted">Waktu Masuk</td>
            <td class="text-end">
                {{-- {{ $transaksi->waktu_masuk?->format('d/m/Y H:i:s') ?? '-' }} --}}
            </td>
        </tr>
        <tr>
            <td class="muted">Waktu Keluar</td>
            <td class="text-end">
                {{-- {{ $transaksi->waktu_keluar?->format('d/m/Y H:i:s') ?? '-' }} --}}
            </td>
        </tr>
        <tr>
            <td class="muted">Durasi</td>
            {{-- <td class="text-end">{{ $transaksi->durasi }}</td> --}}
        </tr>
        <tr>
            <td class="muted">Petugas</td>
            {{-- <td class="text-end">{{ $transaksi->user?->name ?? '-' }}</td> --}}
        </tr>
    </table>

    <div class="divider"></div>

    <table>
        <tr class="total-row">
            <td>TOTAL BAYAR</td>
            <td class="text-end">Rp
                {{-- {{ number_format((float) $transaksi->biaya_total, 0, ',', '.') }} --}}
            </td>
        </tr>
    </table>

    <div class="divider"></div>

    <div class="center muted">
        Terima kasih telah menggunakan layanan parkir.<br>
        Simpan struk ini sebagai bukti pembayaran yang sah.
    </div>
</body>

</html>

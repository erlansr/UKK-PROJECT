<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Penjualan</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        h2 {
            text-align: center;
            margin-bottom: 5px;
        }

        .text-center {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table, th, td {
            border: 1px solid black;
        }

        th {
            background-color: #eee;
        }

        th, td {
            padding: 6px;
            font-size: 11px;
        }
    </style>
</head>
<body>

    <h2>LAPORAN PENJUALAN</h2>
    <p class="text-center">
        Periode: {{ $startDate }} - {{ $endDate }}
    </p>

    <hr>

    {{-- Summary --}}
    <table>
        <tr>
            <td><b>Total Pendapatan</b></td>
            <td>Rp {{ number_format($totalRevenue, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td><b>Total Pesanan</b></td>
            <td>{{ $totalOrders }}</td>
        </tr>
        <tr>
            <td><b>Total Item</b></td>
            <td>{{ $totalItems }}</td>
        </tr>
        <tr>
            <td><b>Rata-rata</b></td>
            <td>Rp {{ number_format($averageOrder, 0, ',', '.') }}</td>
        </tr>
    </table>

    {{-- Top Produk --}}
    <h3>Top Produk Terlaris</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Produk</th>
                <th>Jumlah</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($topProducts as $i => $p)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $p->product->name ?? '-' }}</td>
                <td>{{ $p->total_quantity }}</td>
                <td>Rp {{ number_format($p->total_sales, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Statistik Harian --}}
    <h3>Statistik Harian</h3>
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Pesanan</th>
                <th>Pendapatan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dailyStats as $d)
            <tr>
                <td>{{ \Carbon\Carbon::parse($d->date)->format('d/m/Y') }}</td>
                <td>{{ $d->orders }}</td>
                <td>Rp {{ number_format($d->revenue, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Detail Pesanan --}}
    <h3>Detail Pesanan</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Tanggal</th>
                <th>Pelanggan</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $o)
            <tr>
                <td>#{{ $o->id }}</td>
                <td>{{ \Carbon\Carbon::parse($o->created_at)->format('d/m/Y H:i') }}</td>
                <td>{{ $o->user->name ?? '-' }}</td>
                <td>Rp {{ number_format($o->total, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
@extends('layouts.admin')

@section('title', 'Laporan Penjualan')

@section('content')
<div class="px-4 sm:px-6 lg:px-8 py-6">
    {{-- Header --}}
    <div class="mb-8">
        <div class="flex items-baseline gap-3 flex-wrap">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-800 tracking-tight">
                📊 Laporan
            </h1>
            <span class="text-gray-400 text-lg">/</span>
            <span class="text-lg text-gray-500 font-medium">penjualan</span>
        </div>
        <div class="flex items-center gap-2 mt-2">
            <div class="h-0.5 w-12 bg-yellow-400 rounded-full"></div>
            <p class="text-gray-400 text-sm">rekapitulasi data penjualan</p>
        </div>
    </div>

    {{-- Filter Form --}}
    <div class="bg-white rounded-xl border border-gray-100 p-4 mb-8 shadow-sm">
        <form method="GET" action="{{ route('admin.reports.sales') }}" class="flex flex-wrap gap-4 items-end">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Dari Tanggal</label>
                <input type="date" name="start_date" value="{{ $startDate }}" 
                       class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Sampai Tanggal</label>
                <input type="date" name="end_date" value="{{ $endDate }}" 
                       class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400">
            </div>
            <div>
                <button type="submit" class="bg-gray-900 text-white px-6 py-2 rounded-lg hover:bg-gray-800 transition">
                    <i class="fas fa-filter mr-2"></i>Tampilkan
                </button>
            </div>
            <div>
                <a href="{{ route('admin.reports.sales.pdf', ['start_date' => $startDate, 'end_date' => $endDate]) }}" 
                   class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 transition inline-block">
                    <i class="fas fa-file-pdf mr-2"></i>Export PDF
                </a>
            </div>
        </form>
    </div>

    {{-- Summary Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl border border-gray-100 p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Pendapatan</p>
                    <p class="text-2xl font-bold text-gray-800">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-money-bill-wave text-green-600 text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl border border-gray-100 p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Pesanan</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $totalOrders }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-shopping-cart text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl border border-gray-100 p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Item Terjual</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $totalItems }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-boxes text-purple-600 text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl border border-gray-100 p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Rata-rata per Pesanan</p>
                    <p class="text-2xl font-bold text-gray-800">Rp {{ number_format($averageOrder, 0, ',', '.') }}</p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-chart-line text-yellow-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Top Products --}}
    <div class="bg-white rounded-xl border border-gray-100 p-6 mb-8 shadow-sm">
        <h3 class="text-lg font-semibold mb-4">🔥 Top 5 Produk Terlaris</h3>
        <div class="space-y-3">
            @forelse($topProducts as $index => $product)
            <div class="flex items-center justify-between py-2 border-b border-gray-100">
                <div class="flex items-center gap-3">
                    <span class="text-2xl font-bold text-gray-300">#{{ $index + 1 }}</span>
                    <div>
                        <p class="font-medium text-gray-800">{{ $product->product->name ?? 'Produk Dihapus' }}</p>
                        <p class="text-sm text-gray-500">{{ $product->total_quantity }} item terjual</p>
                    </div>
                </div>
                <p class="font-semibold text-yellow-600">Rp {{ number_format($product->total_sales, 0, ',', '.') }}</p>
            </div>
            @empty
            <div class="text-center py-4 text-gray-500">
                Belum ada data penjualan
            </div>
            @endforelse
        </div>
    </div>

    {{-- Daily Stats Table --}}
    <div class="bg-white rounded-xl border border-gray-100 overflow-hidden mb-8 shadow-sm">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-lg font-semibold">📅 Statistik Harian</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500">Jumlah Pesanan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500">Pendapatan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($dailyStats as $stat)
                    <tr>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ \Carbon\Carbon::parse($stat->date)->format('d/m/Y') }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $stat->orders }}</td>
                        <td class="px-6 py-4 text-sm font-semibold text-gray-900">Rp {{ number_format($stat->revenue, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-6 py-4 text-center text-gray-500">Belum ada data penjualan</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Orders Table --}}
    <div class="bg-white rounded-xl border border-gray-100 overflow-hidden shadow-sm">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-lg font-semibold">📋 Detail Pesanan</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500">ID Pesanan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500">Pelanggan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500">Total Harga</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($orders as $order)
                    <tr>
                        <td class="px-6 py-4 text-sm text-gray-900">#{{ $order->id }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y H:i') }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $order->user->name ?? 'User tidak ditemukan' }}</td>
                        <td class="px-6 py-4 text-sm font-semibold text-gray-900">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-sm">
                            @php
                                $statusColors = [
                                    'menunggu_konfirmasi' => 'bg-yellow-100 text-yellow-800',
                                    'diproses' => 'bg-blue-100 text-blue-800',
                                    'dikirim' => 'bg-purple-100 text-purple-800',
                                    'selesai' => 'bg-green-100 text-green-800',
                                    'delivered' => 'bg-green-100 text-green-800',
                                ];
                                $statusTexts = [
                                    'menunggu_konfirmasi' => 'Menunggu Konfirmasi',
                                    'diproses' => 'Diproses',
                                    'dikirim' => 'Dikirim',
                                    'selesai' => 'Selesai',
                                    'delivered' => 'Terkirim',
                                ];
                            @endphp
                            <span class="px-2 py-1 text-xs rounded-full {{ $statusColors[$order->status] ?? 'bg-gray-100 text-gray-800' }}">
                                {{ $statusTexts[$order->status] ?? $order->status }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                            <i class="fas fa-inbox mr-2"></i>Belum ada pesanan selesai di periode ini
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
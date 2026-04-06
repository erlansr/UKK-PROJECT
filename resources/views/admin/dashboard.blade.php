
@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-semibold text-gray-900">Dashboard</h1>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4 mt-8">
            {{-- Total Penjualan --}}
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                            <i class="fas fa-money-bill-wave text-white text-xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Penjualan</dt>
                                <dd class="text-lg font-semibold text-gray-900">Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Total Pesanan --}}
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                            <i class="fas fa-shopping-cart text-white text-xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Pesanan</dt>
                                <dd class="text-lg font-semibold text-gray-900">{{ $totalPesanan }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Total User --}}
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                            <i class="fas fa-users text-white text-xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total User</dt>
                                <dd class="text-lg font-semibold text-gray-900">{{ $totalUser }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Produk Aktif --}}
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-purple-500 rounded-md p-3">
                            <i class="fas fa-box text-white text-xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Produk Aktif</dt>
                                <dd class="text-lg font-semibold text-gray-900">{{ \App\Models\Product::where('is_active', true)->count() }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Status Pesanan --}}
        <div class="mt-8">
            <h2 class="text-lg font-medium text-gray-900 mb-4">Status Pesanan</h2>
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-5">
                @foreach($pesananStatus as $status => $count)
                    @php
                        $colors = [
                            'menunggu_konfirmasi' => 'yellow',
                            'diproses' => 'blue',
                            'dikirim' => 'purple',
                            'selesai' => 'green',
                            'ditolak' => 'red'
                        ];
                        $labels = [
                            'menunggu_konfirmasi' => 'Menunggu Konfirmasi',
                            'diproses' => 'Diproses',
                            'dikirim' => 'Dikirim',
                            'selesai' => 'Selesai',
                            'ditolak' => 'Ditolak'
                        ];
                    @endphp
                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="p-5">
                            <div class="flex items-center">
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-500 truncate">{{ $labels[$status] }}</p>
                                    <p class="text-2xl font-semibold text-{{ $colors[$status] }}-600">{{ $count }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Produk Terlaris --}}
        <div class="mt-8">
            <h2 class="text-lg font-medium text-gray-900 mb-4">Produk Terlaris</h2>
            <div class="bg-white shadow overflow-hidden sm:rounded-md">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produk</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Terjual</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($produkTerlaris as $produk)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $produk->product_name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $produk->total_terjual }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="px-6 py-4 text-center text-gray-500">Belum ada data penjualan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
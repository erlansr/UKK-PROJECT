@extends('layouts.admin')

@section('title', 'Detail User - ' . $user->name)

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center mb-6">
            <a href="{{ route('admin.users.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="text-2xl font-semibold text-gray-900">Detail User: {{ $user->name }}</h1>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Informasi User --}}
            <div class="md:col-span-1">
                <div class="bg-white shadow rounded-lg p-6">
                    <h2 class="text-lg font-semibold mb-4">Informasi User</h2>
                    <div class="space-y-3">
                        <div>
                            <span class="text-sm text-gray-600">Nama:</span>
                            <p class="font-medium">{{ $user->name }}</p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-600">Email:</span>
                            <p class="font-medium">{{ $user->email }}</p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-600">No. HP:</span>
                            <p class="font-medium">{{ $user->no_hp }}</p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-600">Status:</span>
                            @if($user->is_active)
                                <span class="ml-2 px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Aktif
                                </span>
                            @else
                                <span class="ml-2 px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    Nonaktif
                                </span>
                            @endif
                        </div>
                        <div>
                            <span class="text-sm text-gray-600">Bergabung:</span>
                            <p class="font-medium">{{ $user->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Riwayat Pesanan --}}
            <div class="md:col-span-2">
                <div class="bg-white shadow rounded-lg p-6">
                    <h2 class="text-lg font-semibold mb-4">Riwayat Pesanan</h2>
                    
                    @if($orders->count() > 0)
                        <table class="w-full">
                            <thead>
                                <tr class="border-b">
                                    <th class="text-left py-2">Invoice</th>
                                    <th class="text-left py-2">Total</th>
                                    <th class="text-left py-2">Status</th>
                                    <th class="text-left py-2">Tanggal</th>
                                    <th class="text-left py-2">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                    <tr class="border-b">
                                        <td class="py-2">{{ $order->invoice_number }}</td>
                                        <td class="py-2">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                                        <td class="py-2">
                                            @php
                                                $statusColors = [
                                                    'menunggu_konfirmasi' => 'bg-yellow-100 text-yellow-800',
                                                    'diproses' => 'bg-blue-100 text-blue-800',
                                                    'dikirim' => 'bg-purple-100 text-purple-800',
                                                    'selesai' => 'bg-green-100 text-green-800',
                                                    'ditolak' => 'bg-red-100 text-red-800'
                                                ];
                                                $statusLabels = [
                                                    'menunggu_konfirmasi' => 'Menunggu Konfirmasi',
                                                    'diproses' => 'Diproses',
                                                    'dikirim' => 'Dikirim',
                                                    'selesai' => 'Selesai',
                                                    'ditolak' => 'Ditolak'
                                                ];
                                            @endphp
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColors[$order->status] }}">
                                                {{ $statusLabels[$order->status] }}
                                            </span>
                                        </td>
                                        <td class="py-2">{{ $order->created_at->format('d/m/Y') }}</td>
                                        <td class="py-2">
                                            <a href="{{ route('admin.orders.show', $order) }}" 
                                               class="text-yellow-600 hover:text-yellow-900">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="mt-4">
                            {{ $orders->links() }}
                        </div>
                    @else
                        <p class="text-center text-gray-500 py-4">User belum memiliki pesanan</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
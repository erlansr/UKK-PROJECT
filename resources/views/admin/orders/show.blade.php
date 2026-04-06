@extends('layouts.admin')

@section('title', 'Detail Pesanan - ' . $order->invoice_number)

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center mb-6">
            <a href="{{ route('admin.orders.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="text-2xl font-semibold text-gray-900">Detail Pesanan: {{ $order->invoice_number }}</h1>
        </div>

        

        {{-- Bagian Update Status --}}
        <div class="bg-white shadow rounded-lg p-6 mb-6">
            <h2 class="text-lg font-semibold mb-4">Update Status Pesanan</h2>
            
            {{-- Info Status Saat Ini --}}
            <div class="mb-4 p-4 bg-gray-50 rounded-lg">
                <p class="text-sm text-gray-600">Status Saat Ini:</p>
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
                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full {{ $statusColors[$order->status] }}">
                    {{ $statusLabels[$order->status] }}
                </span>
                
                @if($order->payment_confirmed)
                    <p class="text-sm text-green-600 mt-2">
                        <i class="fas fa-check-circle mr-1"></i>
                        Pembayaran telah dikonfirmasi pada {{ $order->payment_confirmed_at->format('d/m/Y H:i') }}
                    </p>
                @endif
            </div>

            {{-- Form Update Status --}}
            <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                
                <div class="flex flex-wrap items-end gap-4">
                    <div class="flex-1">
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Pilih Status Baru</label>
                        <select name="status" id="status" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-yellow-500 focus:border-yellow-500">
                            @foreach($statusLabels as $value => $label)
                                <option value="{{ $value }}" {{ $order->status == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" 
                            class="bg-yellow-500 text-gray-900 px-6 py-2 rounded-md hover:bg-yellow-600 transition font-semibold">
                        Update Status
                    </button>
                </div>
            </form>

            {{-- Tombol-tombol Aksi Cepat --}}
            <div class="mt-4 flex flex-wrap gap-2">
                {{-- Tombol Konfirmasi Pembayaran --}}
                @if(!$order->payment_confirmed && $order->status == 'menunggu_konfirmasi')
                    <form action="{{ route('admin.orders.confirm-payment', $order) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" 
                                class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition text-sm"
                                onclick="return confirm('Konfirmasi pembayaran untuk pesanan ini?')">
                            <i class="fas fa-check-circle mr-2"></i>Konfirmasi Pembayaran
                        </button>
                    </form>
                @endif

                {{-- Tombol Proses --}}
                @if($order->status == 'menunggu_konfirmasi' && $order->payment_confirmed)
                    <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" class="inline">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="diproses">
                        <button type="submit" 
                                class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition text-sm">
                            <i class="fas fa-play mr-2"></i>Proses Pesanan
                        </button>
                    </form>
                @endif

                {{-- Tombol Kirim --}}
                @if($order->status == 'diproses')
                    <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" class="inline">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="dikirim">
                        <button type="submit" 
                                class="bg-purple-500 text-white px-4 py-2 rounded-md hover:bg-purple-600 transition text-sm">
                            <i class="fas fa-truck mr-2"></i>Kirim Pesanan
                        </button>
                    </form>
                @endif

                {{-- Tombol Selesai --}}
                @if($order->status == 'dikirim')
                    <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" class="inline">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="selesai">
                        <button type="submit" 
                                class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition text-sm">
                            <i class="fas fa-check mr-2"></i>Selesaikan Pesanan
                        </button>
                    </form>
                @endif

                {{-- Tombol Batalkan --}}
                @if(!in_array($order->status, ['selesai', 'ditolak']))
                    <form action="{{ route('admin.orders.cancel', $order) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" 
                                class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 transition text-sm"
                                onclick="return confirm('Batalkan pesanan ini?')">
                            <i class="fas fa-times mr-2"></i>Batalkan Pesanan
                        </button>
                    </form>
                @endif
            </div>
        </div>

        {{-- Sisa konten lainnya (items, informasi pengiriman, dll) --}}
        {{-- ... --}}
    </div>
</div>
@endsection
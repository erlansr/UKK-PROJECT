@extends('layouts.app')

@section('title', 'Detail Pesanan - ' . $order->invoice_number)

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    {{-- Breadcrumb --}}
    <nav class="flex mb-8" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('home') }}" class="text-gray-700 hover:text-yellow-600">Beranda</a>
            </li>
            <li>
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2 text-sm"></i>
                    <a href="{{ route('orders.index') }}" class="text-gray-700 hover:text-yellow-600">Pesanan Saya</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2 text-sm"></i>
                    <span class="text-gray-500">{{ $order->invoice_number }}</span>
                </div>
            </li>
        </ol>
    </nav>

    {{-- Status --}}
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Detail Pesanan</h1>
                <p class="text-gray-600 mt-1">Invoice: {{ $order->invoice_number }}</p>
            </div>
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
            
            <span class="px-4 py-2 rounded-full text-sm font-semibold {{ $statusColors[$order->status] }}">
                {{ $statusLabels[$order->status] }}
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        {{-- Informasi Pesanan --}}
        <div class="md:col-span-2 space-y-6">
            {{-- Items --}}
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-lg font-semibold mb-4">Item Pesanan</h2>
                <div class="space-y-4">
                    @foreach($order->items as $item)
                        <div class="flex justify-between items-center py-2 border-b last:border-0">
                            <div>
                                <span class="font-medium">{{ $item->product_name }}</span>
                                <span class="text-gray-500 text-sm"> x {{ $item->quantity }}</span>
                                <div class="text-sm text-gray-500">
                                    @ Rp {{ number_format($item->price, 0, ',', '.') }}
                                </div>
                            </div>
                            <span class="font-semibold">
                                Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                            </span>
                        </div>
                    @endforeach
                </div>
                
                <div class="mt-4 pt-4 border-t">
                    <div class="flex justify-between font-semibold text-lg">
                        <span>Total</span>
                        <span class="text-yellow-600">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            {{-- Informasi Pengiriman --}}
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-lg font-semibold mb-4">Informasi Pengiriman</h2>
                <div class="space-y-3">
                    <div>
                        <span class="text-sm text-gray-600">Alamat:</span>
                        <p class="font-medium">{{ $order->alamat }}</p>
                    </div>
                    <div>
                        <span class="text-sm text-gray-600">No. HP:</span>
                        <p class="font-medium">{{ $order->no_hp }}</p>
                    </div>
                    <div>
                        <span class="text-sm text-gray-600">Jasa Pengiriman:</span>
                        <p class="font-medium">{{ $order->jasa_pengiriman }}</p>
                    </div>
                    @if($order->catatan)
                        <div>
                            <span class="text-sm text-gray-600">Catatan:</span>
                            <p class="font-medium">{{ $order->catatan }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Informasi Pembayaran --}}
        <div class="md:col-span-1">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-lg font-semibold mb-4">Informasi Pembayaran</h2>
                
                <div class="space-y-4">
                    <div>
                        <span class="text-sm text-gray-600">Metode Pembayaran:</span>
                        <p class="font-medium">
                            @php
                                $paymentNames = [
                                    'transfer_bca' => 'Transfer Bank BCA',
                                    'transfer_mandiri' => 'Transfer Bank Mandiri',
                                    'transfer_bri' => 'Transfer Bank BRI',
                                    'dana' => 'DANA',
                                    'ovo' => 'OVO',
                                    'gopay' => 'GoPay',
                                    'virtual_account' => 'Virtual Account BCA'
                                ];
                            @endphp
                            {{ $paymentNames[$order->metode_pembayaran] ?? $order->metode_pembayaran }}
                        </p>
                    </div>
                    
                    <div>
                        <span class="text-sm text-gray-600">Status Pembayaran:</span>
                        @if($order->payment_confirmed)
                            <p class="text-green-600 font-medium">Sudah Dikonfirmasi</p>
                            <p class="text-xs text-gray-500">{{ $order->payment_confirmed_at->format('d/m/Y H:i') }}</p>
                        @else
                            <p class="text-yellow-600 font-medium">Menunggu Konfirmasi</p>
                        @endif
                    </div>

                    {{-- Detail Nomor Pembayaran --}}
                    @if(!$order->payment_confirmed && $order->status == 'menunggu_konfirmasi')
                    <div class="border-t pt-3">
                        <div class="bg-gray-50 rounded-lg p-3 border border-gray-200">
                            <p class="text-sm font-semibold text-gray-700 mb-2">📋 Nomor Pembayaran:</p>
                            
                            {{-- Transfer Bank BCA --}}
                            @if($order->metode_pembayaran == 'transfer_bca')
                                <div class="space-y-1">
                                    <p class="text-sm">🏦 Bank: <strong class="text-gray-800">BCA</strong></p>
                                    <p class="text-sm">💳 No. Rekening: <strong class="text-blue-600 font-mono text-base">1234567890</strong></p>
                                    <p class="text-sm">👤 a.n: <strong>PT BatuBara Briket Indonesia</strong></p>
                                    <div class="mt-2 pt-2 border-t border-gray-200">
                                        <p class="text-xs text-yellow-700">✨ Total yang harus ditransfer: <strong>Rp {{ number_format($order->total, 0, ',', '.') }}</strong></p>
                                    </div>
                                </div>
                            
                            {{-- Transfer Bank Mandiri --}}
                            @elseif($order->metode_pembayaran == 'transfer_mandiri')
                                <div class="space-y-1">
                                    <p class="text-sm">🏦 Bank: <strong class="text-gray-800">Mandiri</strong></p>
                                    <p class="text-sm">💳 No. Rekening: <strong class="text-blue-600 font-mono text-base">0987654321</strong></p>
                                    <p class="text-sm">👤 a.n: <strong>PT BatuBara Briket Indonesia</strong></p>
                                    <div class="mt-2 pt-2 border-t border-gray-200">
                                        <p class="text-xs text-yellow-700">✨ Total yang harus ditransfer: <strong>Rp {{ number_format($order->total, 0, ',', '.') }}</strong></p>
                                    </div>
                                </div>
                            
                            {{-- Transfer Bank BRI --}}
                            @elseif($order->metode_pembayaran == 'transfer_bri')
                                <div class="space-y-1">
                                    <p class="text-sm">🏦 Bank: <strong class="text-gray-800">BRI</strong></p>
                                    <p class="text-sm">💳 No. Rekening: <strong class="text-blue-600 font-mono text-base">5678901234</strong></p>
                                    <p class="text-sm">👤 a.n: <strong>PT BatuBara Briket Indonesia</strong></p>
                                    <div class="mt-2 pt-2 border-t border-gray-200">
                                        <p class="text-xs text-yellow-700">✨ Total yang harus ditransfer: <strong>Rp {{ number_format($order->total, 0, ',', '.') }}</strong></p>
                                    </div>
                                </div>
                            
                            {{-- DANA --}}
                            @elseif($order->metode_pembayaran == 'dana')
                                <div class="space-y-1">
                                    <p class="text-sm">📱 E-Wallet: <strong class="text-gray-800">DANA</strong></p>
                                    <p class="text-sm">🔢 No. Akun: <strong class="text-blue-600 font-mono text-base">088212345678</strong></p>
                                    <p class="text-sm">👤 a.n: <strong>PT BatuBara Briket Indonesia</strong></p>
                                    <div class="mt-2 pt-2 border-t border-gray-200">
                                        <p class="text-xs text-yellow-700">✨ Total pembayaran: <strong>Rp {{ number_format($order->total, 0, ',', '.') }}</strong></p>
                                    </div>
                                </div>
                            
                            {{-- OVO --}}
                            @elseif($order->metode_pembayaran == 'ovo')
                                <div class="space-y-1">
                                    <p class="text-sm">📱 E-Wallet: <strong class="text-gray-800">OVO</strong></p>
                                    <p class="text-sm">🔢 No. Akun: <strong class="text-blue-600 font-mono text-base">088212345679</strong></p>
                                    <p class="text-sm">👤 a.n: <strong>PT BatuBara Briket Indonesia</strong></p>
                                    <div class="mt-2 pt-2 border-t border-gray-200">
                                        <p class="text-xs text-yellow-700">✨ Total pembayaran: <strong>Rp {{ number_format($order->total, 0, ',', '.') }}</strong></p>
                                    </div>
                                </div>
                            
                            {{-- GoPay --}}
                            @elseif($order->metode_pembayaran == 'gopay')
                                <div class="space-y-1">
                                    <p class="text-sm">📱 E-Wallet: <strong class="text-gray-800">GoPay</strong></p>
                                    <p class="text-sm">🔢 No. Akun: <strong class="text-blue-600 font-mono text-base">088212345680</strong></p>
                                    <p class="text-sm">👤 a.n: <strong>PT BatuBara Briket Indonesia</strong></p>
                                    <div class="mt-2 pt-2 border-t border-gray-200">
                                        <p class="text-xs text-yellow-700">✨ Total pembayaran: <strong>Rp {{ number_format($order->total, 0, ',', '.') }}</strong></p>
                                    </div>
                                </div>
                            
                            {{-- Virtual Account --}}
                            @elseif($order->metode_pembayaran == 'virtual_account')
                                <div class="space-y-1">
                                    <p class="text-sm">💳 Virtual Account: <strong class="text-gray-800">BCA</strong></p>
                                    <p class="text-sm">🔢 No. VA: <strong class="text-blue-600 font-mono text-base">88881234567890</strong></p>
                                    <p class="text-sm">👤 a.n: <strong>PT BatuBara Briket Indonesia</strong></p>
                                    <div class="mt-2 pt-2 border-t border-gray-200">
                                        <p class="text-xs text-yellow-700">✨ Total pembayaran: <strong>Rp {{ number_format($order->total, 0, ',', '.') }}</strong></p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    @endif

                    <div class="border-t pt-4">
                        <p class="text-sm text-gray-600">Tanggal Pesan:</p>
                        <p class="font-medium">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                    </div>

                    @if($order->status === 'menunggu_konfirmasi')
                        <div class="bg-yellow-50 border border-yellow-200 rounded-md p-3">
                            <p class="text-sm text-yellow-800">
                                <i class="fas fa-info-circle mr-2"></i>
                                Silahkan transfer ke nomor rekening/akun di atas, lalu konfirmasi ke admin.
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
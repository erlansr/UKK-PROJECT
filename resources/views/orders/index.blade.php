@extends('layouts.app')

@section('title', 'Pesanan Saya')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    {{-- Header Section --}}
    <div class="mb-8">
        <h1 class="text-4xl font-bold bg-gradient-to-r from-gray-900 to-gray-600 bg-clip-text text-transparent">
            Pesanan Saya
        </h1>
        <p class="text-gray-500 mt-2">Kelola dan lacak semua pesanan Anda</p>
    </div>

    @if(session('success'))
        <div class="bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 text-green-700 px-6 py-4 rounded-lg shadow-sm mb-8 animate-fade-in">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if($orders->count() > 0)
        <div class="space-y-6">
            @foreach($orders as $order)
                {{-- Order Card --}}
                <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100">
                    
                    {{-- Header Order --}}
                    <div class="bg-gradient-to-r from-gray-50 to-white px-6 py-4 border-b border-gray-100">
                        <div class="flex flex-wrap items-center justify-between gap-3">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <span class="text-xs text-gray-500 uppercase tracking-wide">No. Invoice</span>
                                    <p class="font-semibold text-gray-900">{{ $order->invoice_number }}</p>
                                </div>
                            </div>
                            
                            <div class="flex flex-wrap items-center gap-3">
                                @php
                                    $statusColors = [
                                        'menunggu_konfirmasi' => 'bg-amber-50 text-amber-700 border-amber-200',
                                        'diproses' => 'bg-blue-50 text-blue-700 border-blue-200',
                                        'dikirim' => 'bg-purple-50 text-purple-700 border-purple-200',
                                        'selesai' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                        'ditolak' => 'bg-red-50 text-red-700 border-red-200'
                                    ];
                                    
                                    $statusLabels = [
                                        'menunggu_konfirmasi' => 'Menunggu Konfirmasi',
                                        'diproses' => 'Diproses',
                                        'dikirim' => 'Dikirim',
                                        'selesai' => 'Selesai',
                                        'ditolak' => 'Ditolak'
                                    ];
                                    
                                    $statusIcons = [
                                        'menunggu_konfirmasi' => 'M',
                                        'diproses' => 'P',
                                        'dikirim' => 'K',
                                        'selesai' => 'S',
                                        'ditolak' => 'X'
                                    ];
                                @endphp
                                
                                <div class="flex items-center space-x-2">
                                    <span class="px-3 py-1.5 rounded-lg text-xs font-semibold border {{ $statusColors[$order->status] }}">
                                        {{ $statusLabels[$order->status] }}
                                    </span>
                                    <div class="flex items-center text-gray-400 text-sm">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        {{ $order->created_at->format('d/m/Y H:i') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Items Order --}}
                    <div class="px-6 py-5">
                        <div class="space-y-3">
                            @foreach($order->items as $item)
                                <div class="flex justify-between items-center py-2 hover:bg-gray-50 px-3 rounded-lg transition-colors duration-200 {{ !$loop->last ? 'border-b border-gray-100' : '' }}">
                                    <div class="flex-1">
                                        <span class="font-medium text-gray-800">{{ $item->product_name }}</span>
                                        <span class="text-gray-400 text-sm ml-2">x {{ $item->quantity }}</span>
                                    </div>
                                    <span class="font-semibold text-gray-900">
                                        Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Footer Order --}}
                    <div class="bg-gray-50 px-6 py-4 flex flex-wrap justify-between items-center gap-4">
                        <div class="flex items-baseline space-x-2">
                            <span class="text-sm text-gray-500">Total Pesanan</span>
                            <span class="text-2xl font-bold bg-gradient-to-r from-yellow-600 to-yellow-500 bg-clip-text text-transparent">
                                Rp {{ number_format($order->total, 0, ',', '.') }}
                            </span>
                        </div>
                        
                        <a href="{{ route('orders.show', $order) }}" 
                           class="group relative inline-flex items-center justify-center px-6 py-2.5 overflow-hidden font-medium text-gray-900 transition duration-300 ease-out border-2 border-gray-900 rounded-lg shadow-md hover:shadow-lg hover:bg-gray-900 hover:text-white">
                            <span class="absolute inset-0 flex items-center justify-center w-full h-full text-white duration-300 -translate-x-full bg-gray-900 group-hover:translate-x-0 ease">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </span>
                            <span class="absolute flex items-center justify-center w-full h-full text-gray-900 transition-all duration-300 transform group-hover:translate-x-full">
                                Lihat Detail
                            </span>
                            <span class="relative invisible">Lihat Detail</span>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-10">
            {{ $orders->links() }}
        </div>
        
    @else
        {{-- Empty State --}}
        <div class="text-center py-16 bg-gradient-to-br from-gray-50 to-white rounded-2xl shadow-sm">
            <div class="mb-6 relative">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                    </svg>
                </div>
                <div class="absolute inset-0 flex items-center justify-center">
                    <div class="w-32 h-32 bg-gradient-to-r from-yellow-400/20 to-orange-400/20 rounded-full blur-2xl"></div>
                </div>
            </div>
            
            <h3 class="text-2xl font-semibold text-gray-700 mb-2">Belum Ada Pesanan</h3>
            <p class="text-gray-400 mb-8 max-w-sm mx-auto">
                Anda belum melakukan pemesanan apapun. Yuk mulai belanja sekarang!
            </p>
            
            <a href="{{ route('products.index') }}" 
               class="inline-flex items-center justify-center px-8 py-3 text-base font-semibold text-gray-900 bg-gradient-to-r from-yellow-400 to-orange-400 rounded-lg shadow-md hover:shadow-lg hover:from-yellow-500 hover:to-orange-500 transition-all duration-300 transform hover:-translate-y-0.5">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
                Mulai Belanja
            </a>
        </div>
    @endif
</div>

{{-- Custom Animations --}}
<style>
    @keyframes fade-in {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .animate-fade-in {
        animation: fade-in 0.5s ease-out;
    }
</style>
@endsection
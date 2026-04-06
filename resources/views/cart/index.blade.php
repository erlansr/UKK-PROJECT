@extends('layouts.app')

@section('title', 'Keranjang Belanja')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    {{-- Header Simple Elegan --}}
    <div class="mb-8">
        <div class="flex items-baseline gap-3 flex-wrap">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-800 tracking-tight">
                🛒 Keranjang
            </h1>
            <span class="text-gray-400 text-lg">/</span>
            <span class="text-lg text-gray-500 font-medium">belanjaku</span>
        </div>
        <div class="flex items-center gap-2 mt-2">
            <div class="h-0.5 w-12 bg-yellow-400 rounded-full"></div>
            <p class="text-gray-400 text-sm">yuk selesaikan pesananmu</p>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if($carts->count() > 0)
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Cart Items --}}
            <div class="lg:col-span-2">
                {{-- Desktop Table View (hidden on mobile) --}}
                <div class="hidden md:block bg-white rounded-lg shadow-md overflow-hidden">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produk</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($carts as $cart)
                            <tr>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        @if($cart->product->image)
                                            <img src="{{ asset($cart->product->image) }}" alt="{{ $cart->product->name }}" 
                                                 class="w-16 h-16 object-cover rounded">
                                        @else
                                            <div class="w-16 h-16 bg-gray-200 rounded flex items-center justify-center">
                                                <i class="fas fa-box text-gray-400"></i>
                                            </div>
                                        @endif
                                        <div class="ml-4">
                                            <a href="{{ route('products.show', $cart->product->slug) }}" 
                                               class="text-sm font-medium text-gray-900 hover:text-yellow-600">
                                                {{ $cart->product->name }}
                                            </a>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    Rp {{ number_format($cart->product->price, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4">
                                    <form action="{{ route('cart.update', $cart) }}" method="POST" class="flex items-center space-x-2">
                                        @csrf
                                        @method('PUT')
                                        <input type="number" 
                                               name="quantity" 
                                               value="{{ $cart->quantity }}" 
                                               min="1" 
                                               max="{{ $cart->product->stock }}"
                                               class="w-16 text-center border border-gray-300 rounded-md py-1 focus:outline-none focus:ring-yellow-500 focus:border-yellow-500">
                                        <button type="submit" 
                                                class="text-yellow-600 hover:text-yellow-800"
                                                title="Update">
                                            <i class="fas fa-sync-alt"></i>
                                        </button>
                                    </form>
                                </td>
                                <td class="px-6 py-4 text-sm font-semibold text-gray-900">
                                    Rp {{ number_format($cart->product->price * $cart->quantity, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4">
                                    <form action="{{ route('cart.remove', $cart) }}" method="POST" onsubmit="return confirm('Hapus item ini dari keranjang?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Mobile Card View (visible only on mobile) --}}
                <div class="block md:hidden space-y-4">
                    @foreach($carts as $cart)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="p-4">
                            {{-- Product Header --}}
                            <div class="flex items-start space-x-4">
                                @if($cart->product->image)
                                    <img src="{{ asset($cart->product->image) }}" alt="{{ $cart->product->name }}" 
                                         class="w-20 h-20 object-cover rounded">
                                @else
                                    <div class="w-20 h-20 bg-gray-200 rounded flex items-center justify-center">
                                        <i class="fas fa-box text-gray-400 text-2xl"></i>
                                    </div>
                                @endif
                                
                                <div class="flex-1">
                                    <a href="{{ route('products.show', $cart->product->slug) }}" 
                                       class="text-base font-semibold text-gray-900 hover:text-yellow-600 block">
                                        {{ $cart->product->name }}
                                    </a>
                                    
                                    <div class="mt-2 space-y-2">
                                        {{-- Price --}}
                                        <div class="flex justify-between items-center">
                                            <span class="text-sm text-gray-500">Harga</span>
                                            <span class="text-sm font-semibold text-gray-900">
                                                Rp {{ number_format($cart->product->price, 0, ',', '.') }}
                                            </span>
                                        </div>
                                        
                                        {{-- Quantity --}}
                                        <div class="flex justify-between items-center">
                                            <span class="text-sm text-gray-500">Jumlah</span>
                                            <form action="{{ route('cart.update', $cart) }}" method="POST" class="flex items-center space-x-2">
                                                @csrf
                                                @method('PUT')
                                                <input type="number" 
                                                       name="quantity" 
                                                       value="{{ $cart->quantity }}" 
                                                       min="1" 
                                                       max="{{ $cart->product->stock }}"
                                                       class="w-20 text-center border border-gray-300 rounded-md py-1 text-sm focus:outline-none focus:ring-yellow-500 focus:border-yellow-500">
                                                <button type="submit" 
                                                        class="text-yellow-600 hover:text-yellow-800"
                                                        title="Update">
                                                    <i class="fas fa-sync-alt"></i>
                                                </button>
                                            </form>
                                        </div>
                                        
                                        {{-- Subtotal --}}
                                        <div class="flex justify-between items-center border-t pt-2 mt-2">
                                            <span class="text-sm font-semibold text-gray-700">Subtotal</span>
                                            <span class="text-base font-bold text-yellow-600">
                                                Rp {{ number_format($cart->product->price * $cart->quantity, 0, ',', '.') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            {{-- Action Buttons --}}
                            <div class="mt-4 pt-3 border-t flex justify-end">
                                <form action="{{ route('cart.remove', $cart) }}" method="POST" onsubmit="return confirm('Hapus item ini dari keranjang?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 flex items-center space-x-1 px-3 py-2 rounded-md hover:bg-red-50 transition">
                                        <i class="fas fa-trash"></i>
                                        <span class="text-sm">Hapus</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Cart Summary --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-md p-6 sticky top-4">
                    <h2 class="text-lg font-semibold mb-4">Ringkasan Belanja</h2>
                    
                    <div class="space-y-3 mb-4">
                        <div class="flex justify-between text-gray-600">
                            <span>Total Harga ({{ $carts->sum('quantity') }} item)</span>
                            <span class="font-semibold">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <a href="{{ route('checkout.index') }}" 
                       class="block w-full bg-yellow-500 text-gray-900 text-center py-3 rounded-md hover:bg-yellow-600 transition font-semibold">
                        Lanjut ke Checkout
                    </a>

                    <a href="{{ route('products.index') }}" 
                       class="block w-full text-center text-gray-600 hover:text-yellow-600 mt-4">
                        <i class="fas fa-arrow-left mr-2"></i>Lanjut Belanja
                    </a>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-12">
            <div class="mb-4">
                <i class="fas fa-shopping-cart text-6xl text-gray-400"></i>
            </div>
            <h3 class="text-xl font-semibold text-gray-600 mb-2">Keranjang Belanja Kosong</h3>
            <p class="text-gray-500 mb-6">Anda belum menambahkan produk apapun ke keranjang.</p>
            <a href="{{ route('products.index') }}" 
               class="inline-block bg-yellow-500 text-gray-900 px-6 py-3 rounded-md hover:bg-yellow-600 transition font-semibold">
                Mulai Belanja
            </a>
        </div>
    @endif
</div>
@endsection
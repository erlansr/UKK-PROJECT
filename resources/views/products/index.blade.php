@extends('layouts.app')

@section('title', 'Daftar Produk - Batu Bara & Briket')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    {{-- Header Elegan --}}
    <div class="mb-10">
        <div class="flex items-baseline gap-3 flex-wrap">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-800 tracking-tight">
                ✨ Produk
            </h1>
            <span class="text-gray-400 text-lg">/</span>
            <span class="text-lg text-gray-500 font-medium">koleksi kami</span>
        </div>
        <div class="flex items-center gap-2 mt-2">
            <div class="h-0.5 w-12 bg-yellow-400 rounded-full"></div>
            <p class="text-gray-400 text-sm">batu bara & briket berkualitas</p>
        </div>
    </div>

    {{-- Search & Filter Minimalis --}}
    <div class="mb-10">
        <form action="{{ route('products.index') }}" method="GET" class="flex flex-col md:flex-row gap-3">
            <div class="flex-1 relative">
                <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Cari produk..." 
                       class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent bg-gray-50 hover:bg-white transition">
            </div>
            <div class="md:w-52 relative">
                <i class="fas fa-sort-amount-down absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
                <select name="sort" class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent bg-gray-50 hover:bg-white transition appearance-none cursor-pointer">
                    <option value="">Urutkan</option>
                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Harga Terendah</option>
                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Harga Tertinggi</option>
                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Terbaru</option>
                </select>
                <i class="fas fa-chevron-down absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-xs pointer-events-none"></i>
            </div>
            <button type="submit" class="bg-gray-900 text-white px-8 py-2.5 rounded-xl hover:bg-gray-800 transition font-medium text-sm">
                Terapkan
            </button>
        </form>
    </div>

    {{-- Products Grid --}}
    @if($products->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($products as $product)
            {{-- Card dengan background sangat soft + border hover --}}
            <div class="group bg-gray-50 rounded-xl border border-gray-100 hover:border-yellow-200 hover:bg-white hover:shadow-md transition-all duration-300">
                <a href="{{ route('products.show', $product->slug) }}" class="block overflow-hidden rounded-t-xl">
                    @if($product->image)
                        <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" 
                             class="w-full h-48 object-cover group-hover:scale-105 transition duration-500 rounded-t-xl">
                    @else
                        <div class="w-full h-48 bg-gray-100 flex items-center justify-center rounded-t-xl">
                            <i class="fas fa-box-open text-4xl text-gray-300"></i>
                        </div>
                    @endif
                </a>
                <div class="p-4">
                    <a href="{{ route('products.show', $product->slug) }}">
                        <h3 class="font-semibold text-gray-800 mb-1 group-hover:text-yellow-600 transition line-clamp-1">{{ $product->name }}</h3>
                    </a>
                    <p class="text-gray-400 text-xs mb-3">{{ Str::limit($product->description, 60) }}</p>
                    
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-yellow-600 font-bold text-lg">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                        <span class="text-xs {{ $product->stock > 0 ? 'text-green-500' : 'text-red-400' }}">
                            @if($product->stock > 0)
                                <i class="fas fa-check-circle mr-1"></i>Tersedia
                            @else
                                <i class="fas fa-times-circle mr-1"></i>Habis
                            @endif
                        </span>
                    </div>
                    
                    @auth
                        @if($product->stock > 0)
                            <form action="{{ route('cart.add', $product) }}" method="POST">
                                @csrf
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" 
                                        class="w-full bg-yellow-400 hover:bg-yellow-500 text-gray-800 py-2 rounded-lg transition font-medium text-sm flex items-center justify-center gap-2">
                                    <i class="fas fa-plus"></i>
                                    <span>Keranjang</span>
                                </button>
                            </form>
                        @else
                            <button disabled class="w-full bg-gray-200 text-gray-400 py-2 rounded-lg cursor-not-allowed text-sm">
                                Stok Habis
                            </button>
                        @endif
                    @else
                        <a href="{{ route('login') }}" 
                           class="block w-full text-center bg-gray-200 text-gray-600 py-2 rounded-lg hover:bg-gray-300 transition text-sm">
                            Login dulu yuk
                        </a>
                    @endauth
                </div>
            </div>
            @endforeach
        </div>

        {{-- Pagination Styling --}}
        <div class="mt-10">
            {{ $products->withQueryString()->links() }}
        </div>
    @else
        <div class="text-center py-16 bg-gray-50 rounded-2xl">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gray-100 rounded-full mb-4">
                <i class="fas fa-box-open text-3xl text-gray-400"></i>
            </div>
            <h3 class="text-xl font-medium text-gray-700 mb-1">Belum ada produk</h3>
            <p class="text-gray-400 text-sm">Produk akan segera hadir ya, stay tuned!</p>
        </div>
    @endif
</div>
@endsection
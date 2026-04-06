@extends('layouts.app')

@section('title', $product->name . ' - Batu Bara & Briket')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    {{-- Breadcrumb --}}
    <nav class="flex mb-8" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('home') }}" class="text-gray-700 hover:text-yellow-600">Beranda</a>
            </li>
            <li>
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2 text-sm"></i>
                    <a href="{{ route('products.index') }}" class="text-gray-700 hover:text-yellow-600">Produk</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2 text-sm"></i>
                    <span class="text-gray-500">{{ $product->name }}</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-8">
            
            {{-- Product Image --}}
            <div>
                @if($product->image)
                    <img src="{{ asset($product->image) }}" 
                         alt="{{ $product->name }}" 
                         class="w-full rounded-lg">
                @else
                    <div class="w-full h-96 bg-gray-200 rounded-lg flex items-center justify-center">
                        <i class="fas fa-box text-8xl text-gray-400"></i>
                    </div>
                @endif
            </div>

            {{-- Product Details --}}
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-4">
                    {{ $product->name }}
                </h1>
                
                <div class="mb-6">
                    <span class="text-3xl font-bold text-yellow-600">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </span>
                </div>

                <div class="mb-6">
                    <div class="flex items-center mb-2">
                        <span class="text-gray-600 w-24">Stok:</span>
                        <span class="{{ $product->stock > 0 ? 'text-green-600 font-semibold' : 'text-red-600 font-semibold' }}">
                            {{ $product->stock > 0 ? $product->stock . ' tersedia' : 'Stok habis' }}
                        </span>
                    </div>
                    
                    <div class="flex items-center">
                        <span class="text-gray-600 w-24">Status:</span>
                        @if($product->stock > 0)
                            <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-semibold">
                                Tersedia
                            </span>
                        @else
                            <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-semibold">
                                Stok Habis
                            </span>
                        @endif
                    </div>
                </div>

                <div class="mb-8">
                    <h3 class="text-lg font-semibold mb-2">Deskripsi Produk</h3>
                    <p class="text-gray-700 leading-relaxed">
                        {{ $product->description }}
                    </p>
                </div>

                @auth
                    @if($product->stock > 0)
                        <form action="{{ route('cart.add', $product) }}" method="POST" class="space-y-4">
                            @csrf

                            <div>
                                <label for="quantity" class="block text-sm font-medium text-gray-700 mb-2">
                                    Jumlah
                                </label>

                                <div class="flex items-center space-x-4">
                                    
                                    <button type="button" 
                                            id="btn-minus"
                                            class="w-10 h-10 bg-gray-200 rounded-md hover:bg-gray-300">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    
                                    <input type="number" 
                                           id="quantity" 
                                           name="quantity" 
                                           value="1" 
                                           min="1" 
                                           max="{{ $product->stock }}"
                                           data-max="{{ $product->stock }}"
                                           class="w-20 text-center border border-gray-300 rounded-md py-2 focus:ring-yellow-500 focus:border-yellow-500">
                                    
                                    <button type="button" 
                                            id="btn-plus"
                                            class="w-10 h-10 bg-gray-200 rounded-md hover:bg-gray-300">
                                        <i class="fas fa-plus"></i>
                                    </button>

                                </div>
                            </div>

                            <button type="submit" 
                                    class="w-full bg-yellow-500 text-gray-900 py-3 rounded-md hover:bg-yellow-600 transition font-semibold text-lg">
                                <i class="fas fa-cart-plus mr-2"></i>
                                Tambah ke Keranjang
                            </button>

                        </form>

                        {{-- Clean JavaScript --}}
                        <script>
                        document.addEventListener("DOMContentLoaded", function () {

                            const input = document.getElementById("quantity");
                            const btnPlus = document.getElementById("btn-plus");
                            const btnMinus = document.getElementById("btn-minus");

                            const maxStock = parseInt(input.dataset.max);

                            btnPlus.addEventListener("click", function () {
                                let value = parseInt(input.value);
                                if (value < maxStock) {
                                    input.value = value + 1;
                                }
                            });

                            btnMinus.addEventListener("click", function () {
                                let value = parseInt(input.value);
                                if (value > 1) {
                                    input.value = value - 1;
                                }
                            });

                        });
                        </script>

                    @else
                        <button disabled 
                                class="w-full bg-gray-300 text-gray-600 py-3 rounded-md cursor-not-allowed font-semibold text-lg">
                            Stok Habis
                        </button>
                    @endif
                @else
                    <a href="{{ route('login') }}" 
                       class="block w-full text-center bg-gray-900 text-white py-3 rounded-md hover:bg-gray-800 transition font-semibold text-lg">
                        Login untuk Membeli
                    </a>
                @endauth

            </div>
        </div>
    </div>
</div>
@endsection
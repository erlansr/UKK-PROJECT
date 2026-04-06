@extends('layouts.app')

@section('title', 'Beranda - Batu Bara & Briket UMKM')

@section('content')
{{-- Hero Section Full Screen dengan Gambar Batu Bara --}}
<div class="relative min-h-screen bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 overflow-hidden -mt-8">
    {{-- Background Image dengan Efek Soft Parallax --}}
    <div class="absolute inset-0">
        {{-- Gambar Batu Bara Utama dengan Opacity Lebih Soft --}}
        <div class="absolute inset-0 bg-cover bg-center bg-no-repeat transition-all duration-1000 md:scale-105 hero-background"
             style="background-image: url('https://images.unsplash.com/photo-1581091226033-d5c48150dbaa?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80');">
        </div>
        
        {{-- Overlay Gradient yang Lebih Soft --}}
        <div class="absolute inset-0 bg-gradient-to-r from-gray-900 via-gray-900/70 to-transparent"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-transparent to-gray-900/20"></div>
    </div>

    {{-- Efek Partikel Minimalis --}}
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        {{-- Partikel Halus --}}
        <div class="absolute top-1/4 left-[10%] w-32 h-32 bg-gradient-to-br from-yellow-600/5 to-transparent rounded-full blur-2xl animate-float-slow"></div>
        <div class="absolute bottom-1/3 right-[5%] w-40 h-40 bg-gradient-to-tl from-yellow-600/5 to-transparent rounded-full blur-2xl animate-float-slow delay-1000"></div>
        <div class="absolute top-2/3 left-[20%] w-24 h-24 bg-gradient-to-r from-yellow-600/5 to-transparent rounded-full blur-2xl animate-pulse-slow"></div>
        
        {{-- Partikel Kecil Halus --}}
        @for($i = 0; $i < 15; $i++)
            <div class="absolute w-0.5 h-0.5 bg-yellow-500/20 rounded-full"
                 style="top: {{ rand(0, 100) }}%; left: {{ rand(0, 100) }}%; animation: float-particle {{ rand(5, 12) }}s infinite ease-in-out; animation-delay: {{ rand(0, 6) }}s;">
            </div>
        @endfor
    </div>

    {{-- Content dengan Layout Elegan --}}
    <div class="relative min-h-screen flex items-center justify-center px-4 sm:px-6 lg:px-8 z-10">
        <div class="text-center max-w-4xl mx-auto">
            {{-- Badge Soft dengan Efek Glassmorphism --}}
           

            <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-light text-white mb-6 leading-tight tracking-tight">
                <span class="inline-block animate-slide-in-left font-medium">Batu Bara</span>
                <span class="inline-block text-yellow-400/90 font-medium animate-slide-in-right">Premium</span>
                <br>
                <span class="inline-block text-2xl sm:text-3xl md:text-4xl text-white/70 font-light animate-slide-in-left-delay tracking-wide">Solusi Energi Premium</span>
            </h1>
            
            <p class="text-base md:text-lg text-white/60 mb-12 max-w-2xl mx-auto animate-fade-in-up-delay leading-relaxed font-light">
                Menghadirkan batu bara dan briket kualitas terbaik untuk kebutuhan industri dan rumah tangga Anda. 
                Berkualitas, terpercaya, dan ramah lingkungan.
            </p>
            
            <div class="flex flex-col sm:flex-row gap-5 justify-center animate-fade-in-up-delay-2">
                <a href="{{ route('products.index') }}"
                    class="group inline-flex items-center justify-center bg-gradient-to-r from-yellow-500/90 to-yellow-600/90 text-gray-900 px-8 py-3.5 rounded-full font-medium text-base hover:from-yellow-500 hover:to-yellow-600 transition-all duration-300 shadow-lg shadow-yellow-500/20 hover:shadow-xl hover:shadow-yellow-500/30 transform hover:-translate-y-0.5 backdrop-blur-sm min-w-[180px]">
                    <span>Jelajahi Koleksi</span>
                    <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                    </svg>
                </a>
                
                <a href="#keunggulan"
                    class="group inline-flex items-center justify-center bg-white/5 backdrop-blur-sm border border-white/20 text-white/80 px-8 py-3.5 rounded-full font-medium text-base hover:bg-white/10 hover:border-white/30 transition-all duration-300 transform hover:-translate-y-0.5 min-w-[180px]">
                    <span>Tentang Kami</span>
                    <svg class="w-4 h-4 ml-2 group-hover:translate-y-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                    </svg>
                </a>
            </div>

            {{-- Scroll Indicator Minimalis --}}
            <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
                <a href="#keunggulan" class="text-white/30 hover:text-white/50 transition-colors">
                    <div class="w-8 h-12 flex items-center justify-center rounded-full border border-white/20 backdrop-blur-sm">
                        <i class="fas fa-chevron-down text-sm"></i>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

{{-- Rest of the content --}}
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    {{-- Keunggulan --}}
    <div id="keunggulan" class="mb-28 scroll-mt-20 pt-20">
        <div class="text-center mb-14 animate-fade-in-up">
            <span class="text-yellow-600/80 font-light text-sm tracking-[0.2em] uppercase">Mengapa Memilih Kami</span>
            <h2 class="text-3xl md:text-4xl font-light text-gray-900 mb-3 tracking-tight">Keistimewaan Produk</h2>
            <div class="w-16 h-px bg-gradient-to-r from-transparent via-yellow-500/50 to-transparent mx-auto mt-4"></div>
            <p class="text-gray-500 max-w-2xl mx-auto mt-4 font-light">Kualitas premium dengan berbagai keunggulan untuk kebutuhan energi Anda</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="group bg-white/50 backdrop-blur-sm rounded-2xl p-8 shadow-sm hover:shadow-md transition-all duration-500 hover:-translate-y-1 animate-fade-in-up border border-white/20" style="animation-delay: 100ms">
                <div class="relative">
                    <div class="w-14 h-14 bg-gradient-to-br from-yellow-50 to-yellow-100/50 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-105 transition-all duration-300">
                        <i class="fas fa-fire text-2xl text-yellow-600/70 group-hover:text-yellow-600 transition-colors"></i>
                    </div>
                    <h3 class="text-xl font-medium text-gray-900 mb-3">Panas Optimal</h3>
                    <p class="text-gray-500 leading-relaxed font-light">Menghasilkan panas yang stabil dan efisien untuk kebutuhan industri maupun rumah tangga</p>
                </div>
            </div>

            <div class="group bg-white/50 backdrop-blur-sm rounded-2xl p-8 shadow-sm hover:shadow-md transition-all duration-500 hover:-translate-y-1 animate-fade-in-up border border-white/20" style="animation-delay: 200ms">
                <div class="relative">
                    <div class="w-14 h-14 bg-gradient-to-br from-green-50 to-green-100/50 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-105 transition-all duration-300">
                        <i class="fas fa-leaf text-2xl text-green-600/70 group-hover:text-green-600 transition-colors"></i>
                    </div>
                    <h3 class="text-xl font-medium text-gray-900 mb-3">Ramah Lingkungan</h3>
                    <p class="text-gray-500 leading-relaxed font-light">Emisi rendah dan bahan baku alami untuk lingkungan yang lebih bersih</p>
                </div>
            </div>

            <div class="group bg-white/50 backdrop-blur-sm rounded-2xl p-8 shadow-sm hover:shadow-md transition-all duration-500 hover:-translate-y-1 animate-fade-in-up border border-white/20" style="animation-delay: 300ms">
                <div class="relative">
                    <div class="w-14 h-14 bg-gradient-to-br from-blue-50 to-blue-100/50 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-105 transition-all duration-300">
                        <i class="fas fa-truck text-2xl text-blue-600/70 group-hover:text-blue-600 transition-colors"></i>
                    </div>
                    <h3 class="text-xl font-medium text-gray-900 mb-3">Distribusi Terjamin</h3>
                    <p class="text-gray-500 leading-relaxed font-light">Pengiriman ke seluruh Indonesia dengan sistem logistik yang handal</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Statistik Section dengan Desain Minimalis --}}
    <div class="mb-28">
        <div class="bg-gradient-to-r from-gray-900 to-gray-800/90 rounded-3xl p-10 text-white relative overflow-hidden">
            {{-- Background Soft --}}
            <div class="absolute inset-0 opacity-5">
                <div class="absolute inset-0 bg-cover bg-center"
                     style="background-image: url('https://images.unsplash.com/photo-1581091226033-d5c48150dbaa?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80');">
                </div>
            </div>
            
            {{-- Efek Soft Glow --}}
            <div class="absolute inset-0 opacity-30 pointer-events-none">
                <div class="absolute top-0 left-0 w-48 h-48 bg-yellow-500/10 rounded-full filter blur-3xl"></div>
                <div class="absolute bottom-0 right-0 w-48 h-48 bg-yellow-500/10 rounded-full filter blur-3xl"></div>
            </div>
            
            <div class="relative grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                <div class="group">
                    <div class="text-3xl md:text-4xl font-light text-yellow-400/90 mb-2">500+</div>
                    <div class="text-white/50 text-sm tracking-wide">Pelanggan Puas</div>
                    <div class="w-8 h-px bg-white/10 mx-auto mt-3 group-hover:w-12 transition-all"></div>
                </div>
                <div class="group">
                    <div class="text-3xl md:text-4xl font-light text-yellow-400/90 mb-2">50+</div>
                    <div class="text-white/50 text-sm tracking-wide">Varian Produk</div>
                    <div class="w-8 h-px bg-white/10 mx-auto mt-3 group-hover:w-12 transition-all"></div>
                </div>
                <div class="group">
                    <div class="text-3xl md:text-4xl font-light text-yellow-400/90 mb-2">24/7</div>
                    <div class="text-white/50 text-sm tracking-wide">Dukungan Pelanggan</div>
                    <div class="w-8 h-px bg-white/10 mx-auto mt-3 group-hover:w-12 transition-all"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- Produk Unggulan dengan Desain Elegan --}}
    <div class="mb-28">
        <div class="flex flex-col sm:flex-row items-center justify-between mb-12 animate-fade-in-up">
            <div class="text-center sm:text-left mb-4 sm:mb-0">
                <span class="text-yellow-600/80 font-light text-sm tracking-[0.2em] uppercase">Koleksi Terbaik</span>
                <h2 class="text-3xl md:text-4xl font-light text-gray-900 mb-2 tracking-tight">Produk Unggulan</h2>
                <div class="w-12 h-px bg-gradient-to-r from-yellow-500/50 to-transparent mt-3"></div>
            </div>
            <a href="{{ route('products.index') }}" class="inline-flex items-center text-gray-500 hover:text-yellow-600 text-sm font-light transition-colors group">
                <span>Lihat Semua</span>
                <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($products as $index => $product)
            <div class="group bg-white rounded-xl shadow-sm hover:shadow-lg transition-all duration-500 overflow-hidden animate-fade-in-up border border-gray-100" style="animation-delay: {{ 100 + ($index * 100) }}ms">
                <div class="relative overflow-hidden h-48 bg-gradient-to-br from-gray-50 to-gray-100">
                    @if($product->image)
                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}"
                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 opacity-90 group-hover:opacity-100">
                    @else
                    <div class="w-full h-full flex items-center justify-center">
                        <i class="fas fa-box text-4xl text-gray-300"></i>
                    </div>
                    @endif
                    
                    {{-- Badge Stok Soft --}}
                    <div class="absolute top-3 right-3">
                        <span class="bg-white/90 backdrop-blur-sm text-gray-600 text-xs font-light px-2.5 py-1 rounded-full shadow-sm border border-gray-100">
                            <i class="fas fa-boxes mr-1 text-xs"></i> Stok {{ $product->stock }}
                        </span>
                    </div>
                </div>
                
                <div class="p-5">
                    <h3 class="font-medium text-gray-900 mb-1 group-hover:text-yellow-600 transition-colors line-clamp-1">
                        {{ $product->name }}
                    </h3>
                    
                    <p class="text-gray-400 text-xs mb-3 line-clamp-2 font-light">{{ Str::limit($product->description, 50) }}</p>
                    
                    <div class="flex items-center justify-between mb-4">
                        <p class="text-xl font-light text-yellow-600">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </p>
                    </div>
                    
                    <a href="{{ route('products.show', $product->slug) }}"
                        class="block w-full text-center bg-gray-50 text-gray-600 py-2.5 rounded-lg text-sm font-light hover:bg-gray-900 hover:text-white transition-all duration-300 border border-gray-100 hover:border-gray-900">
                        Detail Produk
                        <i class="fas fa-arrow-right ml-2 text-xs"></i>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

{{-- Footer dengan Desain Elegan --}}
<footer class="bg-gray-900 text-gray-400 pt-16 pb-8 mt-28 relative overflow-hidden">
    {{-- Background Soft --}}
    <div class="absolute inset-0 opacity-5 pointer-events-none">
        <div class="absolute inset-0 bg-cover bg-center"
             style="background-image: url('https://images.unsplash.com/photo-1581091226033-d5c48150dbaa?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80');">
        </div>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-12">
            
            {{-- Logo & Deskripsi --}}
            <div class="animate-fade-in-up">
                <h3 class="text-xl font-light text-white mb-4 tracking-wide">
                    Batu Bara & <span class="text-yellow-500/80">Briket</span>
                </h3>
                <p class="text-gray-500 text-sm leading-relaxed font-light">
                    Mitra terpercaya untuk kebutuhan batu bara dan briket berkualitas di seluruh Indonesia.
                </p>
            </div>

            {{-- Navigasi --}}
            <div class="animate-fade-in-up" style="animation-delay: 100ms">
                <h4 class="text-white font-light text-sm mb-4 tracking-wide">Navigasi</h4>
                <ul class="space-y-2 text-sm">
                    <li>
                        <a href="{{ route('home') }}" class="text-gray-500 hover:text-yellow-500/80 transition-colors inline-block hover:translate-x-1 transform duration-300 font-light">Beranda</a>
                    </li>
                    <li>
                        <a href="{{ route('products.index') }}" class="text-gray-500 hover:text-yellow-500/80 transition-colors inline-block hover:translate-x-1 transform duration-300 font-light">Produk</a>
                    </li>
                    <li>
                        <a href="#" class="text-gray-500 hover:text-yellow-500/80 transition-colors inline-block hover:translate-x-1 transform duration-300 font-light">Tentang Kami</a>
                    </li>
                    <li>
                        <a href="#" class="text-gray-500 hover:text-yellow-500/80 transition-colors inline-block hover:translate-x-1 transform duration-300 font-light">Kontak</a>
                    </li>
                </ul>
            </div>

            {{-- Kontak --}}
            <div class="animate-fade-in-up" style="animation-delay: 200ms">
                <h4 class="text-white font-light text-sm mb-4 tracking-wide">Kontak</h4>
                <ul class="space-y-2 text-sm text-gray-500">
                    <li class="flex items-center">
                        <i class="fas fa-map-marker-alt mr-3 text-yellow-500/60 text-xs"></i>
                        Jakarta, Indonesia
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-phone mr-3 text-yellow-500/60 text-xs"></i>
                        +62 812 3456 7890
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-envelope mr-3 text-yellow-500/60 text-xs"></i>
                        info@batubarabriket.com
                    </li>
                </ul>
            </div>

            {{-- Sosial Media --}}
            <div class="animate-fade-in-up" style="animation-delay: 300ms">
                <h4 class="text-white font-light text-sm mb-4 tracking-wide">Ikuti Kami</h4>
                <div class="flex space-x-3">
                    <a href="#" class="w-8 h-8 flex items-center justify-center bg-gray-800 rounded-full hover:bg-yellow-500/20 hover:text-yellow-500 transition-all hover:-translate-y-0.5">
                        <i class="fab fa-facebook-f text-sm"></i>
                    </a>
                    <a href="#" class="w-8 h-8 flex items-center justify-center bg-gray-800 rounded-full hover:bg-yellow-500/20 hover:text-yellow-500 transition-all hover:-translate-y-0.5">
                        <i class="fab fa-instagram text-sm"></i>
                    </a>
                    <a href="#" class="w-8 h-8 flex items-center justify-center bg-gray-800 rounded-full hover:bg-yellow-500/20 hover:text-yellow-500 transition-all hover:-translate-y-0.5">
                        <i class="fab fa-whatsapp text-sm"></i>
                    </a>
                </div>
            </div>

        </div>

        {{-- Copyright --}}
        <div class="border-t border-gray-800/50 pt-6 text-center text-gray-600 text-xs font-light">
            © {{ date('Y') }} Batu Bara & Briket UMKM. All rights reserved.
        </div>
    </div>
</footer>

<style>
    /* Custom Animations - Soft & Elegant */
    @keyframes zoomSlow {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }
    
    @keyframes float {
        0%, 100% { transform: translateY(0px) translateX(0px); }
        33% { transform: translateY(-15px) translateX(8px); }
        66% { transform: translateY(0px) translateX(15px); }
    }
    
    @keyframes float-particle {
        0%, 100% { transform: translateY(0px) translateX(0px); opacity: 0; }
        25% { transform: translateY(-40px) translateX(20px); opacity: 0.3; }
        50% { transform: translateY(0px) translateX(40px); opacity: 0.1; }
        75% { transform: translateY(40px) translateX(20px); opacity: 0.3; }
        100% { transform: translateY(0px) translateX(0px); opacity: 0; }
    }
    
    @keyframes floatSlow {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-10px) rotate(3deg); }
    }
    
    @keyframes bounceSlow {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-15px); }
    }
    
    @keyframes pulseSlow {
        0%, 100% { opacity: 0.05; transform: scale(1); }
        50% { opacity: 0.15; transform: scale(1.2); }
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes slideInLeft {
        from {
            opacity: 0;
            transform: translateX(-30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
    
    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
    
    .animate-zoom-slow {
        animation: zoomSlow 20s infinite ease-in-out;
    }
    
    .animate-float {
        animation: float 10s infinite ease-in-out;
    }
    
    .animate-float-slow {
        animation: floatSlow 12s infinite ease-in-out;
    }
    
    .animate-float-delay {
        animation: float 11s infinite ease-in-out 2s;
    }
    
    .animate-bounce-slow {
        animation: bounceSlow 4s infinite ease-in-out;
    }
    
    .animate-pulse-slow {
        animation: pulseSlow 6s infinite ease-in-out;
    }
    
    .animate-fade-in-up {
        animation: fadeInUp 0.8s ease-out forwards;
        opacity: 0;
    }
    
    .animate-fade-in-up-delay {
        animation: fadeInUp 0.8s ease-out 0.3s forwards;
        opacity: 0;
    }
    
    .animate-fade-in-up-delay-2 {
        animation: fadeInUp 0.8s ease-out 0.6s forwards;
        opacity: 0;
    }
    
    .animate-slide-in-left {
        animation: slideInLeft 0.6s ease-out forwards;
    }
    
    .animate-slide-in-right {
        animation: slideInRight 0.6s ease-out forwards;
    }
    
    .animate-slide-in-left-delay {
        animation: slideInLeft 0.6s ease-out 0.3s forwards;
        opacity: 0;
    }
    
    .delay-1000 {
        animation-delay: 1000ms;
    }
    
    .scroll-mt-20 {
        scroll-margin-top: 5rem;
    }

    /* Background responsive untuk mobile */
    @media (max-width: 768px) {
        .hero-background {
            background-position: 65% 30% !important;
        }
    }
</style>
@endsection
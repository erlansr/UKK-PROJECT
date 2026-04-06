<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'E-Commerce Batu Bara & Briket')</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        /* Custom animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .nav-dropdown {
            animation: fadeIn 0.2s ease-out;
        }
        
        .hover-glow {
            transition: all 0.3s ease;
        }
        
        .hover-glow:hover {
            text-shadow: 0 0 8px rgba(234, 179, 8, 0.5);
        }
        
        .cart-badge {
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
    </style>
</head>
<body class="bg-gray-50">

<nav x-data="{ open: false, scrolled: false }" 
     @scroll.window="scrolled = window.scrollY > 20"
     :class="scrolled ? 'bg-gray-900/95 backdrop-blur-md shadow-xl' : 'bg-gradient-to-r from-gray-900 to-gray-800'"
     class="sticky top-0 z-50 transition-all duration-300">
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">

            <!-- Logo dengan Animasi -->
            <a href="{{ route('home') }}" 
               class="group flex items-center space-x-2 transform hover:scale-105 transition-transform duration-300">
               
                <span class="text-xl font-bold bg-gradient-to-r from-white to-gray-300 bg-clip-text text-transparent">
                    BatuBara<span class="text-yellow-500">Briket</span>
                </span>
            </a>

            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center space-x-1">
                <!-- Menu Item Produk -->
                <a href="{{ route('products.index') }}" 
                   class="relative px-4 py-2 text-gray-300 hover:text-yellow-400 transition-all duration-300 group">
                    <i class="fas fa-box mr-2"></i>
                    <span>Produk</span>
                    <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-yellow-400 group-hover:w-full transition-all duration-300"></span>
                </a>

                @auth
                    <!-- Menu Cart dengan Animasi -->
                    <a href="{{ route('cart.index') }}" 
                       class="relative px-4 py-2 text-gray-300 hover:text-yellow-400 transition-all duration-300 group">
                        <i class="fas fa-shopping-cart mr-2"></i>
                        <span>Keranjang</span>
                        @php
                            $cartCount = \App\Models\Cart::where('user_id', auth()->id())->count();
                        @endphp
                        @if($cartCount > 0)
                            <span class="absolute -top-1 -right-1 bg-gradient-to-r from-red-500 to-pink-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center shadow-lg cart-badge">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>

                    <!-- Menu Pesanan -->
                    <a href="{{ route('orders.index') }}" 
                       class="px-4 py-2 text-gray-300 hover:text-yellow-400 transition-all duration-300 group">
                        <i class="fas fa-box mr-2"></i>
                        <span>Pesanan</span>
                    </a>

                    <!-- Admin Menu dengan Badge -->
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" 
                           class="px-4 py-2 bg-gradient-to-r from-yellow-500 to-orange-500 text-gray-900 rounded-lg hover:shadow-lg transition-all duration-300 ml-2">
                            <i class="fas fa-tachometer-alt mr-2"></i>
                            <span>Admin</span>
                        </a>
                    @endif

                    <!-- User Dropdown dengan Avatar Elegant -->
                    <div x-data="{ dropdown: false }" class="relative ml-2">
                        <button @click="dropdown = !dropdown"
                                @keydown.escape.window="dropdown = false"
                                class="flex items-center space-x-2 px-3 py-1.5 rounded-full hover:bg-white/10 transition-all duration-300 group">
                            <!-- Profile Photo dengan Border Gradient -->
                            <div class="relative">
                                @php
                                    $profilePhoto = auth()->user()->profile_photo ?? null;
                                @endphp
                                
                                <div class="w-9 h-9 rounded-full bg-gradient-to-br from-yellow-400 to-orange-500 p-0.5">
                                    @if($profilePhoto && Storage::disk('public')->exists($profilePhoto))
                                        <img src="{{ Storage::url($profilePhoto) }}" 
                                             alt="{{ auth()->user()->name }}"
                                             class="w-full h-full rounded-full object-cover">
                                    @else
                                        <div class="w-full h-full rounded-full bg-gray-800 flex items-center justify-center text-white font-semibold text-sm">
                                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            
                            <span class="text-gray-300 group-hover:text-yellow-400 transition">{{ auth()->user()->name }}</span>
                            <i class="fas fa-chevron-down text-xs text-gray-500 group-hover:text-yellow-400 transition-transform duration-300" 
                               :style="dropdown ? 'transform: rotate(180deg)' : ''"></i>
                        </button>

                        <!-- Dropdown Menu dengan Animasi -->
                        <div x-show="dropdown"
                             @click.away="dropdown = false"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 translate-y-2"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 translate-y-2"
                             class="absolute right-0 mt-3 w-72 bg-white rounded-2xl shadow-2xl overflow-hidden nav-dropdown z-50">
                            
                            <!-- Header Dropdown -->
                            <div class="bg-gradient-to-r from-gray-900 to-gray-800 px-5 py-4">
                                <div class="flex items-center space-x-3">
                                    @if($profilePhoto && Storage::disk('public')->exists($profilePhoto))
                                        <img src="{{ Storage::url($profilePhoto) }}" 
                                             alt="{{ auth()->user()->name }}"
                                             class="w-12 h-12 rounded-full object-cover border-2 border-yellow-500">
                                    @else
                                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-yellow-500 to-orange-500 flex items-center justify-center text-white font-bold text-xl">
                                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                        </div>
                                    @endif
                                    <div>
                                        <p class="font-bold text-white">{{ auth()->user()->name }}</p>
                                        <p class="text-xs text-gray-400">{{ auth()->user()->email }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Menu Items -->
                            <div class="py-2">
                                <a href="{{ route('profile.edit') }}" 
                                   class="flex items-center px-5 py-3 hover:bg-gray-50 transition-colors group">
                                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-blue-200 transition">
                                        <i class="fas fa-user-circle text-blue-600"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-800">Edit Profile</p>
                                        <p class="text-xs text-gray-500">Ubah informasi akunmu</p>
                                    </div>
                                </a>
                                
                                <a href="{{ route('profile.photo') }}" 
                                   class="flex items-center px-5 py-3 hover:bg-gray-50 transition-colors group">
                                    <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-green-200 transition">
                                        <i class="fas fa-camera text-green-600"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-800">Ganti Foto Profil</p>
                                        <p class="text-xs text-gray-500">Perbarui foto profilmu</p>
                                    </div>
                                </a>
                            </div>
                            
                            <!-- Footer Dropdown -->
                            <div class="border-t border-gray-100 py-2">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                            class="flex items-center w-full px-5 py-3 hover:bg-red-50 transition-colors group">
                                        <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-red-200 transition">
                                            <i class="fas fa-sign-out-alt text-red-600"></i>
                                        </div>
                                        <div>
                                            <p class="font-medium text-red-600">Logout</p>
                                            <p class="text-xs text-gray-500">Keluar dari akun</p>
                                        </div>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                @else
                    <!-- Guest Buttons -->
                    <a href="{{ route('login') }}" 
                       class="px-5 py-2 text-gray-300 hover:text-yellow-400 transition-all duration-300">
                        Login
                    </a>
                    <a href="{{ route('register') }}"
                       class="px-5 py-2 bg-gradient-to-r from-yellow-500 to-orange-500 text-gray-900 rounded-full hover:shadow-lg transform hover:scale-105 transition-all duration-300 ml-2">
                        <i class="fas fa-user-plus mr-2"></i>
                        Daftar
                    </a>
                @endauth
            </div>

            <!-- Mobile Menu Button -->
            <div class="md:hidden">
                <button @click="open = !open" 
                        class="w-10 h-10 rounded-full bg-white/10 hover:bg-white/20 transition-all duration-300 flex items-center justify-center">
                    <i class="fas fa-bars text-xl" :class="open ? 'fa-times' : 'fa-bars'"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu dengan Animasi Slide -->
    <div x-show="open"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="-translate-y-full opacity-0"
         x-transition:enter-end="translate-y-0 opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="translate-y-0 opacity-100"
         x-transition:leave-end="-translate-y-full opacity-0"
         class="md:hidden bg-gray-900/95 backdrop-blur-md border-t border-gray-800">
        
        <div class="px-4 py-4 space-y-2">
            @auth
                <!-- Profile Mobile -->
                <div class="flex items-center space-x-3 py-4 mb-2 border-b border-gray-800">
                    @php
                        $profilePhoto = auth()->user()->profile_photo ?? null;
                    @endphp
                    
                    <div class="w-14 h-14 rounded-full bg-gradient-to-br from-yellow-500 to-orange-500 p-0.5">
                        @if($profilePhoto && Storage::disk('public')->exists($profilePhoto))
                            <img src="{{ Storage::url($profilePhoto) }}" 
                                 alt="{{ auth()->user()->name }}"
                                 class="w-full h-full rounded-full object-cover">
                        @else
                            <div class="w-full h-full rounded-full bg-gray-800 flex items-center justify-center text-white font-bold text-xl">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                        @endif
                    </div>
                    <div>
                        <p class="font-bold text-white">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-400">{{ auth()->user()->email }}</p>
                    </div>
                </div>
                
                <!-- Menu Items Mobile -->
                <a href="{{ route('products.index') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-white/10 transition-all duration-300 group">
                    <i class="fas fa-box w-5 text-yellow-500"></i>
                    <span class="text-gray-300 group-hover:text-yellow-400">Produk</span>
                </a>
                
                <a href="{{ route('cart.index') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-white/10 transition-all duration-300 group relative">
                    <i class="fas fa-shopping-cart w-5 text-yellow-500"></i>
                    <span class="text-gray-300 group-hover:text-yellow-400">Keranjang</span>
                    @if($cartCount > 0)
                        <span class="absolute right-4 top-3 bg-red-500 text-white text-xs rounded-full px-2 py-0.5">
                            {{ $cartCount }}
                        </span>
                    @endif
                </a>
                
                <a href="{{ route('orders.index') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-white/10 transition-all duration-300 group">
                    <i class="fas fa-box w-5 text-yellow-500"></i>
                    <span class="text-gray-300 group-hover:text-yellow-400">Pesanan Saya</span>
                </a>
                
                <a href="{{ route('profile.edit') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-white/10 transition-all duration-300 group">
                    <i class="fas fa-user-circle w-5 text-yellow-500"></i>
                    <span class="text-gray-300 group-hover:text-yellow-400">Edit Profile</span>
                </a>
                
                <a href="{{ route('profile.photo') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-white/10 transition-all duration-300 group">
                    <i class="fas fa-camera w-5 text-yellow-500"></i>
                    <span class="text-gray-300 group-hover:text-yellow-400">Ganti Foto</span>
                </a>

                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" 
                       class="flex items-center space-x-3 px-4 py-3 rounded-xl bg-gradient-to-r from-yellow-500 to-orange-500 text-gray-900 font-semibold mt-2">
                        <i class="fas fa-tachometer-alt w-5"></i>
                        <span>Admin Dashboard</span>
                    </a>
                @endif

                <div class="border-t border-gray-800 my-2"></div>
                
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" 
                            class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-red-500/10 transition-all duration-300 w-full group">
                        <i class="fas fa-sign-out-alt w-5 text-red-500"></i>
                        <span class="text-red-400 group-hover:text-red-300">Logout</span>
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-white/10 transition-all duration-300">
                    <i class="fas fa-sign-in-alt w-5 text-yellow-500"></i>
                    <span class="text-gray-300">Login</span>
                </a>
                <a href="{{ route('register') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-xl bg-gradient-to-r from-yellow-500 to-orange-500 text-gray-900 font-semibold">
                    <i class="fas fa-user-plus w-5"></i>
                    <span>Daftar Sekarang</span>
                </a>
            @endauth
        </div>
    </div>
</nav>

<main class="py-8">
    @yield('content')
</main>

@stack('scripts')

</body>
</html>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Admin BatuBara Briket</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="bg-gray-100">
    <div class="min-h-screen flex">
        {{-- Sidebar --}}
        <div class="w-64 bg-gray-900 text-white">
            <div class="p-4">
                <a href="{{ route('admin.dashboard') }}" class="block text-center text-xl font-bold">
                    Admin<span class="text-yellow-500">Panel</span>
                </a>
            </div>

            <nav class="mt-8">
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-800 hover:text-white transition {{ request()->routeIs('admin.dashboard') ? 'bg-gray-800 text-white' : '' }}">
                    <i class="fas fa-tachometer-alt w-6"></i>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('admin.products.index') }}"
                    class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-800 hover:text-white transition {{ request()->routeIs('admin.products.*') ? 'bg-gray-800 text-white' : '' }}">
                    <i class="fas fa-box w-6"></i>
                    <span>Produk</span>
                </a>

                <a href="{{ route('admin.orders.index') }}"
                    class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-800 hover:text-white transition {{ request()->routeIs('admin.orders.*') ? 'bg-gray-800 text-white' : '' }}">
                    <i class="fas fa-shopping-cart w-6"></i>
                    <span>Pesanan</span>
                </a>

                <a href="{{ route('admin.users.index') }}"
                    class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-800 hover:text-white transition {{ request()->routeIs('admin.users.*') ? 'bg-gray-800 text-white' : '' }}">
                    <i class="fas fa-users w-6"></i>
                    <span>User</span>
                </a>

                <a href="{{ route('admin.reports.sales') }}"
                    class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-800 hover:text-white transition {{ request()->routeIs('admin.reports.*') ? 'bg-gray-800 text-white' : '' }}">
                    <i class="fas fa-chart-line w-6"></i>
                    <span>Laporan</span>
                </a>

                <div class="border-t border-gray-800 my-4"></div>

                <a href="{{ route('home') }}"
                    class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-800 hover:text-white transition">
                    <i class="fas fa-store w-6"></i>
                    <span>Lihat Toko</span>
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center px-6 py-3 text-gray-300 hover:bg-gray-800 hover:text-white transition">
                        <i class="fas fa-sign-out-alt w-6"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </nav>
        </div>

        {{-- Main Content --}}
        <div class="flex-1">
            {{-- Header --}}
            <header class="bg-white shadow">
                <div class="flex justify-end items-center px-8 py-4">
                    <div class="flex items-center space-x-4">
                        <span class="text-gray-700">{{ Auth::user()->name }}</span>
                        <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-gray-600"></i>
                        </div>
                    </div>
                </div>
            </header>

            {{-- Content --}}
            <main>
                @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mx-8 mt-4">
                    {{ session('success') }}
                </div>
                @endif

                @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mx-8 mt-4">
                    {{ session('error') }}
                </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>

</html>
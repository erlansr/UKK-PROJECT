<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Batu Bara & Briket</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <!-- ========================================== -->
            <!-- HEADER DIUBAH: Logo + Nama Brand + Subtitle -->
            <!-- ========================================== -->
            <div class="text-center">
                <!-- Logo / Ikon Batu bara dengan gaya modern namun tetap elegan -->
                <div class="flex justify-center mb-4">
                    <div class="bg-yellow-100 rounded-full p-4 shadow-sm">
                        <i class="fas fa-fire text-yellow-600 text-3xl"></i>
                    </div>
                </div>
                
                <!-- Nama brand dengan gaya yang lebih menonjol dan terintegrasi -->
                <a href="{{ route('home') }}" class="block group">
                    <h1 class="text-4xl font-extrabold tracking-tight">
                        <span class="text-gray-800">BatuBara</span>
                        <span class="text-yellow-500 bg-clip-text">Briket</span>
                    </h1>
                    <div class="h-1 w-20 bg-yellow-500 mx-auto mt-2 rounded-full group-hover:w-28 transition-all duration-300"></div>
                </a>
                
                <!-- Subtitle singkat memperkuat identitas -->
                <p class="mt-3 text-xs text-gray-500 uppercase tracking-wider font-medium">
                    <i class="fas fa-coal mr-1"></i> Energi Terpercaya & Berkelanjutan
                </p>
                
                <h2 class="mt-6 text-2xl font-bold text-gray-900">
                    Daftar Akun Baru
                </h2>
                <p class="mt-2 text-sm text-gray-600">
                    Atau
                    <a href="{{ route('login') }}" class="font-medium text-yellow-600 hover:text-yellow-500 transition duration-150 ease-in-out">
                        login jika sudah punya akun
                    </a>
                </p>
            </div>
            
            <form class="mt-8 space-y-6" action="{{ route('register') }}" method="POST">
                @csrf
                
                @if($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <div class="space-y-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                        <input id="name" name="name" type="text" value="{{ old('name') }}" required 
                               class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-yellow-500 focus:border-yellow-500 sm:text-sm"
                               placeholder="Nama Lengkap">
                    </div>
                    
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" required 
                               class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-yellow-500 focus:border-yellow-500 sm:text-sm"
                               placeholder="nama@email.com">
                    </div>
                    
                    <div>
                        <label for="no_hp" class="block text-sm font-medium text-gray-700 mb-1">Nomor HP</label>
                        <input id="no_hp" name="no_hp" type="text" value="{{ old('no_hp') }}" required 
                               class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-yellow-500 focus:border-yellow-500 sm:text-sm"
                               placeholder="081234567890">
                    </div>
                    
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <input id="password" name="password" type="password" required 
                               class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-yellow-500 focus:border-yellow-500 sm:text-sm"
                               placeholder="Minimal 8 karakter">
                    </div>
                    
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" required 
                               class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-yellow-500 focus:border-yellow-500 sm:text-sm"
                               placeholder="********">
                    </div>
                </div>

                <div>
                    <button type="submit" 
                            class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-gray-900 bg-yellow-500 hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition duration-150 ease-in-out">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <i class="fas fa-user-plus text-gray-800 group-hover:text-gray-900 text-sm"></i>
                        </span>
                        Daftar
                    </button>
                </div>
            </form>
            
            <!-- informasi tambahan ringan (hanya gaya, tidak menambah fitur baru) -->
            <div class="text-center text-xs text-gray-400 pt-4">
                <span>Dengan mendaftar, Anda menyetujui <a href="#" class="text-yellow-600">Syarat & Ketentuan</a></span>
            </div>
        </div>
    </div>
</body>
</html>
@extends('layouts.app')

@section('title', 'Ganti Foto Profil')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
        <div class="bg-gradient-to-r from-gray-900 to-gray-800 px-6 py-4">
            <h1 class="text-2xl font-bold text-white">Foto Profil</h1>
            <p class="text-gray-300 text-sm mt-1">Ubah foto profil Anda</p>
        </div>
        
        <div class="p-6">
            @if(session('success'))
                <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded">
                    {{ session('success') }}
                </div>
            @endif
            
            <!-- Current Photo -->
            <div class="mb-8 text-center">
                <label class="block text-sm font-medium text-gray-700 mb-3">Foto Saat Ini</label>
                @php
                    $profilePhoto = auth()->user()->profile_photo ?? null;
                @endphp
                
                @if($profilePhoto && Storage::disk('public')->exists($profilePhoto))
                    <img src="{{ Storage::url($profilePhoto) }}" 
                         alt="Profile Photo"
                         class="w-32 h-32 rounded-full object-cover mx-auto border-4 border-yellow-500">
                @else
                    <div class="w-32 h-32 rounded-full bg-gradient-to-br from-yellow-500 to-orange-500 flex items-center justify-center text-white text-4xl font-bold mx-auto border-4 border-yellow-500">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                @endif
            </div>
            
            <!-- Upload Form -->
            <form action="{{ route('profile.photo.update') }}" method="POST" enctype="multipart/form-data" class="mb-6">
                @csrf
                
                <div class="mb-4">
                    <label for="profile_photo" class="block text-sm font-medium text-gray-700 mb-2">
                        Pilih Foto Baru
                    </label>
                    <input type="file" 
                           name="profile_photo" 
                           id="profile_photo" 
                           accept="image/*"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500"
                           onchange="previewImage(event)">
                    @error('profile_photo')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, GIF. Maksimal 2MB</p>
                </div>
                
                <!-- Preview -->
                <div id="previewContainer" class="mb-4 text-center hidden">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Preview</label>
                    <img id="preview" class="w-32 h-32 rounded-full object-cover mx-auto border-2 border-gray-300">
                </div>
                
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('products.index') }}" 
                       class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                        Kembali
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 bg-yellow-500 text-gray-900 rounded-lg hover:bg-yellow-600 transition font-semibold">
                        Upload Foto
                    </button>
                </div>
            </form>
            
            <!-- Delete Photo Button -->
            @if($profilePhoto && Storage::disk('public')->exists($profilePhoto))
                <div class="border-t pt-6">
                    <form action="{{ route('profile.photo.delete') }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus foto profil?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="w-full px-6 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">
                            Hapus Foto Profil
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
function previewImage(event) {
    const previewContainer = document.getElementById('previewContainer');
    const preview = document.getElementById('preview');
    
    if (event.target.files && event.target.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.src = e.target.result;
            previewContainer.classList.remove('hidden');
        }
        
        reader.readAsDataURL(event.target.files[0]);
    }
}
</script>
@endsection
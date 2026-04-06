@extends('layouts.admin')

@section('title', 'Manajemen User')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
    

        @if(session('error'))
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <h1 class="text-2xl font-semibold text-gray-900 mb-6">Manajemen User</h1>

        <div class="bg-white shadow overflow-hidden sm:rounded-md">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. HP</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Pesanan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bergabung</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>

                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($users as $user)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ $user->name }}
                                </div>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $user->email }}
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $user->no_hp ?? '-' }}
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($user->is_active)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Aktif
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        Nonaktif
                                    </span>
                                @endif
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $user->orders->count() }}
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $user->created_at->format('d/m/Y') }}
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                {{-- View --}}
                                <a href="{{ route('admin.users.show', $user) }}" 
                                   class="text-yellow-600 hover:text-yellow-900 mr-3">
                                    <i class="fas fa-eye"></i>
                                </a>

                                {{-- Toggle Active --}}
                                <form action="{{ route('admin.users.toggle-active', $user) }}" 
                                      method="POST" 
                                      class="inline toggle-form">
                                    @csrf
                                    <button type="submit"
                                            class="toggle-user {{ $user->is_active ? 'text-red-600 hover:text-red-900' : 'text-green-600 hover:text-green-900' }} mr-3"
                                            data-status="{{ $user->is_active ? 'nonaktifkan' : 'aktifkan' }}">
                                        <i class="fas {{ $user->is_active ? 'fa-ban' : 'fa-check-circle' }}"></i>
                                    </button>
                                </form>

                                {{-- Delete --}}
                                <form action="{{ route('admin.users.destroy', $user) }}" 
                                      method="POST" 
                                      class="inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="text-red-600 hover:text-red-900 delete-user">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                Tidak ada data user
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    // Konfirmasi untuk toggle status
    const toggleButtons = document.querySelectorAll(".toggle-user");
    
    toggleButtons.forEach(function(button) {
        button.addEventListener("click", function(e) {
            const action = this.dataset.status;
            const confirmText = `Yakin ingin ${action} user ini?`;
            
            if (!confirm(confirmText)) {
                e.preventDefault();
            }
        });
    });
    
    // Konfirmasi untuk hapus user
    const deleteForms = document.querySelectorAll(".delete-form");
    
    deleteForms.forEach(function(form) {
        form.addEventListener("submit", function(e) {
            if (!confirm("Yakin ingin menghapus user ini? Tindakan ini tidak dapat dibatalkan!")) {
                e.preventDefault();
            }
        });
    });
});
</script>

@endsection
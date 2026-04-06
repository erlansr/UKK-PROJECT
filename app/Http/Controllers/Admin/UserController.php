<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'user')->latest()->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function toggleActive(User $user)
    {
        if ($user->role === 'admin') {
            return redirect()->back()
                            ->with('error', 'Tidak dapat mengubah status admin!');
        }

        $user->update(['is_active' => !$user->is_active]);

        return redirect()->back()
                        ->with('success', 'Status user berhasil diubah!');
    }

    public function show(User $user)
    {
        if ($user->role === 'admin') {
            return redirect()->route('admin.users.index')
                            ->with('error', 'Tidak dapat melihat detail admin!');
        }

        $orders = $user->orders()->latest()->paginate(10);

        return view('admin.users.show', compact('user', 'orders'));
    }

    public function destroy(User $user)
    {
        // Cek apakah user adalah admin
        if ($user->role === 'admin') {
            return redirect()->back()
                            ->with('error', 'Tidak dapat menghapus user dengan role admin!');
        }

        // Cek apakah user memiliki pesanan dengan status SELAIN 'selesai'
        // Artinya: pesanan yang masih aktif/diproses/belum selesai
        $hasUnfinishedOrders = $user->orders()
                                    ->where('status', '!=', 'selesai')
                                    ->exists();

        if ($hasUnfinishedOrders) {
            return redirect()->back()
                            ->with('error', 'User memiliki pesanan yang belum selesai. Tidak dapat dihapus!');
        }

        // Jika user hanya memiliki pesanan dengan status 'selesai' atau tidak punya pesanan
        // Maka bisa dihapus
        $user->delete();

        return redirect()->route('admin.users.index')
                        ->with('success', 'User berhasil dihapus!');
    }
}
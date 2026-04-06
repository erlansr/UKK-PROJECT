<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Total penjualan
        $totalPenjualan = Order::where('status', 'selesai')->sum('total');
        
        // Total pesanan
        $totalPesanan = Order::count();
        
        // Pesanan berdasarkan status
        $pesananStatus = [
            'menunggu_konfirmasi' => Order::where('status', 'menunggu_konfirmasi')->count(),
            'diproses' => Order::where('status', 'diproses')->count(),
            'dikirim' => Order::where('status', 'dikirim')->count(),
            'selesai' => Order::where('status', 'selesai')->count(),
            'ditolak' => Order::where('status', 'ditolak')->count(),
        ];

        // Produk terlaris
        $produkTerlaris = DB::table('order_items')
            ->select('product_id', 'product_name', DB::raw('SUM(quantity) as total_terjual'))
            ->groupBy('product_id', 'product_name')
            ->orderBy('total_terjual', 'desc')
            ->limit(5)
            ->get();

        // Total user
        $totalUser = User::where('role', 'user')->count();

        return view('admin.dashboard', compact(
            'totalPenjualan', 
            'totalPesanan', 
            'pesananStatus', 
            'produkTerlaris',
            'totalUser'
        ));
    }
}
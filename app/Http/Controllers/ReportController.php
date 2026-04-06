<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // Cek apakah user login dan admin
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
        
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->format('Y-m-d'));
        
        // Ambil order dengan status 'selesai' (tanpa with orderItems dulu)
        $orders = Order::with('user')
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->where('status', 'selesai')
            ->orderBy('created_at', 'desc')
            ->get();
        
        $totalRevenue = $orders->sum('total');
        $totalOrders = $orders->count();
        
        // Hitung total items dari order_items
        $totalItems = OrderItem::whereHas('order', function($query) use ($startDate, $endDate) {
            $query->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
                  ->where('status', 'selesai');
        })->sum('quantity');
        
        $averageOrder = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;
        
        // Top produk terlaris
        $topProducts = OrderItem::with('product')
            ->whereHas('order', function($query) use ($startDate, $endDate) {
                $query->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
                      ->where('status', 'selesai');
            })
            ->selectRaw('product_id, SUM(quantity) as total_quantity, SUM(subtotal) as total_sales')
            ->groupBy('product_id')
            ->orderBy('total_quantity', 'desc')
            ->limit(5)
            ->get();
        
        // Statistik per hari
        $dailyStats = Order::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->where('status', 'selesai')
            ->selectRaw('DATE(created_at) as date, COUNT(*) as orders, SUM(total) as revenue')
            ->groupBy('date')
            ->orderBy('date')
            ->get();
        
        return view('reports.sales', compact(
            'orders', 'totalRevenue', 'totalOrders', 'totalItems', 
            'averageOrder', 'topProducts', 'dailyStats', 'startDate', 'endDate'
        ));
    }
    
    public function exportPDF(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->format('Y-m-d'));
        
        $orders = Order::with('user')
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->where('status', 'selesai')
            ->orderBy('created_at', 'desc')
            ->get();
        
        $totalRevenue = $orders->sum('total');
        $totalOrders = $orders->count();
        
        $totalItems = OrderItem::whereHas('order', function($query) use ($startDate, $endDate) {
            $query->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
                  ->where('status', 'selesai');
        })->sum('quantity');
        
        $averageOrder = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;
        
        $topProducts = OrderItem::with('product')
            ->whereHas('order', function($query) use ($startDate, $endDate) {
                $query->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
                      ->where('status', 'selesai');
            })
            ->selectRaw('product_id, SUM(quantity) as total_quantity, SUM(subtotal) as total_sales')
            ->groupBy('product_id')
            ->orderBy('total_quantity', 'desc')
            ->limit(5)
            ->get();
        
        $pdf = PDF::loadView('reports.sales-pdf', compact(
            'orders', 'totalRevenue', 'totalOrders', 'totalItems', 
            'averageOrder', 'topProducts', 'startDate', 'endDate'
        ));
        
        $pdf->setPaper('A4', 'landscape');
        
        return $pdf->download('laporan-penjualan-' . $startDate . '-sampai-' . $endDate . '.pdf');
    }
}
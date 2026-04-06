<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('user');

        // Filter berdasarkan status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $orders = $query->latest()->paginate(15);

        $statuses = [
            'menunggu_konfirmasi' => 'Menunggu Konfirmasi',
            'diproses' => 'Diproses',
            'dikirim' => 'Dikirim',
            'selesai' => 'Selesai',
            'ditolak' => 'Ditolak'
        ];

        return view('admin.orders.index', compact('orders', 'statuses'));
    }

    public function show(Order $order)
    {
        $order->load('user', 'items.product');

        $statuses = [
            'menunggu_konfirmasi' => 'Menunggu Konfirmasi',
            'diproses' => 'Diproses',
            'dikirim' => 'Dikirim',
            'selesai' => 'Selesai',
            'ditolak' => 'Ditolak'
        ];

        return view('admin.orders.show', compact('order', 'statuses'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:menunggu_konfirmasi,diproses,dikirim,selesai,ditolak'
        ]);

        $order->update(['status' => $request->status]);

        return redirect()->back()
            ->with('success', 'Status pesanan berhasil diperbarui!');
    }

    public function confirmPayment(Order $order)
    {
        if (!$order->payment_confirmed) {
            $order->update([
                'payment_confirmed' => true,
                'payment_confirmed_at' => now()
            ]);

            return redirect()->back()
                ->with('success', 'Pembayaran berhasil dikonfirmasi!');
        }

        return redirect()->back()
            ->with('error', 'Pembayaran sudah dikonfirmasi sebelumnya!');
    }

    public function cancel(Order $order)
    {
        if ($order->status !== 'selesai') {
            $order->update(['status' => 'ditolak']);

            return redirect()->back()
                ->with('success', 'Pesanan berhasil dibatalkan!');
        }

        return redirect()->back()
            ->with('error', 'Pesanan yang sudah selesai tidak dapat dibatalkan!');
    }
}

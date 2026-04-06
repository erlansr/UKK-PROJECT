<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $carts = Cart::with('product')
                     ->where('user_id', Auth::id())
                     ->get();

        if ($carts->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja kosong!');
        }

        $total = $carts->sum(function($cart) {
            return $cart->product->price * $cart->quantity;
        });

        $jasaPengiriman = ['JNE', 'J&T', 'Sicepat', 'Pos Indonesia'];
        
        // Data metode pembayaran dengan detail lengkap
        $metodePembayaran = [
            'transfer_bca' => [
                'name' => 'Transfer Bank BCA',
                'icon' => '🏦',
                'details' => [
                    'bank' => 'BCA',
                    'nomor_rekening' => '1234567890',
                    'atas_nama' => 'PT BatuBara Briket Indonesia',
                    'cabang' => 'KCU Jakarta Pusat'
                ]
            ],
            'transfer_mandiri' => [
                'name' => 'Transfer Bank Mandiri',
                'icon' => '🏦',
                'details' => [
                    'bank' => 'Mandiri',
                    'nomor_rekening' => '0987654321',
                    'atas_nama' => 'PT BatuBara Briket Indonesia',
                    'cabang' => 'KCU Thamrin'
                ]
            ],
            'transfer_bri' => [
                'name' => 'Transfer Bank BRI',
                'icon' => '🏦',
                'details' => [
                    'bank' => 'BRI',
                    'nomor_rekening' => '5678901234',
                    'atas_nama' => 'PT BatuBara Briket Indonesia',
                    'cabang' => 'KCU Sudirman'
                ]
            ],
            'dana' => [
                'name' => 'DANA',
                'icon' => '💜',
                'details' => [
                    'type' => 'E-Wallet',
                    'nomor_akun' => '088212345678',
                    'atas_nama' => 'PT BatuBara Briket Indonesia'
                ]
            ],
            'ovo' => [
                'name' => 'OVO',
                'icon' => '💙',
                'details' => [
                    'type' => 'E-Wallet',
                    'nomor_akun' => '088212345679',
                    'atas_nama' => 'PT BatuBara Briket Indonesia'
                ]
            ],
            'gopay' => [
                'name' => 'GoPay',
                'icon' => '💚',
                'details' => [
                    'type' => 'E-Wallet',
                    'nomor_akun' => '088212345680',
                    'atas_nama' => 'PT BatuBara Briket Indonesia'
                ]
            ],
            'virtual_account' => [
                'name' => 'Virtual Account BCA',
                'icon' => '💳',
                'details' => [
                    'type' => 'Virtual Account',
                    'nomor_va' => '88881234567890',
                    'atas_nama' => 'PT BatuBara Briket Indonesia'
                ]
            ]
        ];

        return view('checkout.index', compact('carts', 'total', 'jasaPengiriman', 'metodePembayaran'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'alamat' => 'required|string',
            'no_hp' => 'required|string|max:15',
            'catatan' => 'nullable|string',
            'jasa_pengiriman' => 'required|string',
            'metode_pembayaran' => 'required|string'
        ]);

        $carts = Cart::with('product')
                     ->where('user_id', Auth::id())
                     ->get();

        if ($carts->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja kosong!');
        }

        DB::beginTransaction();

        try {
            // Hitung total
            $total = $carts->sum(function($cart) {
                return $cart->product->price * $cart->quantity;
            });

            // Buat order
            $order = Order::create([
                'invoice_number' => 'INV/' . date('Ymd') . '/' . str_pad(Order::count() + 1, 4, '0', STR_PAD_LEFT),
                'user_id' => Auth::id(),
                'total' => $total,
                'status' => 'menunggu_konfirmasi',
                'alamat' => $request->alamat,
                'no_hp' => $request->no_hp,
                'catatan' => $request->catatan,
                'jasa_pengiriman' => $request->jasa_pengiriman,
                'metode_pembayaran' => $request->metode_pembayaran
            ]);

            // Buat order items dan kurangi stok
            foreach ($carts as $cart) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cart->product_id,
                    'product_name' => $cart->product->name,
                    'price' => $cart->product->price,
                    'quantity' => $cart->quantity,
                    'subtotal' => $cart->product->price * $cart->quantity
                ]);

                // Kurangi stok
                $cart->product->decrement('stock', $cart->quantity);
            }

            // Hapus cart
            Cart::where('user_id', Auth::id())->delete();

            DB::commit();

            return redirect()->route('orders.show', $order->id)
                           ->with('success', 'Pesanan berhasil dibuat! Silahkan lakukan pembayaran.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
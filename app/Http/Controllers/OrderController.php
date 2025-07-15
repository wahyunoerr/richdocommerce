<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public static function generateOrderCode()
    {
        $prefix = 'ORD';
        $date = date('Ymd');
        $random = strtoupper(substr(md5(uniqid(rand(), true)), 0, 6));
        return $prefix . '-' . $date . '-' . $random;
    }

    public function store(Request $request)
    {
        $request->validate([
            'payment_method' => 'required',
            'total' => 'required|numeric',
            'bukti_transfer' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        $orderCode = self::generateOrderCode();
        $data = [
            'user_id' => auth()->id(),
            'status' => 'pending',
            'total' => $request->total,
            'payment_method' => $request->payment_method,
            'payment_status' => 'unpaid',
            'order_code' => $orderCode,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        if ($request->hasFile('bukti_transfer')) {
            $path = $request->file('bukti_transfer')->store('bukti_transfer', 'public');
            $data['bukti_transfer'] = $path;
            $data['payment_status'] = 'waiting_verification';
            $data['status'] = 'waiting_payment_verification';
        }
        $orderId = DB::table('orders')->insertGetId($data);
        // Simpan detail produk ke order_items
        $cart = session('cart', []);
        if (!empty($cart)) {
            $products = DB::table('products')->whereIn('id', array_keys($cart))->get();
            foreach ($products as $product) {
                $qty = isset($cart[$product->id]) ? (int)$cart[$product->id] : 0;
                if ($qty > 0) {
                    DB::table('order_items')->insert([
                        'order_id' => $orderId,
                        'product_id' => $product->id,
                        'qty' => $qty,
                        'price' => $product->price,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    // Mutasi stok otomatis
                    DB::table('mutasi_stocks')->insert([
                        'product_id' => $product->id,
                        'type' => 'out',
                        'qty' => $qty,
                        'description' => 'Pengurangan stok otomatis dari transaksi order',
                        'user_id' => auth()->id(),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    // Update stok produk
                    DB::table('products')->where('id', $product->id)->decrement('stok', $qty);
                }
            }
        }
        session()->forget('cart');
        return redirect()->route('orders.payment', $orderId);
    }

    public function payment($id)
    {
        $order = DB::table('orders')
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->first();
        if (!$order) abort(404);
        $items = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->select('products.name', 'products.price', 'order_items.qty')
            ->where('order_items.order_id', $order->id)
            ->get();
        return view('orders.payment', compact('order', 'items'));
    }

    public function pay(Request $request, $id)
    {
        $request->validate([
            'bukti_transfer' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'payment_method' => 'required',
        ]);
        $order = DB::table('orders')->where('id', $id)->first();
        $data = [
            'payment_method' => $request->payment_method,
            'payment_status' => 'waiting_verification',
            'status' => 'waiting_payment_verification',
            'updated_at' => now(),
        ];
        if ($request->hasFile('bukti_transfer')) {
            $path = $request->file('bukti_transfer')->store('bukti_transfer', 'public');
            $data['bukti_transfer'] = $path;
        }
        DB::table('orders')->where('id', $id)->update($data);
        return redirect()->route('home')->with('success', 'Bukti transfer berhasil diupload, menunggu verifikasi admin.');
    }
}

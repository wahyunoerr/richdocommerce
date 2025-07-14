<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminOrderController extends Controller
{
    public function index()
    {
        $orders = DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->select('orders.*', 'users.name as user_name')
            ->orderByDesc('orders.created_at')
            ->get();
        return view('admin.orders.index', compact('orders'));
    }
    public function show($id)
    {
        $order = DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->select('orders.*', 'users.name as user_name')
            ->where('orders.id', $id)
            ->first();
        return view('admin.orders.show', compact('order'));
    }
    public function update(Request $request, $id)
    {
        $status = $request->input('status');
        $payment_status = $request->input('payment_status');
        DB::table('orders')->where('id', $id)->update([
            'status' => $status,
            'payment_status' => $payment_status,
        ]);
        // Jika disetujui, ubah payment_status jadi paid dan kurangi stok produk
        if ($status === 'setuju') {
            DB::table('orders')->where('id', $id)->update([
                'payment_status' => 'paid',
            ]);
            $items = DB::table('order_items')->where('order_id', $id)->get();
            foreach ($items as $item) {
                DB::table('products')->where('id', $item->product_id)->decrement('stok', $item->qty);
            }
        }
        return redirect()->route('admin.orders.show', $id)->with('success', 'Status pesanan berhasil diupdate');
    }
    public function destroy($id)
    {
        DB::table('orders')->where('id', $id)->delete();
        return redirect()->route('admin.orders.index')->with('success', 'Pesanan berhasil dihapus');
    }
    public static function generateOrderCode()
    {
        $prefix = 'ORD';
        $date = date('Ymd');
        $random = strtoupper(substr(md5(uniqid(rand(), true)), 0, 6));
        return $prefix . '-' . $date . '-' . $random;
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CustomerOrderController extends Controller
{
    public function index()
    {
        $orders = DB::table('orders')
            ->where('user_id', auth()->id())
            ->orderByDesc('created_at')
            ->get();
        return view('orders.customer_orders', compact('orders'));
    }

    public function show($id)
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
        return view('orders.customer_order_detail', compact('order', 'items'));
    }
}

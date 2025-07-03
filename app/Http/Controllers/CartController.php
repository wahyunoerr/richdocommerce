<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);
        $products = [];
        if (count($cart)) {
            $products = DB::table('products')->whereIn('id', array_keys($cart))->get();
        }
        return view('cart.index', compact('products', 'cart'));
    }

    public function add(Request $request, $id)
    {
        $cart = session('cart', []);
        $qty = max(1, (int)($request->input('qty', 1)));
        $cart[$id] = ($cart[$id] ?? 0) + $qty;
        session(['cart' => $cart]);
        // Redirect kembali ke halaman sebelumnya (detail produk) agar navigation cart langsung update
        return redirect()->back()->with('success', 'Produk ditambahkan ke keranjang!');
    }

    public function remove($id)
    {
        $cart = session('cart', []);
        unset($cart[$id]);
        session(['cart' => $cart]);
        return redirect()->back()->with('success', 'Produk dihapus dari keranjang!');
    }
}

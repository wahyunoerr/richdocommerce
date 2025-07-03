<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);
        $products = [];
        $total = 0;
        if (count($cart)) {
            $products = DB::table('products')->whereIn('id', array_keys($cart))->get();
            foreach ($products as $product) {
                $total += $product->price * $cart[$product->id];
            }
        }
        $bankInfo = [
            'bank' => 'BCA',
            'rekening' => '1234567890',
            'nama' => 'PT Richdo Commerce'
        ];
        return view('checkout.index', compact('products', 'cart', 'total', 'bankInfo'));
    }

    public function process(Request $request)
    {
        // Simulasi proses checkout manual (tanpa pembayaran otomatis)
        session()->forget('cart');
        return redirect()->route('landing')->with('success', 'Pesanan Anda telah diterima. Silakan transfer ke rekening yang tertera.');
    }
}

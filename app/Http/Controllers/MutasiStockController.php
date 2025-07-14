<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class MutasiStockController extends Controller
{
    // Show form mutasi stok
    public function create()
    {
        $products = DB::table('products')->get();
        return view('admin.products.mutasi_create', compact('products'));
    }

    // Simpan mutasi stok
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'type' => 'required|in:in,out,correction',
            'qty' => 'required|integer',
            'description' => 'nullable|string',
        ]);
        DB::table('mutasi_stocks')->insert([
            'product_id' => $request->product_id,
            'type' => $request->type,
            'qty' => $request->qty,
            'description' => $request->description,
            'user_id' => Auth::id(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        return redirect()->route('admin.mutasi.index')->with('success', 'Mutasi stok berhasil disimpan');
    }

    // Tampilkan riwayat mutasi stok
    public function index()
    {
        $mutasi = DB::table('mutasi_stocks')
            ->join('products', 'mutasi_stocks.product_id', '=', 'products.id')
            ->select('mutasi_stocks.*', 'products.name as product_name')
            ->orderByDesc('mutasi_stocks.created_at')
            ->paginate(20);
        return view('admin.products.mutasi_index', compact('mutasi'));
    }

    // Laporan stok
    public function report()
    {
        $products = DB::table('products')->get();
        $stok = [];
        foreach ($products as $product) {
            $in = DB::table('mutasi_stocks')->where('product_id', $product->id)->where('type', 'in')->sum('qty');
            $out = DB::table('mutasi_stocks')->where('product_id', $product->id)->where('type', 'out')->sum('qty');
            $correction = DB::table('mutasi_stocks')->where('product_id', $product->id)->where('type', 'correction')->sum('qty');
            $stok[$product->id] = $in - $out + $correction;
        }
        return view('admin.products.mutasi_report', compact('products', 'stok'));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $categories = DB::table('categories')->get();
        $query = DB::table('products')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select('products.*', 'categories.name as category_name');
        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }
        if ($request->filled('q')) {
            $q = $request->input('q');
            $query->where(function ($sub) use ($q) {
                $sub->where('products.name', 'like', "%$q%")
                    ->orWhere('products.description', 'like', "%$q%")
                    ->orWhere('categories.name', 'like', "%$q%");
            });
        }
        $products = $query->paginate(12);
        return view('products.index', compact('products', 'categories'));
    }

    public function show($id)
    {
        $product = DB::table('products')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select('products.*', 'categories.name as category_name')
            ->where('products.id', $id)
            ->first();
        if (!$product) abort(404);
        return view('products.show', compact('product'));
    }
}

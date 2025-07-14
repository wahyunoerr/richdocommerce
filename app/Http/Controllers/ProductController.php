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
        $products = $query->paginate(10);
        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = DB::table('categories')->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required',
            'price' => 'required|numeric',
            'description' => 'nullable',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        $imageName = null;
        if ($request->hasFile('image_file')) {
            $imageName = $request->file('image_file')->store('products', 'public');
        }
        DB::table('products')->insert([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'description' => $request->description,
            'stok' => $request->stok,
            'image' => $imageName,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan');
    }

    public function edit($id)
    {
        $product = DB::table('products')->where('id', $id)->first();
        $categories = DB::table('categories')->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required',
            'price' => 'required|numeric',
            'description' => 'nullable',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        $data = [
            'name' => $request->name,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'description' => $request->description,
            'stok' => $request->stok,
            'updated_at' => now(),
        ];
        if ($request->hasFile('image_file')) {
            $data['image'] = $request->file('image_file')->store('products', 'public');
        }
        DB::table('products')->where('id', $id)->update($data);
        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diupdate');
    }

    public function destroy($id)
    {
        DB::table('products')->where('id', $id)->delete();
        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus');
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

    public function customerIndex(Request $request)
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

    public function customerShow($id)
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

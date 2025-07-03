<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Hanya halaman dashboard (index) yang butuh login
        $this->middleware('auth')->only('index');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = auth()->user();
        if ($user && method_exists($user, 'hasRole') && $user->hasRole('admin')) {
            return view('home');
        } else {
            return redirect()->route('landing');
        }
    }

    /**
     * Show the landing page with store info, categories, and products.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function landing()
    {
        $categories = DB::table('categories')->get();
        $products = DB::table('products')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select('products.*', 'categories.name as category_name')
            ->limit(6)
            ->get();
        $storeInfo = [
            'name' => 'Richdo Commerce',
            'description' => 'Toko online sederhana dengan fitur basic.'
        ];
        return view('welcome', compact('categories', 'products', 'storeInfo'));
    }
}

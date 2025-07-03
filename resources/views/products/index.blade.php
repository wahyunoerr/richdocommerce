@extends('layouts.landing.app')

@section('content')
    <div class="container">
        <h2 class="mb-4">Daftar Produk</h2>
        <div class="row">
            <div class="col-md-3 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-indigo text-white">
                        Kategori
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item {{ request('category') ? '' : 'bg-maroon' }}">
                            <a href="{{ route('products.index') }}"
                                class="text-decoration-none {{ request('category') ? '' : 'text-white' }}">Semua</a>
                        </li>
                        @foreach ($categories as $cat)
                            <li class="list-group-item {{ request('category') == $cat->id ? 'bg-maroon' : '' }}">
                                <a href="{{ route('products.index', ['category' => $cat->id]) }}"
                                    class="text-decoration-none {{ request('category') == $cat->id ? 'text-white' : '' }}">{{ $cat->name }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-md-9">
                <form method="GET" action="{{ route('products.index') }}" class="mb-3">
                    <div class="input-group">
                        <input type="text" name="q" class="form-control" placeholder="Cari produk..."
                            value="{{ request('q') }}">
                        @if (request('category'))
                            <input type="hidden" name="category" value="{{ request('category') }}">
                        @endif
                        <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i> Cari</button>
                    </div>
                </form>
                <div class="row">
                    @forelse ($products as $product)
                        <div class="col-md-4 mb-4">
                            <div class="card h-100 shadow-sm">
                                <img src="{{ asset('images/' . $product->image) }}" class="card-img-top"
                                    alt="{{ $product->name }}" style="object-fit:cover; height:180px;">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title">{{ $product->name }}</h5>
                                    <p class="card-text flex-grow-1">{{ Str::limit($product->description, 50) }}</p>
                                    <p class="card-text">
                                        <strong>Rp{{ number_format($product->price, 0, ',', '.') }}</strong>
                                    </p>
                                    <a href="{{ route('products.show', $product->id) }}"
                                        class="btn btn-outline-primary btn-sm mt-auto">Lihat Detail</a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-info">Tidak ada produk ditemukan.</div>
                        </div>
                    @endforelse
                </div>
                @if (method_exists($products, 'links'))
                    <div class="d-flex justify-content-center">
                        {{ $products->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

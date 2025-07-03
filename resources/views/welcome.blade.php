@extends('layouts.landing.app')

@section('content')
    <div class="jumbotron text-center mb-4">
        <h1>{{ $storeInfo['name'] ?? 'Richdo Commerce' }}</h1>
        <p>{{ $storeInfo['description'] ?? 'Toko online sederhana dengan fitur basic.' }}</p>
    </div>
    <h3 class="mb-3">Produk Unggulan</h3>
    <div class="row">
        @forelse ($products as $product)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <img src="{{ asset('images/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}"
                        style="object-fit:cover; height:220px;">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text flex-grow-1">{{ $product->description }}</p>
                        <p class="card-text"><strong>Rp{{ number_format($product->price, 0, ',', '.') }}</strong></p>
                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-primary mt-auto">Lihat
                            Detail</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">Tidak ada produk ditemukan.</div>
            </div>
        @endforelse
    </div>
@endsection

@extends('layouts.landing.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="row g-0">
                    <div class="col-md-5">
                        <img src="{{ asset('images/' . $product->image) }}" class="img-fluid rounded-start w-100"
                            alt="{{ $product->name }}" style="object-fit:cover; height:100%; min-height:220px;">
                    </div>
                    <div class="col-md-7">
                        <div class="card-body d-flex flex-column h-100">
                            <h2 class="card-title">{{ $product->name }}</h2>
                            <p class="card-text flex-grow-1">{{ $product->description }}</p>
                            <p class="card-text"><strong>Kategori:</strong> {{ $product->category_name ?? '' }}</p>
                            <p class="card-text"><strong>Stok:</strong> {{ $product->stok }}</p>
                            <h4 class="text-success">Rp{{ number_format($product->price, 0, ',', '.') }}</h4>
                            <form action="{{ route('cart.add', $product->id) }}" method="POST"
                                class="mt-auto d-flex align-items-center gap-2" id="addToCartForm">
                                @csrf
                                <input type="number" name="qty" id="qtyInput" value="1" min="1"
                                    max="{{ $product->stok }}" class="form-control me-2" style="width:90px;" required>
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-cart-plus"></i> Tambah ke Keranjang
                                </button>
                            </form>
                            <script>
                                document.getElementById('addToCartForm').addEventListener('submit', function(e) {
                                    var qty = parseInt(document.getElementById('qtyInput').value);
                                    var stok = {{ $product->stok }};
                                    if (qty > stok) {
                                        alert('Jumlah melebihi stok yang tersedia!');
                                        e.preventDefault();
                                    }
                                });
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

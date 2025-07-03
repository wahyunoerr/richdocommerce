@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-4">Keranjang Belanja</h2>
        @if (count($cart) === 0)
            <div class="alert alert-info">Keranjang belanja kosong.</div>
        @else
            <div class="card shadow">
                <div class="card-body">
                    <table class="table table-bordered align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Produk</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                                <th>Subtotal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $total = 0; @endphp
                            @foreach ($products as $product)
                                @php
                                    $subtotal = $product->price * $cart[$product->id];
                                    $total += $subtotal;
                                @endphp
                                <tr>
                                    <td>{{ $product->name }}</td>
                                    <td>Rp{{ number_format($product->price, 0, ',', '.') }}</td>
                                    <td>{{ $cart[$product->id] }}</td>
                                    <td>Rp{{ number_format($subtotal, 0, ',', '.') }}</td>
                                    <td>
                                        <form action="{{ route('cart.remove', $product->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3">Total</th>
                                <th colspan="2">Rp{{ number_format($total, 0, ',', '.') }}</th>
                            </tr>
                        </tfoot>
                    </table>
                    <a href="{{ route('checkout.index') }}" class="btn btn-success mt-3">Checkout</a>
                </div>
            </div>
        @endif
    </div>
@endsection

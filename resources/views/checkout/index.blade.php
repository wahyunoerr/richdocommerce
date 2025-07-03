@extends('layouts.landing.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <h2 class="mb-4">Checkout</h2>
                    <div class="alert alert-info">
                        Silakan transfer total pembayaran ke rekening berikut:<br>
                        <strong>{{ $bankInfo['bank'] }} - {{ $bankInfo['rekening'] }} a.n. {{ $bankInfo['nama'] }}</strong>
                    </div>
                    <table class="table table-bordered align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Produk</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td>{{ $product->name }}</td>
                                    <td>Rp{{ number_format($product->price, 0, ',', '.') }}</td>
                                    <td>{{ $cart[$product->id] }}</td>
                                    <td>Rp{{ number_format($product->price * $cart[$product->id], 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3">Total</th>
                                <th>Rp{{ number_format($total, 0, ',', '.') }}</th>
                            </tr>
                        </tfoot>
                    </table>
                    <form action="{{ route('checkout.process') }}" method="POST" class="mt-3">
                        @csrf
                        <button type="submit" class="btn btn-success">Konfirmasi Pesanan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

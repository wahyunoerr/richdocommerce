@extends('layouts.landing.app')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <h2 class="mb-4">Detail Pesanan</h2>
                    <div class="alert alert-info">
                        Kode Pesanan: <strong>{{ $order->order_code }}</strong><br>
                        Status: <strong>{{ $order->status }}</strong><br>
                        Pembayaran: <strong>{{ $order->payment_status }}</strong><br>
                        Tanggal: <strong>{{ $order->created_at }}</strong>
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
                            @forelse ($items as $item)
                                <tr>
                                    <td>{{ $item->name }}</td>
                                    <td>Rp{{ number_format($item->price, 0, ',', '.') }}</td>
                                    <td>{{ $item->qty }}</td>
                                    <td>Rp{{ number_format($item->price * $item->qty, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Tidak ada produk pada pesanan ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3">Total</th>
                                <th>Rp{{ number_format($order->total, 0, ',', '.') }}</th>
                            </tr>
                        </tfoot>
                    </table>
                    @if ($order->bukti_transfer)
                        <div class="mt-3">
                            <label>Bukti Pembayaran:</label><br>
                            <img src="{{ asset('storage/' . ltrim($order->bukti_transfer, '/')) }}" width="200"
                                alt="Bukti Transfer">
                        </div>
                    @endif
                    <a href="{{ url('/') }}" class="btn btn-secondary mt-3">Kembali ke Beranda</a>
                </div>
            </div>
        </div>
    </div>
@endsection

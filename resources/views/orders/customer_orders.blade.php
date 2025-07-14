@extends('layouts.landing.app')
@section('content')
    <div class="container">
        <h2 class="mb-4">Pesanan Saya</h2>
        <div class="card shadow mb-4">
            <div class="card-body">
                @if (count($orders) > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Kode Pesanan</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Pembayaran</th>
                                    <th>Tanggal</th>
                                    <th>Bukti Pembayaran</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $i => $order)
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td>{{ $order->order_code }}</td>
                                        <td>Rp{{ number_format($order->total, 0, ',', '.') }}</td>
                                        <td>{{ $order->status }}</td>
                                        <td>{{ $order->payment_status }}</td>
                                        <td>{{ $order->created_at }}</td>
                                        <td>
                                            @if ($order->bukti_transfer)
                                                <img src="{{ asset('storage/' . ltrim($order->bukti_transfer, '/')) }}"
                                                    width="100" alt="Bukti Transfer">
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('orders.payment', ['id' => $order->id]) }}"
                                                class="btn btn-info btn-sm">Detail</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info">Belum ada pesanan.</div>
                @endif
            </div>
        </div>
    </div>
@endsection

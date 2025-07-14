@extends('layouts.app')
@section('content')
    <div class="container">
        <h2 class="mb-4">Detail Pesanan #{{ $order->id }}</h2>
        <div class="card shadow mb-4">
            <div class="card-body">
                <ul class="list-group mb-3">
                    <li class="list-group-item"><strong>User:</strong> {{ $order->user_name }}</li>
                    <li class="list-group-item"><strong>Total:</strong> Rp{{ number_format($order->total, 0, ',', '.') }}
                    </li>
                    <li class="list-group-item"><strong>Status:</strong> {{ $order->status }}</li>
                    <li class="list-group-item"><strong>Payment Status:</strong> {{ $order->payment_status }}</li>
                    <li class="list-group-item"><strong>Metode Pembayaran:</strong> {{ $order->payment_method }}</li>
                    <li class="list-group-item"><strong>Tanggal:</strong> {{ $order->created_at }}</li>

                    @if ($order->bukti_transfer)
                        <li class="list-group-item"><strong>Bukti Transfer:</strong><br>
                            <img src="{{ Storage::url($order->bukti_transfer) }}" width="200">
                        </li>
                    @endif
                </ul>
                <form method="POST" action="{{ route('admin.orders.update', $order->id) }}">
                    @csrf
                    <div class="mb-3">
                        <label>Status Pesanan</label>
                        <select name="status" class="form-control">
                            <option value="pending" @if ($order->status == 'pending') selected @endif>Pending</option>
                            <option value="setuju" @if ($order->status == 'setuju') selected @endif>Setuju</option>
                            <option value="ditolak" @if ($order->status == 'ditolak') selected @endif>Ditolak</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Status Pembayaran</label>
                        <select name="payment_status" class="form-control">
                            <option value="unpaid" @if ($order->payment_status == 'unpaid') selected @endif>Belum Dibayar
                            </option>
                            <option value="paid" @if ($order->payment_status == 'paid') selected @endif>Sudah Dibayar</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
@endsection

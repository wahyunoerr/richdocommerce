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
                    <form id="confirmOrderForm" class="mt-3">
                        <button type="button" class="btn btn-success" data-toggle="modal"
                            data-target="#paymentModal">Konfirmasi Pesanan</button>
                    </form>

                    <!-- Modal Pembayaran -->
                    <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('orders.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="paymentModalLabel">Konfirmasi & Pembayaran Pesanan</h5>
                                        <button type="button" class="btn-close" data-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Total Pembayaran: <strong>Rp{{ number_format($total, 0, ',', '.') }}</strong></p>
                                        <div class="mb-3">
                                            <label class="form-label">Detail Pesanan</label>
                                            <ul class="list-group mb-3">
                                                @foreach ($products as $product)
                                                    <li
                                                        class="list-group-item d-flex justify-content-between align-items-center">
                                                        <span>{{ $product->name }} (x{{ $cart[$product->id] }})</span>
                                                        <span>Rp{{ number_format($product->price * $cart[$product->id], 0, ',', '.') }}</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        <div class="mb-3">
                                            <label for="payment_method" class="form-label">Metode Pembayaran</label>
                                            <select name="payment_method" id="payment_method"
                                                class="form-select form-control" required>
                                                <option value="transfer">Transfer Bank</option>
                                                <option value="cod">COD</option>
                                            </select>
                                        </div>
                                        <div class="mb-3" id="buktiTransferGroup">
                                            <label for="bukti_transfer" class="form-label">Upload Bukti Transfer</label>
                                            <input type="file" name="bukti_transfer" id="bukti_transfer"
                                                class="form-control" accept="image/*">
                                        </div>
                                        <input type="hidden" name="total" value="{{ $total }}">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary">Kirim & Bayar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const paymentMethod = document.getElementById('payment_method');
            const buktiTransferGroup = document.getElementById('buktiTransferGroup');
            paymentMethod.addEventListener('change', function() {
                if (this.value === 'transfer') {
                    buktiTransferGroup.style.display = 'block';
                    document.getElementById('bukti_transfer').required = true;
                } else {
                    buktiTransferGroup.style.display = 'none';
                    document.getElementById('bukti_transfer').required = false;
                }
            });
            // Inisialisasi
            if (paymentMethod.value === 'transfer') {
                buktiTransferGroup.style.display = 'block';
                document.getElementById('bukti_transfer').required = true;
            } else {
                buktiTransferGroup.style.display = 'none';
                document.getElementById('bukti_transfer').required = false;
            }
        });
    </script>
@endsection

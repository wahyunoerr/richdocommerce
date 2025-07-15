@extends('layouts.app')
@section('content')
    <div class="container">
        <h2 class="mb-4">Laporan Stok Produk</h2>
        <div class="card shadow mb-4">
            <div class="card-header bg-purple text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Laporan Stok Produk</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 5%">No</th>
                                <th>Nama</th>
                                <th>Kategori</th>
                                <th>Harga</th>
                                <th>Gambar</th>
                                <th>Stok Awal</th>
                                <th>Stok Akhir</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($products as $i => $product)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->category_name ?? '-' }}</td>
                                    <td>Rp{{ number_format($product->price, 0, ',', '.') }}</td>
                                    <td><img src="{{ asset('images/' . $product->image) }}" width="60"></td>
                                    <td>{{ $stok_awal[$product->id] ?? 0 }}</td>
                                    <td>{{ $stok_akhir[$product->id] ?? 0 }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">Tidak ada produk yang ditemukan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

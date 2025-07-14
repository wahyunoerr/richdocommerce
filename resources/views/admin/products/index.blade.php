@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-4">Manajemen Produk</h2>
        <div class="card shadow mb-4">
            <div class="card-header bg-purple text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Manajemen Produk</h4>
                <a href="{{ route('admin.products.create') }}" class="btn bg-maroon btn-sm ms-auto"
                    style="margin-left:auto;">Tambah Produk</a>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <div class="table-responsive">
                    <table class="table table-bordered align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 5%">No</th>
                                <th>Nama</th>
                                <th>Kategori</th>
                                <th>Harga</th>
                                <th>Gambar</th>
                                <th>Stok</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($products as $i => $product)
                                <tr>
                                    <td>{{ ($products->currentPage() - 1) * $products->perPage() + $i + 1 }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->category_name }}</td>
                                    <td>Rp{{ number_format($product->price, 0, ',', '.') }}</td>
                                    <td><img src="{{ asset('images/' . $product->image) }}" width="60"></td>
                                    <td>{{ $product->stok }}</td>
                                    <td>
                                        <a href="{{ route('admin.products.edit', $product->id) }}"
                                            class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST"
                                            style="display:inline-block">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Yakin hapus?')">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">Tidak ada produk yang ditemukan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center mt-3">{{ $products->links() }}</div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.app')
@section('content')
    <div class="container">
        <h2 class="mb-4">Mutasi Stok Produk</h2>
        <div class="card shadow mb-4">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Mutasi Stok Produk</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.mutasi.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="product_id" class="form-label">Produk</label>
                        <select name="product_id" class="form-control" required>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="type" class="form-label">Tipe Mutasi</label>
                        <select name="type" class="form-control" required>
                            <option value="in">Penambahan</option>
                            <option value="out">Pengurangan</option>
                            <option value="correction">Koreksi</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="qty" class="form-label">Jumlah</label>
                        <input type="number" name="qty" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Keterangan</label>
                        <input type="text" name="description" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('admin.mutasi.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
@endsection

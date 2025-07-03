@extends('layouts.app')
@section('content')
    <div class="container">
        <h2 class="mb-4">Tambah Kategori</h2>
        <div class="card shadow mb-4">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Tambah Kategori</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.categories.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label>Nama Kategori</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
@endsection

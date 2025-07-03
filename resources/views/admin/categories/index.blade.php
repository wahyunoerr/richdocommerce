@extends('layouts.app')
@section('content')
    <div class="container">
        <h2 class="mb-4">Manajemen Kategori</h2>
        <div class="card shadow mb-4">
            <div class="card-header bg-purple text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Manajemen Kategori</h4>
                <a href="{{ route('admin.categories.create') }}" class="btn bg-maroon btn-sm ms-auto"
                    style="margin-left:auto;">Tambah Kategori</a>
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
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($categories as $i => $category)
                                <tr>
                                    <td>{{ ($categories->currentPage() - 1) * $categories->perPage() + $i + 1 }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td>
                                        <a href="{{ route('admin.categories.edit', $category->id) }}"
                                            class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST"
                                            style="display:inline-block">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Yakin hapus?')">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">Tidak ada kategori yang ditemukan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center mt-3">{{ $categories->links() }}</div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.app')
@section('content')
    <div class="container">
        <h2 class="mb-4">Riwayat Mutasi Stok</h2>
        <div class="card shadow mb-4">
            <div class="card-header bg-purple text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Riwayat Mutasi Stok</h4>
                <a href="{{ route('admin.mutasi.create') }}" class="btn bg-maroon btn-sm ms-auto"
                    style="margin-left:auto;">Tambah Mutasi</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 5%">No</th>
                                <th>Tanggal</th>
                                <th>Produk</th>
                                <th>Tipe</th>
                                <th>Jumlah</th>
                                <th>Keterangan</th>
                                <th>Admin</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($mutasi as $i => $m)
                                <tr>
                                    <td>{{ ($mutasi->currentPage() - 1) * $mutasi->perPage() + $i + 1 }}</td>
                                    <td>{{ $m->created_at }}</td>
                                    <td>{{ $m->product_name }}</td>
                                    <td>{{ ucfirst($m->type) }}</td>
                                    <td>{{ $m->qty }}</td>
                                    <td>{{ $m->description }}</td>
                                    <td>{{ $m->admin_name }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">Tidak ada data mutasi stok.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center mt-3">{{ $mutasi->links() }}</div>
            </div>
        </div>
    </div>
@endsection

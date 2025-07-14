@extends('layouts.app')
@section('content')
    <div class="container">
        <h3>Riwayat Mutasi Stok</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Produk</th>
                    <th>Tipe</th>
                    <th>Jumlah</th>
                    <th>Keterangan</th>
                    <th>Admin</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($mutasi as $m)
                    <tr>
                        <td>{{ $m->created_at }}</td>
                        <td>{{ $m->product_name }}</td>
                        <td>{{ ucfirst($m->type) }}</td>
                        <td>{{ $m->qty }}</td>
                        <td>{{ $m->description }}</td>
                        <td>{{ $m->user_id }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $mutasi->links() }}
    </div>
@endsection

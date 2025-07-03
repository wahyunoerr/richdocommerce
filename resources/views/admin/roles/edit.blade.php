@extends('layouts.app')
@section('content')
    <div class="container">
        <h2 class="mb-4">Edit Role</h2>
        <div class="card shadow mb-4">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Edit Role</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.roles.update', $role->id) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="mb-3">
                        <label>Nama Role</label>
                        <input type="text" name="name" class="form-control" value="{{ $role->name }}" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
@endsection

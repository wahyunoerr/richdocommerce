@extends('layouts.app')
@section('content')
    <div class="container">
        <h2 class="mb-4">Edit User</h2>
        <div class="card shadow mb-4">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Edit User</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="mb-3">
                        <label>Nama</label>
                        <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                    </div>
                    <div class="mb-3">
                        <label>Password (isi jika ingin mengganti)</label>
                        <input type="password" name="password" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Role</label>
                        <select name="roles[]" class="form-control" multiple required>
                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}" @if ($user->roles->pluck('name')->contains($role->name)) selected @endif>
                                    {{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
@endsection

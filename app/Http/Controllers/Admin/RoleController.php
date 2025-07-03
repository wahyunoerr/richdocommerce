<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    public function index()
    {
        $roles = Role::paginate(10);
        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        return view('admin.roles.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|unique:roles,name',
        ]);
        Role::create($data);
        return redirect()->route('admin.roles.index')->with('success', 'Role berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);
        return view('admin.roles.edit', compact('role'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|unique:roles,name,' . $id,
        ]);
        $role = Role::findOrFail($id);
        $role->update($data);
        return redirect()->route('admin.roles.index')->with('success', 'Role berhasil diupdate!');
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();
        return redirect()->route('admin.roles.index')->with('success', 'Role berhasil dihapus!');
    }
}

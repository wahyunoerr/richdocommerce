<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    public function index()
    {
        $roles = DB::table('roles')->paginate(10);
        return view('admin.roles.index', compact('roles'));
    }
    public function create()
    {
        return view('admin.roles.create');
    }
    public function store(Request $request)
    {
        DB::table('roles')->insert([
            'name' => $request->name,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        return redirect()->route('admin.roles.index')->with('success', 'Role berhasil ditambahkan');
    }
    public function edit($id)
    {
        $role = DB::table('roles')->where('id', $id)->first();
        return view('admin.roles.edit', compact('role'));
    }
    public function update(Request $request, $id)
    {
        DB::table('roles')->where('id', $id)->update([
            'name' => $request->name,
            'updated_at' => now(),
        ]);
        return redirect()->route('admin.roles.index')->with('success', 'Role berhasil diupdate');
    }
    public function destroy($id)
    {
        DB::table('roles')->where('id', $id)->delete();
        return redirect()->route('admin.roles.index')->with('success', 'Role berhasil dihapus');
    }
}

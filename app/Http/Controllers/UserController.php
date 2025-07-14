<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        $users = DB::table('users')->paginate(10);
        $userRoles = DB::table('model_has_roles')
            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->select('model_has_roles.model_id', 'roles.name')
            ->get()
            ->groupBy('model_id');
        return view('admin.users.index', compact('users', 'userRoles'));
    }

    public function create()
    {
        $roles = DB::table('roles')->get();
        return view('admin.users.create', compact('roles'));
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $userId = DB::table('users')->insertGetId([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        // Spatie: assign roles
        if ($request->has('roles')) {
            foreach ($request->roles as $role) {
                DB::table('model_has_roles')->insert([
                    'role_id' => $role,
                    'model_type' => 'App\\Models\\User',
                    'model_id' => $userId,
                ]);
            }
        }
        return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan');
    }

    public function edit($id)
    {
        $user = DB::table('users')->where('id', $id)->first();
        $roles = DB::table('roles')->get();
        $userRoles = DB::table('model_has_roles')->where('model_id', $id)->pluck('role_id')->toArray();
        return view('admin.users.edit', compact('user', 'roles', 'userRoles'));
    }

    public function update(\Illuminate\Http\Request $request, $id)
    {
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'updated_at' => now(),
        ];
        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        }
        DB::table('users')->where('id', $id)->update($data);
        // Spatie: sync roles
        DB::table('model_has_roles')->where('model_id', $id)->delete();
        if ($request->has('roles')) {
            foreach ($request->roles as $role) {
                DB::table('model_has_roles')->insert([
                    'role_id' => $role,
                    'model_type' => 'App\\Models\\User',
                    'model_id' => $id,
                ]);
            }
        }
        return redirect()->route('admin.users.index')->with('success', 'User berhasil diupdate');
    }

    public function destroy($id)
    {
        DB::table('users')->where('id', $id)->delete();
        DB::table('model_has_roles')->where('model_id', $id)->delete();
        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus');
    }
}

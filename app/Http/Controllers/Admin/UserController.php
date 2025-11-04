<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * 📋 Mostrar lista de usuarios
     */
    public function index()
    {
        // Carga usuarios con su rol asociado
        $users = User::with('role')->orderBy('name')->get();
        $roles = Role::orderBy('id')->get();

        return view('admin.users.index', compact('users', 'roles'));
    }

    /**
     * 🟩 Crear nuevo usuario
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|min:6',
            'role_id'   => 'required|exists:roles,id',
        ]);

        User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'role_id'   => $request->role_id,
        ]);

        return redirect()->back()->with('success', 'Usuario creado correctamente.');
    }

    /**
     * 🟨 Actualizar usuario existente
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email,' . $user->id,
            'password'  => 'nullable|min:6',
            'role_id'   => 'required|exists:roles,id',
        ]);

        $user->update([
            'name'      => $request->name,
            'email'     => $request->email,
            'role_id'   => $request->role_id,
            'password'  => $request->filled('password')
                ? Hash::make($request->password)
                : $user->password,
        ]);

        return redirect()->back()->with('success', 'Usuario actualizado correctamente.');
    }

    /**
     * ❌ Eliminar usuario
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->back()->with('success', 'Usuario eliminado correctamente.');
    }
}

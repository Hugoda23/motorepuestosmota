<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 🔹 Verificar que exista al menos un rol "Administrador"
        $adminRole = Role::firstOrCreate(
            ['name' => 'admin'],
            ['display_name' => 'Administrador', 'description' => 'Acceso total al sistema']
        );

        // 🔹 Crear usuario administrador
        User::create([
            'name'      => 'Administrador',
            'email'     => 'admin@mota.com',
            'password'  => Hash::make('12345678'),
            'role_id'   => $adminRole->id, // Asigna el rol
        ]);
    }
}

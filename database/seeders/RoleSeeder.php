<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crea roles base del sistema
        $roles = [
            [
                'name' => 'admin',
                'display_name' => 'Administrador',

            ],
            [
                'name' => 'empleado',
                'display_name' => 'Empleado',
            ],
            [
                'name' => 'cliente',
                'display_name' => 'Cliente',
            ],
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role['name']], $role);
        }
    }
}

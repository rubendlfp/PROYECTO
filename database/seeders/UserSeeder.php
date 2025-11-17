<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Crear usuario administrador
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@test.com',
            'password' => Hash::make('password'),
            'tipo_usuario' => 1,
            'saldo' => 10000
        ]);

        // Crear usuario normal
        User::create([
            'name' => 'Usuario Test',
            'email' => 'user@test.com',
            'password' => Hash::make('password'),
            'tipo_usuario' => 0,
            'saldo' => 5000
        ]);
    }
}

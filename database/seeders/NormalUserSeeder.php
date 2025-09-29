<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class NormalUserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Usuario Normal',
            'email' => 'usuario@example.com',
            'password' => Hash::make('password123'), // puedes cambiar la contraseña
            'role' => 'user', // rol normal
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

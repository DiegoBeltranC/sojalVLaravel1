<?php

namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::insert([
            [
                'nombre' => 'Madox Actualizado',
                'apellidos' => ['paterno' => 'Pérez', 'materno' => 'López'],
                'fecha_nacimiento' => '2025-02-05',
                'telefono' => '1234567890',
                'correo' => 'albertobelca66@gmail.com',
                'password' => Hash::make('password123'),
                'rol' => 'trabajador',
                'curp' => 'ABCD123456HDFRZZ01',
                'rfc' => 'ABCD123456XXX',
                'fecha_creacion' => now(),
                'updated_at' => now(),
                'created_at' => now(),
            ],
            [
                'nombre' => 'Carlos Gómez',
                'apellidos' => ['paterno' => 'Gómez', 'materno' => 'Martínez'],
                'fecha_nacimiento' => '1998-10-12',
                'telefono' => '9876543210',
                'correo' => 'carlosgomez@example.com',
                'password' => Hash::make('password123'),
                'rol' => 'trabajador',
                'curp' => 'CGOM981012HDFRZZ01',
                'rfc' => 'CGOM981012XXX',
                'fecha_creacion' => now(),
                'updated_at' => now(),
                'created_at' => now(),
            ],
            [
                'nombre' => 'Administrador',
                'apellidos' => ['paterno' => 'Admin', 'materno' => 'User'],
                'fecha_nacimiento' => '1990-01-01',
                'telefono' => '5551234567',
                'correo' => 'admin@example.com',
                'password' => Hash::make('admin123'),
                'rol' => 'admin',
                'curp' => 'ADMIN901231HDFRZZ01',
                'rfc' => 'ADMIN901231XXX',
                'fecha_creacion' => now(),
                'updated_at' => now(),
                'created_at' => now(),
            ]
        ]);
    }
}

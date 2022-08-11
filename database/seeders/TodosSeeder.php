<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Grupo;
use Illuminate\Support\Facades\Hash;

class TodosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'name' => 'Oscar David',
            'apellidos' => 'Castañeda Rivera',
            'email' => 'oscardavid120896@gmail.com',
            'password' => Hash::make('password'),
            'rol' => 'directivo',
        ]);

        $ventas = User::create([
            'name' => 'Diana Angélica',
            'apellidos' => 'García Lira',
            'email' => 'davidoscar120896@gmail.com',
            'password' => Hash::make('password'),
            'rol' => 'profesor',
        ]);

        $ventas = User::create([
            'name' => 'Raúl Alberto',
            'apellidos' => 'Rodríguez Flores',
            'email' => 'oscar.rivera120896@gmail.com',
            'password' => Hash::make('password'),
            'rol' => 'alumno',
        ]);
    }
}

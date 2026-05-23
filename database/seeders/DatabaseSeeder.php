<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ─── Admin inicial do sistema ────────────────────────────────
        User::create([
            'name'     => 'Joelson Pedo Mutute',
            'email'    => 'joelsonmututedev@gmail.com',
            'password' => Hash::make('olamundo123'),
            'role'     => 'admin',
        ]);
    }
}

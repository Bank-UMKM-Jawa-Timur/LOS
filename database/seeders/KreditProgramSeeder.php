<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class KreditProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Kredit Program',
            'email' => 'kreditprogram@mail.com',
            'password' => Hash::make('1'),
            'role' => 'Kredit Program',
            'created_at' => now(),
        ]);
    }
}

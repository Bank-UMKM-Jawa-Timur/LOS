<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AddDireksiUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create(
            [
                'name' => 'Direksi',
                'email' => 'direksi@mail.com',
                'password' => \Hash::make('12345678'),
                'role' => 'Direksi',
                'created_at' => now(),
            ]
        );
    }
}

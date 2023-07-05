<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AddKreditUmumUserSeeder extends Seeder
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
                'name' => 'Kredit Umum',
                'email' => 'kreditumum@mail.com',
                'password' => \Hash::make('12345678'),
                'role' => 'Kredit Umum',
                'nip' => '123',
                'created_at' => now(),
            ]
        );
    }
}

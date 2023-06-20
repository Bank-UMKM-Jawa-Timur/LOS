<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AddSPIUserSeeder extends Seeder
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
                'name' => 'SPI',
                'email' => 'spi@mail.com',
                'password' => \Hash::make('12345678'),
                'role' => 'SPI',
                'created_at' => now(),
            ]
        );
    }
}

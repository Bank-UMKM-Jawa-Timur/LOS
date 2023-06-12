<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@mail.com',
            'password' => \Hash::make('12345678'),
            'role' => 'Administrator',
            'created_at' => now(),
        ]);
        User::create(
            [
                'name' => 'Pincab',
                'email' => 'pincab@mail.com',
                'password' => \Hash::make('12345678'),
                'role' => 'Pincab',
                'created_at' => now(),
            ]
        );
        User::create(
            [
                'name' => 'PBP',
                'email' => 'pbp@mail.com',
                'password' => \Hash::make('12345678'),
                'role' => 'PBP',
                'created_at' => now(),
            ]
        );
        User::create(
            [
                'name' => 'Penyelia Kredit',
                'email' => 'penyelia@mail.com',
                'password' => \Hash::make('12345678'),
                'role' => 'Penyelia Kredit',
                'created_at' => now(),
            ]
        );
        User::create(
            [
                'name' => 'Staf Analis Kredit',
                'email' => 'stafkredit@mail.com',
                'password' => \Hash::make('12345678'),
                'role' => 'Staf Analis Kredit',
                'created_at' => now(),
            ]
        );
    }
}

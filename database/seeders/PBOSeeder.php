<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class PBOSeeder extends Seeder
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
                'name' => 'PBO',
                'email' => 'pbo@mail.com',
                'password' => \Hash::make('12345678'),
                'role' => 'PBO',
                'id_cabang' => 1,
                'created_at' => now(),
            ]
        );
    }
}

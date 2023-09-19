<?php

namespace Database\Seeders;

use App\Models\Cabang;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CabangEmailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $allCabang = Cabang::select('id', 'cabang')->get();
        foreach ($allCabang as $key => $value) {
            $email = 'cabang'.strtolower(str_replace(' ', '', $value->cabang)).'@bankumkm.id';
            DB::table('cabang')->where('id', $value->id)->update([
                'email' => $email,
            ]);
        }
    }
}

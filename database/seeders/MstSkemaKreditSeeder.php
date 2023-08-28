<?php

namespace Database\Seeders;

use App\Models\MstProdukKredit;
use App\Models\MstSkemaKredit;
use Illuminate\Database\Seeder;

class MstSkemaKreditSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pkpj_id = MstProdukKredit::select('id', 'name')->where('name', 'PKPJ')->first()->id;
        $kkb_id = MstProdukKredit::select('id', 'name')->where('name', 'KKB')->first()->id;
        $umroh_id = MstProdukKredit::select('id', 'name')->where('name', 'Talangan Umroh')->first()->id;
        $prokesra_id = MstProdukKredit::select('id', 'name')->where('name', 'Prokesra')->first()->id;
        $kusuma_id = MstProdukKredit::select('id', 'name')->where('name', 'Kusuma')->first()->id;

        // PKPJ
        MstSkemaKredit::create([
            'produk_kredit_id' => $pkpj_id,
            'name' => 'Modal Kerja',
        ]);
        MstSkemaKredit::create([
            'produk_kredit_id' => $pkpj_id,
            'name' => 'Investasi',
        ]);

        // KKB
        MstSkemaKredit::create([
            'produk_kredit_id' => $kkb_id,
            'name' => 'Konsumtif',
        ]);

        // Talangan Umroh
        MstSkemaKredit::create([
            'produk_kredit_id' => $umroh_id,
            'name' => 'Konsumtif',
        ]);


        // Prokesra
        MstSkemaKredit::create([
            'produk_kredit_id' => $prokesra_id,
            'name' => 'Modal Kerja',
        ]);

        MstSkemaKredit::create([
            'produk_kredit_id' => $prokesra_id,
            'name' => 'Investasi',
        ]);


        // Kusuma
        MstSkemaKredit::create([
            'produk_kredit_id' => $kusuma_id,
            'name' => 'Modal Kerja',
        ]);

        MstSkemaKredit::create([
            'produk_kredit_id' => $kusuma_id,
            'name' => 'Investasi',
        ]);
    }
}

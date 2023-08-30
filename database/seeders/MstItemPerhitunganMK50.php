<?php

namespace Database\Seeders;

use App\Models\MstSkemaLimit;
use Illuminate\Database\Seeder;

class MstItemPerhitunganMK50 extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $modalKerja = MstSkemaLimit::select(
            'mst_skema_limit.*',
            'skema.name'
        )
        ->join('mst_skema_kredit AS skema', 'skema.id', 'mst_skema_limit.skema_kredit_id')
        ->where('skema.name', 'Modal Kerja')
        ->where('mst_skema_limit.from', 0)
        ->where('mst_skema_limit.to', 50000000)
        ->first();

        $lev1 = [
            'Neraca',
            'Laba Rugi',
        ];

        $lev2 = [
            'Aktifa',
            'Pasiva',
            'Penerimaan Sebelum Kredit',
            'Penerimaan Sesudah Kredit',
            'Pengeluaran Sebelum Kredit',
            'Pengeluaran Sesudah Kredit',
            'Pendapatan Bersih',
            'Pendapatan Bersih Tiap Bulan',
            'Angsuran Pokok Per Bulan',
            'Sisa Pendapatan bersih per bulan',
            'Perputaran usaha',
            'Kebutuhan Modal Kerja',
            'Modal Kerja Sekarang',
            'Kebutuhan Modal',
            'Utang Bank',
            'Kebutuhan Kredit',
            'Dibulatkan',
        ];

        $lev3 = [];
    }
}

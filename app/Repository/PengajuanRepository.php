<?php
namespace App\Repository;

use App\Models\ItemModel;
use App\Models\Kecamatan;
use App\Models\PengajuanModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class PengajuanRepository
{
    public function getWithJawaban($id) {
        /**
         * 1. Load pengajuan
         * 2. Load dagulir
         * 3. Load Aspek
         * 4. Load item
         * 5. Load jawaban
         */
        // 1. Load pengajuan
        $data = PengajuanModel::with([
                                    'dagulir',
                                    'pendapatPerAspekStaf',
                                ])
                                ->find($id);
        // 2. Load Aspek
        $data->aspek = ItemModel::select('id', 'nama')
                        ->where('level', 1)
                        ->where('id', '!=', 13) // exclude data umum
                        ->orderBy('sequence')
                        ->get();
        return $data;
    }
}

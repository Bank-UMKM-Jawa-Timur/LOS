<?php
namespace App\Repository;

use App\Models\PengajuanDagulir;

class PengajuanDegulirRepository
{
    function get($search, $limit=10, $page=1) {
        $data = PengajuanDagulir::where(function($query) use ($search) {
            $query->where('kode_pendaftaran','like', "%$search%");
        })->latest()->paginate(2);
        return $data;
    }
}
?>

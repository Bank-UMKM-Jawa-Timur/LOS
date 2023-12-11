<?php
namespace App\Repository;

use App\Models\PengajuanDagulir;

class PengajuanDegulirRepository
{
    function get($search, $limit=10, $page=1) {
        $data = PengajuanDagulir::with('pengajuan')->where(function($query) use ($search) {
            $query->where('kode_pendaftaran','like', "%$search%")
                    ->orWhere('nama','like', "%$search%")
                    ->orWhere('kode_pendaftaran','like', "%$search%");
        })
        ->latest()
        ->paginate($limit);
        return $data;
    }

    function detail($id) {
        $data = PengajuanDagulir::with('pengajuan')->where('id',$id)->first();
        return $data;
    }
}
?>

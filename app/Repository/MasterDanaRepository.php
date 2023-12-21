<?php

namespace App\Repository;

use App\Models\DanaCabang;

class MasterDanaRepository
{
    function getDanaCabang($search, $page, $limit = 10) {
        $data = DanaCabang::with('cabang')
                    ->where(function ($query) use ($search) {
                        $query->whereHas('cabang', function ($subQuery) use ($search) {
                            $subQuery->where('cabang', 'like', "%$search%");
                        })
                        ->orWhereDate('created_at', $search)
                        ->orWhere('dana_modal','like', "%$search%")
                        ->orWhere('dana_idle','like', "%$search%")
                        ->orWhere('plafon_akumulasi','like', "%$search%")
                        ->orWhere('baki_debet','like', "%$search%");
                    })
                    ->latest()
                    ->paginate($limit);
        return $data;
    }

}

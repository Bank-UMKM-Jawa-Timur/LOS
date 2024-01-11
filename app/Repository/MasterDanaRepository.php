<?php

namespace App\Repository;

use App\Models\DanaCabang;
use App\Models\MasterDana;
use App\Models\MasterDDAngsuran;

class MasterDanaRepository
{
    function getDanaCabang($search, $page, $limit = 10) {
        $data = DanaCabang::with([
                'cabang',
                'loan'
            ])
            ->withSum('loan','plafon')
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
        foreach ($data as $key => $value) {
            $dana_modal = $value->dana_modal;
            $total_angsuran = 0;
            if ($value->loan) {
                $loan = $value->loan;
                foreach ($loan as $l) {
                    $angsuran = MasterDDAngsuran::where('no_loan', $l->no_loan)->sum('pokok_pembayaran');
                    $total_angsuran += $angsuran;
                }
            }
            $value->loan_sum_angsuran = $total_angsuran;

            $bade = $value->loan_sum_plafon - $total_angsuran;
            $value->baki_debet = $bade;

            $value->dana_idle = $dana_modal - $bade;
        }
        return $data;
    }

    function getMasterDD() {
        $data = DanaCabang::with([
            'cabang',
            'loan'
        ])
            ->withSum('loan','plafon','cabang')
            ->latest()->get();

        $data->transform(function ($value) {
            $dana_modal = $value->dana_modal;
            $total_angsuran = 0;

            if ($value->loan) {
                $loan = $value->loan;

                foreach ($loan as $l) {
                    $angsuran = MasterDDAngsuran::where('no_loan', $l->no_loan)->sum('pokok_pembayaran');
                    $total_angsuran += $angsuran;
                }
            }

            $value->loan_sum_angsuran = $total_angsuran;

            $bade = $value->loan_sum_plafon - $total_angsuran;
            $value->baki_debet = $bade;

            $value->dana_idle = $dana_modal - $bade;


            return $value;
        });

        return $data;
    }

    function getDari($id) {
            $data = DanaCabang::with([
            'cabang',
            'loan'
            ])
            ->withSum('loan','plafon')
                    ->where(function ($query) use ($id) {
                        $query->whereHas('cabang', function ($subQuery) use ($id) {
                            $subQuery->where('id', $id);
                        });
                    })
                    ->get();
            $data->transform(function ($value) {
                $dana_modal = $value->dana_modal;
                $total_angsuran = 0;

                if ($value->loan) {
                    $loan = $value->loan;
                    $loan->user = 'pincab';
                    foreach ($loan as $l) {
                        $angsuran = MasterDDAngsuran::where('no_loan', $l->no_loan)->sum('pokok_pembayaran');
                        $total_angsuran += $angsuran;
                    }
                }

                $value->loan_sum_angsuran = $total_angsuran;

                $bade = $value->loan_sum_plafon - $total_angsuran;
                $value->baki_debet = $bade;

                $value->dana_idle = $dana_modal - $bade;


                return $value;
            });

            return $data[0];
    }


}

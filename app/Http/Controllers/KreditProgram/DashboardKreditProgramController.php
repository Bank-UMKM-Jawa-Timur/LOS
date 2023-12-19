<?php

namespace App\Http\Controllers\KreditProgram;

use App\Http\Controllers\Controller;
use App\Models\DanaCabang;
use App\Models\MasterDana;
use Illuminate\Http\Request;

class DashboardKreditProgramController extends Controller
{
    function index() {
        $total_modal = MasterDana::latest()->first()->dana_modal;
        $total_idle = MasterDana::latest()->first()->dana_idle;
        $total_baket = DanaCabang::latest()->sum('baki_debet');
        return view('dagulir.master-dana.dashboard',[
            'total_modal' => $total_modal,
            'total_idle' => $total_idle,
            'total_baket' => $total_baket
        ]);
    }
}

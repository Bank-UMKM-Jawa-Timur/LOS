<?php

namespace App\Http\Controllers\KreditProgram;

use App\Http\Controllers\Controller;
use App\Models\Cabang;
use App\Models\DanaCabang;
use App\Models\MasterDana;
use App\Models\PengajuanDagulir;
use App\Models\PengajuanModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardKreditProgramController extends Controller
{
    function index() {
        $total_modal = MasterDana::latest()->first()->dana_modal ?? 0;
        $total_idle = MasterDana::latest()->first()->dana_idle ?? 0;
        $total_baket = DanaCabang::latest()->sum('baki_debet');
        $total_pengajuan = PengajuanDagulir::count();
        $total_disetujui = PengajuanModel::where('skema_kredit', 'Dagulir')->where('posisi', 'Selesai')->count();
        $total_ditolak = PengajuanModel::where('skema_kredit', 'Dagulir')->where('posisi', 'Ditolak')->count();
        $total_diproses = PengajuanModel::where('skema_kredit', 'Dagulir')->whereNotIn('posisi', ['Ditolak', 'Selesai'])->count();

        $dataCabang = Cabang::orderBy('kode_cabang')->where('kode_cabang', '!=', '000')->get();

        $chat_dagulir = [];
        foreach ($dataCabang as $value) {
            $cabang = $value->cabang;
            $modal = DB::table('dd_cabang')->where('id_cabang', $value->id)->sum('dana_modal');

            $dana_modal = [
                'cabang' => $cabang,
                'dana' => intval($modal)
            ];

            array_push($chat_dagulir, $dana_modal);
        }

        return view('dagulir.master-dana.dashboard',[
            'total_pengajuan' => $total_pengajuan,
            'total_disetujui' => $total_disetujui,
            'total_ditolak' => $total_ditolak,
            'total_diproses' => $total_diproses,
            'total_modal' => $total_modal,
            'total_idle' => $total_idle,
            'total_baket' => $total_baket,
            'dana_modal' => $chat_dagulir,
        ]);
    }
}

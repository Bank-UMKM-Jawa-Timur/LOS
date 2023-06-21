<?php

namespace App\Http\Controllers;

use App\Models\LogPengajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogPengajuanController extends Controller
{
    public function __construct()
    {
        // $this->param['pageIcon'] = 'fa fa-database';
        // $this->param['parentMenu'] = '/desa';
        // $this->param['current'] = 'Desa';
    }

    public function index($id){
        $this->param['pageTitle'] = 'Log Pengajuan';
        return view('pengajuan-kredit.log_pengajuan',$this->param);
    }

    public function store($content, $idPengajuan)
    {
        $newActivity = new LogPengajuan();
        $newActivity->id_pengajuan = $idPengajuan;
        $newActivity->user_id = Auth::user()->id;
        $newActivity->activity = $content;
        $newActivity->nip = Auth::user()->nip;

        $newActivity->save();
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\LogPengajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogPengajuanController extends Controller
{
    //
    public function store($content, $idPengajuan, $user_id, $nip)
    {
        $newActivity = new LogPengajuan();
        $newActivity->id_pengajuan = $idPengajuan;
        $newActivity->user_id = $user_id;
        $newActivity->activity = $content;
        $newActivity->nip = $nip;

        $newActivity->save();
    }
    
}

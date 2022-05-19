<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendapatPerAspek extends Model
{
    use HasFactory;

    protected $table = 'pendapat_dan_usulan_per_aspek';

    public function pengajuan()
    {
        return $this->belongsTo('\App\Models\PengajuanModel', 'id_pengajuan');
    }
}

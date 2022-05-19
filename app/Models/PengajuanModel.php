<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanModel extends Model
{
    use HasFactory;
    protected $table = "pengajuan";

    public function pendapatPerAspek()
    {
        return $this->hasMany('\App\Models\PendapatPerAspek', 'id_pengajuan');
    }

}

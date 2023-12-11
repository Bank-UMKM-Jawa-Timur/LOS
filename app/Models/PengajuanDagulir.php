<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanDagulir extends Model
{
    use HasFactory;
    protected $table = 'pengajuan_dagulir';

    public function pengajuan() {
        return $this->hasOne(PengajuanModel::class,'dagulir_id');
    }
}


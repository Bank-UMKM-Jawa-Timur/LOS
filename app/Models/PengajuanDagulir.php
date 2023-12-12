<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanDagulir extends Model
{
    use HasFactory;
    protected $table = 'pengajuan_dagulir';

    public function pengajuan() {
        return $this->hasOne(PengajuanModel::class,'dagulir_id','id');
    }
    function kec_ktp() {
        return $this->belongsTo(Kecamatan::class,'kec_ktp');
    }

    function kotakab_ktp() {
        return $this->belongsTo(Kabupaten::class,'kotakab_ktp');
    }

    function kec_dom() {
        return $this->belongsTo(Kecamatan::class,'kec_dom');
    }

    function kotakab_dom() {
        return $this->belongsTo(Kabupaten::class,'kotakab_dom');
    }

    function kec_usaha() {
        return $this->belongsTo(Kecamatan::class,'kec_usaha');
    }

    function kotakab_usaha() {
        return $this->belongsTo(Kabupaten::class,'kotakab_usaha');
    }


}


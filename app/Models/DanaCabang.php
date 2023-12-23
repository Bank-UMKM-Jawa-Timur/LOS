<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DanaCabang extends Model
{
    use HasFactory;
    protected $table = 'dd_cabang';
    protected $fillable = [
        'id_cabang',
        'dana_modal',
        'dana_idle',
        'plafon_akumulasi',
        'baki_debet',
    ];

    public function cabang() {
        return $this->belongsTo(Cabang::class,'id_cabang','id');
    }

    public function loan() {
        return $this->hasMany(MasterDDLoan::class,'id_cabang','id_cabang');
    }
}


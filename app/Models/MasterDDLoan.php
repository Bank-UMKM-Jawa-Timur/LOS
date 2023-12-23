<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterDDLoan extends Model
{
    use HasFactory;
    protected $table = 'dd_loan';
    protected $fillable = [
        'no_loan',
        'id_cabang',
        'kode_pendaftaran',
        'plafon',
        'jangka_waktu',
        'baki_debet',
    ];

    public function angsuran() {
        return $this->belongsTo(MasterDDAngsuran::class,'id_dd_loan');
    }
}

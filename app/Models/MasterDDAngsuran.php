<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterDDAngsuran extends Model
{
    use HasFactory;
    protected $table = 'dd_angsuran';
    protected $fillable = [
        'squence',
        'id_dd_loan',
        'tanggal_angsuran',
        'pokok_angsuran',
        'kolek',
        'keterangan',
    ];
}

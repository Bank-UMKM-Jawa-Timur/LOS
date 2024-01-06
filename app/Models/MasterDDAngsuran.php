<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterDDAngsuran extends Model
{
    use HasFactory;
    protected $table = 'dd_pembayaran';
    protected $fillable = [
        'squence',
        'no_loan',
        'tanggal_pembayaran',
        'pokok_pembayaran',
        'kolek',
        'keterangan',
    ];
}

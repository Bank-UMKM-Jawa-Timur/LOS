<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterDana extends Model
{
    use HasFactory;
    protected $table = 'master_dd';
    protected $fillable = [
        'dana_modal',
        'dana_idle',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalonNasabah extends Model
{
    use HasFactory;
    protected $table = 'calon_nasabah';

    public function users()
    {
        return $this->belongsTo('\App\Models\Users', 'id');
    }
}

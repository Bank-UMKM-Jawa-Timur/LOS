<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kabupaten extends Model
{
    use HasFactory;
    protected $table = 'kabupaten';

    public function kecamatan()
    {
        return $this->hasMany('\App\Models\Kecamatan', 'id_kabupaten');
    }
    
    public function desa()
    {
        return $this->hasMany('\App\Models\Kabupaten', 'id_desa');
    }

    public function cabang()
    {
        return $this->belongsTo('\App\Models\Cabang', 'id_kabupaten');
    }

}

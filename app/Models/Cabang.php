<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cabang extends Model
{
    use HasFactory;
    protected $table = 'cabang';

    public function kabupaten()
    {
        return $this->hasMany('\App\Models\Kabupaten', 'id_kabupaten');
    }

}

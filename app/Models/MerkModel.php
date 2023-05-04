<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MerkModel extends Model
{
    use HasFactory;
    protected $table = 'mst_merk';

    public function tipe()
    {
        return $this->hasMany('\App\Models\TipeModel', 'id_merk');
    }
}

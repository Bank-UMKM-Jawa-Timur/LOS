<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailKomentarModel extends Model
{
    use HasFactory;
    protected $table = "detail_komentar";

    protected $fillable = ['id', 'id_komentar', 'id_user', 'id_item', 'komentar', 'created_at', 'updated_at'];
}

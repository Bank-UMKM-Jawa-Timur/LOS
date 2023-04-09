<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JawabanTempModel extends Model
{
    use HasFactory;

    protected $table = 'jawaban_temp';

    protected $fillable = [
        'id_jawaban',
        'skor',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemModel extends Model
{
    use HasFactory;
    protected $table = 'item';

    protected function getIsCommentableAttribute($value)
    {
        return $value == 1 ? 'Ya' : 'Tidak';
    }
}

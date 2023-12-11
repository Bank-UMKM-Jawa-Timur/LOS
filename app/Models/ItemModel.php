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

    public function option()
    {
        return $this->hasMany('\App\Models\OptionModel', 'id_item');
    }

    public function detailPendapatPerAspek()
    {
        return $this->hasMany('\App\Models\DetailPendapatPerAspek', 'id_aspek');
    }

    public function childs() {
        return $this->hasMany(ItemModel::class, 'id_parent', 'id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionModel extends Model
{
    use HasFactory;
    protected $table = 'option';

    public function detailOptionItem()
    {
        return $this->hasMany('App\Models\ItemModel');
    }

    public function item()
    {
        return $this->belongsTo('App\Models\ItemModel', 'id_item');
    }

}

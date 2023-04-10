<?php

use App\Models\JawabanTemp;
use App\Models\JawabanTempModel;

if(!function_exists('temporary')) {
    function temporary(int $id, bool $multiple = false) {
        $temp = JawabanTemp::where('id_jawaban', $id);

        if($multiple) return $temp->get();
        return $temp->first();
    }
}

if(!function_exists('temporary_select')){
    function temporary_select(int $id){
        $temp = JawabanTempModel::where('id_jawaban', $id);

        return $temp->first();
    }
}

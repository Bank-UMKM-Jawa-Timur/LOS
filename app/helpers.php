<?php

use App\Models\JawabanTemp;
use App\Models\JawabanTempModel;

if(!function_exists('temporary')) {
    function temporary(int $nId, int $id, bool $multiple = false) {
        $temp = JawabanTemp::where('id_jawaban', $id)
            ->where('id_temporary_calon_nasabah', $nId)
            ->orderBy('id', 'desc');

        if($multiple) return $temp->get();
        return $temp->first();
    }
}

if(!function_exists('temporary_select')){
    function temporary_select(int $id){
        $temp = JawabanTempModel::where('id_option', $id)->orderBy('id', 'desc');

        return $temp->first();
    }
}

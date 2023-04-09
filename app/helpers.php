<?php

use App\Models\JawabanTemp;

if(!function_exists('temporary')) {
    function temporary(int $id, bool $multiple = false) {
        $temp = JawabanTemp::where('id_jawaban', $id);

        if($multiple) return $temp->get();
        return $temp->first();
    }
}

<?php

use App\Models\JawabanTemp;

if(!function_exists('temporary')) {
    function temporary(int $id) {
        return JawabanTemp::where('id_jawaban', $id)
            ->first();
    }
}

<?php

use App\Models\JawabanTemp;
use App\Models\JawabanTempModel;
use Illuminate\Support\Facades\DB;

if(!function_exists('temporary')) {
    function temporary($nId, $id, bool $multiple = false) {
        $temp = JawabanTemp::where('id_jawaban', $id)
            ->where('id_temporary_calon_nasabah', $nId)
            ->orderBy('id', 'desc');

        if($multiple) return $temp->get();
        return $temp->first();
    }
}

if(!function_exists('temporary_select')){
    function temporary_select(int $id, int $nId){
        $temp = JawabanTempModel::where('id_option', $id)
            ->where('id_temporary_calon_nasabah', $nId)
            ->orderBy('id', 'desc');

        return $temp->first();
    }
}

if(!function_exists('temporary_usulan')){
    function temporary_usulan(int $id, int $nId){
        $temp = DB::table('temporary_usulan_dan_pendapat')
            ->where('id_temp', $nId)
            ->where('id_aspek', $id)
            ->orderBy('id', 'desc');

        return $temp->first();
    }
}

if(!function_exists('temporary_perhitungan')){
    function temporary_perhitungan(int $nId, int $id){
        $temp = DB::table('perhitungan_kredit')
            ->where('temp_calon_nasabah_id', $nId)
            ->where('item_perhitungan_kredit_id', $id)
            ->orderByDesc('id');

        if($temp->first()?->nominal){
            return number_format($temp->first()?->nominal, 0, '.', '.');
        } else if($temp->first()?->array_value){
            return $temp->first()->array_value;
        }
        return 0;
    }
}
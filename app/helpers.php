<?php

use App\Models\JawabanTemp;
use App\Models\JawabanTempModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

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

if (!function_exists('sipde_token')) {
    function sipde_token() {
        $filePath = storage_path('app/response.json');
        $json = json_decode(file_get_contents($filePath), true);
        $date = Carbon::now()->toDateTimeString();
        if ($date >= $json['exp']) {
                return ['token' => null];
            }else{
                return [
                    'token' => $json['token'],
                ];
        }
    }
}

if (!function_exists('jenis_usaha_dagulir')) {
    function jenis_usaha_dagulir() {
        $data = sipde_token();
        return $data['token'];

    }
}

if (!function_exists('list_status')) {
    function list_status() {
        $data = sipde_token();
        if ($data['token'] != null) {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' .$data['token'],
            ])
            ->post(env('SIPDE_HOST').'/list_status.json');
            return json_encode($response);
        }else{
            return 'Silahkan login kembali';
        }
    }
}

if (!function_exists('update_status')) {
    function update_status($kode, $status, $lampiran, $jangka_waktu, $realisasi_waktu ) {
        $data = sipde_token();
        if ($data['token'] != null) {
            Http::withHeaders([
                'Authorization' => 'Bearer ' .$data['token'],
            ])->post(env('SIPDE_HOST'),[
                "kode_pendaftaran" => $kode,
                "status" => $status,
                "lampiran_analisa" => $lampiran,
                "jangka_waktu" => $jangka_waktu,
                "realisasi_dana" => $realisasi_waktu,
            ]);
        }else{
            return 'Silahkan login kembali';
        }
    }
}

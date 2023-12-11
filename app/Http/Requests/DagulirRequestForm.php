<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DagulirRequestForm extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nama' => 'required',
            'nik' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'telp' => 'required',
            'jenis_usaha' => 'required',
            'nominal_pengajuan' => 'required',
            'tujuan_penggunaan' => 'required',
            'jangka_waktu' => 'required',
            'ket_agunan' => 'required',
            'kode_bank_pusat' => 'required',
            'kode_bank_cabang' => 'required',
            'kecamatan_sesuai_ktp' => 'required',
            'kode_kotakab_ktp' => 'required',
            'alamat_sesuai_ktp' => 'required',
            'kecamatan_domisili' => 'required',
            'kode_kotakab_domisili' => 'required',
            'alamat_domisili' => 'required',
            'kecamatan_usaha' => 'required',
            'kode_kotakab_usaha' => 'required',
            'alamat_usaha' => 'required',
            'tipe_pengajuan' => 'required',
            'npwp' => 'required',
            'jenis_badan_hukum' => 'required',
            'tempat_berdiri' => 'required',
            'tanggal_berdiri' => 'required',
            'email' => 'required',
        ];
    }
}

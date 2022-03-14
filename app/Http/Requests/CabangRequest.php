<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CabangRequest extends FormRequest
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
            'kode_cabang' => 'required|unique:cabang',
            'cabang' => 'required|max:191',
            'alamat' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'kode_cabang.required' => 'Kode Cabang harus terisi',
            'cabang.required' => 'Cabang harus diisi.',
            'cabang.max' => 'Maksimal jumlah karakter 191.',
            'alamat.required' => 'Alamat harus diisi.',
            'kode_cabang.unique' => 'Kode Cabang sudah dipakai.'
        ];
    }
}

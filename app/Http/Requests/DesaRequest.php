<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DesaRequest extends FormRequest
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
            'desa' => 'required|max:191',
            'id_kabupaten' => 'required',
            'id_kecamatan' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'desa.required' => 'Desa harus diisi.',
            'desa.max' => 'Maksimal jumlah karakter 191.',
            'id_kabupaten.required' => 'Kabupaten harus diisi.',
            'id_kecamatan.required' => 'Kecamatan harus diisi.'
        ];
    }
}

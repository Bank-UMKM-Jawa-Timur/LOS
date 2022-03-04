<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KecamatanRequest extends FormRequest
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
            'kecamatan' => 'required|max:191',
            'id_kabupaten' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'kecamatan.required' => 'Kecamatan harus diisi.',
            'kecamatan.max' => 'Maksimal jumlah karakter 191.',
            'id_kabupaten.required' => 'Kabupaten harus diisi.'
        ];
    }
}

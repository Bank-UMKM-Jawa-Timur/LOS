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
            'cabang' => 'required|max:191',
            'alamat' => 'required',
            'id_kabupaten' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'cabang.required' => 'Cabang harus diisi.',
            'cabang.max' => 'Maksimal jumlah karakter 191.',
            'alamat.required' => 'Alamat harus diisi.',
            'id_kabupaten.required' => 'Kabupaten harus diisi.',
        ];
    }
}

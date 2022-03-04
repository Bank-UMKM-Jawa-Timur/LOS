<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KabupatenRequest extends FormRequest
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
            'kabupaten' => 'required|max:191',
        ];
    }

    public function messages()
    {
        return [
            'kabupaten.required' => 'Kabupaten harus diisi.',
            'kabupaten.max' => 'Maksimal jumlah karakter 191.'
        ];
    }
}

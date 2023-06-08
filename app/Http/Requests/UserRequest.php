<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'nip' => 'sometimes|nullable|unique:users',
            'name' => 'required',
            'email' => 'required',
            'role' => 'required',
            'id_cabang' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'nip.unique' => 'NIP telah digunakan.',
            'name.required' => 'Name harus diisi.',
            'email.required' => 'Email harus diisi.',
            'role.required' => 'Role harus diisi.',
            'id_cabang.required' => 'Kantor Cabang harus diisi.',
        ];
    }
}

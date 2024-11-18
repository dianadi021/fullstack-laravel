<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'company_profile' => ['nullable', 'longtext'],
            'id_provinsi' => ['required', 'integer', 'exists:provinsi,id'],
            'id_kabupaten' => ['required', 'integer', 'exists:kabupaten,id'],
            'id_kecamatan' => ['required', 'integer', 'exists:kecamatan,id'],
            'id_kelurahan' => ['required', 'integer', 'exists:kelurahan,id'],
            'address' => ['nullable', 'string', 'max:255'],
            // 'id_tier_level' => ['required', 'integer', 'exists:tier_level,id'],
            'is_actived' => ['required', 'boolean'],
        ];
    }


    public function messages(): array
    {
        return [
            'id_provinsi.exists' => 'Provinsi tidak ditemukan.',
            'id_kabupaten.exists' => 'Kabupaten tidak ditemukan.',
            'id_kecamatan.exists' => 'Kecamatan tidak ditemukan.',
            'id_kelurahan.exists' => 'Kelurahan tidak ditemukan.',
        ];
    }

    public function attributes(): array
    {
        return [
            'id_provinsi' => 'provinsi',
            'id_kabupaten' => 'kabupaten',
            'id_kecamatan' => 'kecamatan',
            'id_kelurahan' => 'kelurahan',
        ];
    }
}

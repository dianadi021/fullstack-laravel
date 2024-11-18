<?php

namespace App\Http\Requests\Api;

use Illuminate\Validation\Rules;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // Inert List_Clients
            'id_provinsi' => ['required', 'integer', 'exists:provinsi,id'],
            'id_kabupaten' => ['required', 'integer', 'exists:kabupaten,id'],
            'id_kecamatan' => ['required', 'integer', 'exists:kecamatan,id'],
            'id_kelurahan' => ['required', 'integer', 'exists:kelurahan,id'],

            // Insert Users
            'username' => ['required', 'string', 'max:255', 'unique:users,username', 'regex:/^[a-zA-Z0-9_]+$/'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],

            // Insert Penduduk
            'nik' => ['required', 'string', 'unique:penduduk,nik'],
            'fullname' => ['required', 'string'],
            'handphone' => ['nullable', 'string'],
            'whatsapp' => ['nullable', 'string'],
            'telegram' => ['nullable', 'string'],
            'birthdate' => ['nullable', 'date'],
            'address' => ['nullable', 'string'],
            'id_gender' => ['required', 'integer', 'exists:gender,id'],
            'id_golongan_darah' => ['required', 'integer', 'exists:golongan_darah,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'id_provinsi.exists' => 'Provinsi tidak ditemukan.',
            'id_kabupaten.exists' => 'Kabupaten tidak ditemukan.',
            'id_kecamatan.exists' => 'Kecamatan tidak ditemukan.',
            'id_kelurahan.exists' => 'Kelurahan tidak ditemukan.',

            'nik.unique' => 'NIK sudah terdaftar.',
            'email.unique' => 'Email sudah terdaftar.',
            'username.unique' => 'Username sudah terdaftar.',
            'username.regex' => 'Username hanya boleh berisi huruf, angka, dan underscore.',
            'birthdate.date' => 'Tanggal lahir harus berupa format tanggal yang valid.',
        ];
    }
}

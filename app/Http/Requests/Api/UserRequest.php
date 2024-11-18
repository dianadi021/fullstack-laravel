<?php

namespace App\Http\Requests\Api;

use Illuminate\Validation\Rule;
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
            // Insert into list_client table
            'klinik_name' => ['string', 'max:255', 'regex:/^[a-zA-Z0-9_]+$/'],

            // Insert into users table
            'username' => ['required', 'string', 'max:255', 'unique:users,username', 'regex:/^[a-zA-Z0-9_]+$/'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'id_client' => ['nullable', 'integer', 'exists:list_client,id'],
            'id_penduduk' => ['nullable', 'integer', 'exists:penduduk,id'],

            // Insert into penduduk table
            'nik_user' => ['nullable', 'string', 'max:255', 'regex:/^[0-9]+$/'],
            'fullname_user' => ['required', 'string', 'max:255'],
            'handphone_user' => ['nullable', 'string'],
            'whatsapp_user' => ['nullable', 'string'],
            'telegram_user' => ['nullable', 'string'],
            'agama_user' => ['nullable', 'string'],
            'tempat_lahir_user' => ['nullable', 'string'],
            'birthdate_user' => ['nullable', 'date'],
            'gender_user' => ['required', 'string', Rule::in(['Tidak Diketahui', 'Laki-Laki', 'Perempuan', 'Tidak Dapat Ditentukan', 'Tidak Mengisi'])],
            'goldar_user'=> ['nullable', 'string', 'exists:goldar,name'],
            'id_provinsi' => ['required', 'integer', 'exists:provinsi,id'],
            'id_provinsi' => ['required', 'integer', 'exists:provinsi,id'],
            'id_kabupaten' => ['required', 'integer', 'exists:kabupaten,id'],
            'id_kecamatan' => ['required', 'integer', 'exists:kecamatan,id'],
            'id_kelurahan' => ['required', 'integer', 'exists:kelurahan,id'],
            'address' => ['nullable', 'string', 'max:255'],
        ];
    }


    public function messages(): array
    {
        return [
            'id_provinsi.exists' => 'Provinsi tidak ditemukan.',
            'id_kabupaten.exists' => 'Kabupaten tidak ditemukan.',
            'id_kecamatan.exists' => 'Kecamatan tidak ditemukan.',
            'id_kelurahan.exists' => 'Kelurahan tidak ditemukan.',

            'password' => 'Password harus lebih dari 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak sesuai.',
            'email.email' => 'Email tidak valid.',
            'gender.exists' => 'Gender tidak ditemukan.',

            'nik_user.unique' => 'NIK sudah terdaftar.',
            'nik.regex' => 'Username hanya boleh berisi angka.',
            'email.unique' => 'Email sudah terdaftar.',
            'username.unique' => 'Username sudah terdaftar.',
            'username.regex' => 'Username hanya boleh berisi huruf, angka, dan underscore.',
            'birthdate.date' => 'Tanggal lahir harus berupa format tanggal yang valid.',
        ];
    }

    public function attributes(): array
    {
        return [
            'id_provinsi' => 'provinsi',
            'id_kabupaten' => 'kabupaten',
            'id_kecamatan' => 'kecamatan',
            'id_kelurahan' => 'kelurahan',
            'fullname' => 'nama lengkap',
            'handphone' => 'nomor handphone',
            'birthdate' => 'tanggal lahir',
        ];
    }
}

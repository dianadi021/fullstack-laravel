<?php

namespace App\Models;

use App\Traits\Tools;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Penduduk extends Model
{
    protected $table = 'penduduk';
    use Notifiable, HasFactory, Tools;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'fullname',
        'nik',
        'nomor_identitas_lain',
        'nama_ibu',
        'nik_ibu',
        'tempat_lahir',
        'birthdate',
        'agama',
        'ras_suku',
        'goldar',
        'alamat_domisili',
        'alamat_ktp',
        'dinamis_penduduk',
        'pendidikan',
        'pekerjaan',
        'status_pernikahan',
        'gender',
        'perkiraan_umur',
        'lokasi_ditemukan',
        'tanggal_ditemukan',
        'id_provinsi',
        'id_provinsi',
        'id_kabupaten',
        'id_kabupaten',
        'id_kecamatan',
        'id_kecamatan',
        'id_kelurahan',
        'id_kelurahan',
        'id_user_created',
        'id_user_updated',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function SchemaDataModel(object $req)
    {
        setlocale(LC_TIME, 'id_ID.utf8');
        $dateNow = now(env('APP_TIMEZONE', 'Asia/Jakarta'));
        $userSession = session('user_login');

        $date = $this->ReformatDateTime($dateNow, true);
        $id_user = $this->GetUserIDFromRequest($req, $userSession);
        $nik = ($this->isValidVal($req->nik_user) ? $req->nik_user : $req->nik_pasien);
        $gender = ($this->isValidVal($req->gender_user) ? $req->gender_user : $req->gender);
        $goldar = ($this->isValidVal($req->goldar_user) ? $req->goldar_user : $req->goldar);
        $alamat_ktp = ($this->isValidVal($req->address_user) ? $req->address_user : $req->address_pasien);
        $fullname = ($this->isValidVal($req->fullname_user) ? $req->fullname_user : $req->nama_pasien);
        $tanggal_lahir = ($this->isValidVal($req->tanggal_lahir_pasien) ? $req->tanggal_lahir_pasien : $req->tanggal_lahir);

        return [
            'fullname' => $fullname,
            'nik' => $nik,
            'nomor_identitas_lain' => $req->nomor_identitas_lain,
            'nama_ibu' => $req->nama_ibu,
            'nik_ibu' => $req->nik_ibu,
            'tempat_lahir' => $req->tempat_lahir,
            'birthdate' => $tanggal_lahir,
            'agama' => $req->agama,
            'ras_suku' => $req->ras_suku,
            'goldar' => $goldar,
            'alamat_domisili' => $req->alamat_domisili,
            'alamat_ktp' => $alamat_ktp,
            'dinamis_penduduk' => $req->dinamis_penduduk,
            'pendidikan' => $req->pendidikan,
            'pekerjaan' => $req->pekerjaan,
            'status_pernikahan' => $req->status_pernikahan,
            'gender' => $gender,
            'perkiraan_umur' => $req->perkiraan_umur,
            'lokasi_ditemukan' => $req->lokasi_ditemukan,
            'tanggal_ditemukan' => $req->tanggal_ditemukan,
            'id_provinsi' => $req->id_provinsi,
            'id_kabupaten' => $req->id_kabupaten,
            'id_kecamatan' => $req->id_kecamatan,
            'id_kelurahan' => $req->id_kelurahan,
            'id_user_created' => $id_user,
            'id_user_updated' => $id_user,
            'created_at' => $date,
            'updated_at' => $date,
            'deleted_at' => $date,
        ];
    }
}

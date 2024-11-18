<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Penduduk extends Model
{
    protected $table = 'penduduk';
    use Notifiable, SoftDeletes, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nik',
        'fullname',
        'handphone',
        'whatsapp',
        'telegram',
        'birthdate',
        'id_gender',
        'id_golongan_darah',
        'id_provinsi',
        'id_kabupaten',
        'id_kecamatan',
        'id_kelurahan',
        'address',
        'is_deleted',
        'created_at',
        'updated_at',
    ];
}

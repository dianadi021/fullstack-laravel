<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kunjungan extends Model
{
    protected $table = 'kunjungan';
    use Notifiable, SoftDeletes, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'status',
        'id_pendaftaran',
        'id_nakes',
        'id_bed',
        'waktu_masuk',
        'waktu_keluar',
        'id_client',
        'id_pasien',
        'is_deleted',
        'created_at',
        'updated_at',
        'id_user_created',
        'id_user_updated',
    ];
}

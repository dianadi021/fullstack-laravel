<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pendaftaran extends Model
{
    protected $table = 'pendaftaran';
    use Notifiable, SoftDeletes, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_pasien',
        'id_client',
        'is_lunas',
        'jenis_pasien',
        'status_pendaftaran',
        'is_deleted',
        'created_at',
        'updated_at',
        'id_user_created',
        'id_user_updated',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pasien extends Model
{
    protected $table = 'pasien';
    use Notifiable, SoftDeletes, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_penduduk',
        'id_client',
        'is_deleted',
        'created_at',
        'updated_at',
        'id_user_created',
        'id_user_updated',
    ];
}

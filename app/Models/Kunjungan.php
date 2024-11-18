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
        'status_kunjungan',
        'id_pendaftaran',
        'id_nakes',
        'id_bed',
        'waktu_masuk',
        'waktu_keluar',
        'id_client',
        'id_pasien',
        'is_deleted',
        'id_user_created',
        'id_user_updated',
        'expired_date',
        'is_actived',
        'is_deleted',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function SchemaDataModel(object $req) {
        return [
            'id_pendaftaran' => $req->id_pendaftaran,
            // 'id_nakes' => (isset($req->id_nakes) && !empty($req->id_nakes) ? $req->id_nakes : null),
            // 'id_bed' => (isset($req->id_bed) && !empty($req->id_bed) ? $req->id_bed : null),
            'status_kunjungan' => 'Masuk',
            'waktu_masuk' => $req->dateNow,
            'id_pasien' => $req->id_pasien,
            'id_client' => $req->id_client,
            'id_user_created' => $req->id_user,
            'id_user_updated' => $req->id_user,
            'created_at' => $req->dateNow,
            'updated_at' => $req->dateNow,
        ];
    }
}

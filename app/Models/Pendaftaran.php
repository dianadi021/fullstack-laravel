<?php

namespace App\Models;

use App\Traits\Tools;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pendaftaran extends Model
{
    protected $table = 'pendaftaran';
    use Notifiable, HasFactory, Tools;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_pasien',
        'id_client',
        'norm_ibu',
        'nomor_asuransi',
        'cara_pembayaran',
        'is_bayi',
        'is_lunas',
        'jenis_pasien',
        'status_pendaftaran',
        'keluarga',
        'penanggung_jawab',
        'id_user_created',
        'id_user_updated',
        'is_deleted',
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
        $id_client = $this->GetClientIDFromRequest($req, $userSession);

        return [
            'id_pasien' => $req->id_pasien,
            'id_client' => $id_client,
            'norm_ibu',
            'nomor_asuransi',
            'cara_pembayaran',
            'is_bayi',
            'is_lunas',
            'jenis_pasien',
            'status_pendaftaran',
            'keluarga',
            'penanggung_jawab',
            'id_user_created' => $id_user,
            'id_user_updated' => $id_user,
            'created_at' => $date,
            'updated_at' => $date,
            'deleted_at' => $date,
        ];
    }
}

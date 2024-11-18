<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Traits\Tools;

class Pegawai extends Model
{
    protected $table = 'pegawai';
    use Notifiable, SoftDeletes, HasFactory, Tools;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_user',
        'id_profesi',
        'id_penduduk',
        'id_client',
        'id_user_created',
        'id_user_updated',
        'is_actived',
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

        $isActived = ($this->isValidVal($req->is_actived) ? $req->is_actived : true);
        $isDeleted = ($this->isValidVal($req->is_deleted) ? $req->is_deleted : false);

        return [
            'id_user' => $id_user,
            'id_profesi' => $req->id_profesi,
            'id_penduduk' => $req->id_penduduk,
            'id_client' => $id_client,
            'id_user_created' => $id_user,
            'id_user_updated' => $id_user,
            'is_actived' => $isActived,
            'is_deleted' => $isDeleted,
            'created_at' => $date,
            'updated_at' => $date,
            'deleted_at' => $date,
        ];
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Traits\Tools;

class ListClient extends Model
{
    protected $table = 'list_client';
    use Notifiable, SoftDeletes, HasFactory, Tools;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'company_profile',
        'id_provinsi',
        'id_kabupaten',
        'id_kecamatan',
        'id_kelurahan',
        'address',
        'id_tier_level',
        'id_user_created',
        'id_user_updated',
        'expired_date',
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
        $id_tier_level = ($this->isValidVal($req->id_tier_level) ? $req->id_tier_level : 1);

        $day = 30;
        $days = ($this->isValidVal($req->actived_lifetime) ? $req->actived_lifetime * $day : $day);
        $expired_date = (clone $dateNow)->addDays($days)->toDateTimeString();

        $name = ($this->isValidVal($req->name) ? $req->name : $req->klinik_name);
        $isActived = ($this->isValidVal($req->is_actived) ? $req->is_actived : true);
        $isDeleted = ($this->isValidVal($req->is_deleted) ? $req->is_deleted : false);

        return [
            'name' => $name,
            'company_profile' => $req->company_profile,
            'id_provinsi' => $req->id_provinsi,
            'id_kabupaten' => $req->id_kabupaten,
            'id_kecamatan' => $req->id_kecamatan,
            'id_kelurahan' => $req->id_kelurahan,
            'address' => $req->address,
            'id_tier_level' => $id_tier_level,
            'id_user_created' => $id_user,
            'id_user_updated' => $id_user,
            'expired_date' => $expired_date,
            'is_actived' => $isActived,
            'is_deleted' => $isDeleted,
            'created_at' => $date,
            'updated_at' => $date,
            'deleted_at' => $date,
        ];
    }
}

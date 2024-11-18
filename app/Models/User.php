<?php

namespace App\Models;

use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

use App\Traits\Tools;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes, HasFactory, Tools;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'id_role',
        'id_client',
        'id_penduduk',
        'email_verified_at',
        'ip_address',
        'last_login',
        'id_user_created',
        'id_user_updated',
        'is_actived',
        'is_deleted',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function SchemaDataModel(object $req)
    {
        setlocale(LC_TIME, 'id_ID.utf8');
        $dateNow = now(env('APP_TIMEZONE', 'Asia/Jakarta'));
        $userSession = session('user_login');

        $date = $this->ReformatDateTime($dateNow, true);
        $id_user = $this->GetUserIDFromRequest($req, $userSession);
        $id_client = $this->GetClientIDFromRequest($req, $userSession);
        $id_role = ($this->isValidVal($req->id_role) ? $req->id_role : 1);

        $isActived = ($this->isValidVal($req->is_actived) ? $req->is_actived : true);
        $isDeleted = ($this->isValidVal($req->is_deleted) ? $req->is_deleted : false);

        return [
            'username' => $req->username,
            'email' => $req->email,
            'password' => Hash::make($req->password),
            'id_role' => $id_role,
            'id_client' => $id_client,
            'id_penduduk' => $req->id_penduduk,
            'email_verified_at' => $req->email_verified_at,
            'ip_address' => $req->ip_address,
            'last_login' => $req->last_login,
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

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GolonganDarah extends Model
{
    use Notifiable, SoftDeletes, HasFactory;

    // Nama tabel di database
    protected $table = 'golongan_darah';

    // Kolom-kolom yang boleh diisi secara mass-assignment
    protected $fillable = ['name', 'is_deleted'];

    // Aktifkan timestamps untuk kolom created_at dan updated_at
    public $timestamps = true;

    // Konfigurasi soft delete untuk kolom deleted_at
    protected $dates = ['deleted_at'];
}

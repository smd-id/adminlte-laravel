<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Models\District;
use Laravolt\Indonesia\Models\Province;
use Laravolt\Indonesia\Models\Village;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Sanctum\HasApiTokens;
use Modules\User\Database\factories\UserFactory;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'nik',
        'name',
        'tempat_lahir',
        'tanggal_lahir',
        'gender',
        'alamat',
        'province_id',
        'city_id',
        'district_id',
        'village_id',
        'agama',
        'perkawinan',
        'pekerjaan',
        'negara',
        'foto',
        'phone',
        'email',
        'username',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function adminlte_image()
    {
        return asset('vendor/adminlte/dist/img/user.png');
    }
    public function adminlte_profile_url()
    {
        return route('profil');
    }
    public function desa()
    {
        return $this->belongsTo(Village::class, 'village_id', 'code');
    }
    public function kecamatan()
    {
        return $this->belongsTo(District::class, 'district_id', 'code');
    }
    public function kabupaten()
    {
        return $this->belongsTo(City::class, 'city_id', 'code');
    }
    public function provinsi()
    {
        return $this->belongsTo(Province::class, 'province_id', 'code');
    }

    protected static function newFactory()
    {
        return UserFactory::new();
    }
}

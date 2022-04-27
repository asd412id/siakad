<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'username',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public $appends = ['updated'];

    public function dosen()
    {
        return $this->hasOne(Dosen::class);
    }
    public function mahasiswa()
    {
        return $this->hasOne(Mahasiswa::class);
    }
    public function prodi()
    {
        return $this->belongsTo(Prodi::class);
    }
    public function getIsAdminAttribute()
    {
        return $this->role == 0;
    }
    public function getIsDosenAttribute()
    {
        return $this->role == 1;
    }
    public function getIsMahasiswaAttribute()
    {
        return $this->role == 2;
    }
    public function getIsOperatorAttribute()
    {
        return $this->role == 3;
    }
    public function getUpdatedAttribute()
    {
        return $this->updated_at->format('d/m/Y H:i');
    }
}

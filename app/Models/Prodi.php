<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prodi extends Model
{
    use HasFactory;

    public $casts = [
        'opt' => 'array'
    ];

    protected $appends = ['kaprodi'];

    public function dosen()
    {
        return $this->hasMany(Dosen::class);
    }
    public function mahasiswa()
    {
        return $this->hasMany(Mahasiswa::class);
    }
    public function matakuliah()
    {
        return $this->hasMany(MataKuliah::class);
    }
    public function getKaprodiAttribute()
    {
        return '<p class="m-0 p-0 font-weight-bold text-sm">' . (isset($this->opt['kaprodi_name']) ? $this->opt['kaprodi_name'] : '-') . '</p><em class="text-sm" style="margin-top: -5px !important;display: block">NIP. ' . (isset($this->opt['kaprodi_nip']) ? $this->opt['kaprodi_nip'] : '-') . '</em>';
    }
}

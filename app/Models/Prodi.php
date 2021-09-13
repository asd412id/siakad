<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prodi extends Model
{
    use HasFactory;

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
}

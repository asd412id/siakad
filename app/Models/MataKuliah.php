<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataKuliah extends Model
{
    use HasFactory;

    public function prodi()
    {
        return $this->belongsTo(Prodi::class)->withDefault([
            'name' => '-'
        ]);
    }

    public function krs()
    {
        return $this->hasMany(Krs::class);
    }
    public function nilai()
    {
        return $this->hasMany(Nilai::class);
    }
    public function dosen()
    {
        return $this->belongsToMany(Dosen::class, 'dosen_makul');
    }

    public static function boot()
    {
        parent::boot();
        static::deleting(function ($row) {
            $row->krs()->delete();
            $row->nilai()->delete();
            $row->dosen()->detach();
        });
    }
}

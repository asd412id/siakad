<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;
    public $dates = ['tgl_lahir'];
    protected $dateformat = "d-m-Y";

    public function user()
    {
        return $this->belongsTo(User::class);
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
        return $this->belongsTo(Dosen::class)->withDefault([
            'user' => ['name' => '-']
        ]);
    }
    public function prodi()
    {
        return $this->belongsTo(Prodi::class)->withDefault([
            'name' => '-'
        ]);
    }
    public function setStatusAttribute($value)
    {
        if ($value) {
            $this->attributes['status'] = strtolower($value);
        }
    }
    public function setTglLahirAttribute($value)
    {
        if ($value) {
            $this->attributes['tgl_lahir'] = Carbon::createFromFormat($this->dateformat, $value)->toDateString();
        }
    }
    public function getTglLahirTextAttribute()
    {
        return $this->tgl_lahir ? $this->tgl_lahir->format($this->dateformat) : null;
    }
    public function getStatusAttribute($value)
    {
        return ucwords($value);
    }
    public function getJenisKelaminTextAttribute()
    {
        return $this->jenis_kelamin == 'L' ? 'Laki - Laki' : 'Perempuan';
    }

    public static function boot()
    {
        parent::boot();
        static::deleting(function ($row) {
            $row->user()->delete();
            $row->krs()->delete();
            $row->nilai()->delete();
        });
    }
}

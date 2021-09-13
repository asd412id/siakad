<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    use HasFactory;
    public $dates = ['tgl_lahir'];
    protected $dateformat = "d-m-Y";

    public function user()
    {
        return $this->belongsTo(User::class);
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
    public function mata_kuliah()
    {
        return $this->belongsToMany(MataKuliah::class, 'dosen_makul');
    }

    public static function boot()
    {
        parent::boot();
        static::deleting(function ($row) {
            $row->mata_kuliah()->detach();
            $row->user()->delete();
        });
    }
}

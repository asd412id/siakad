<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Krs extends Model
{
    use HasFactory;
    protected $table = 'krs';
    public $timestamps = false;

    public function mata_kuliah()
    {
        return $this->belongsTo(MataKuliah::class);
    }
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }
    public function nilai()
    {
        return $this->hasOne(Nilai::class, 'mahasiswa_id', 'mahasiswa_id')
            ->where('semester', $this->semester)
            ->where('mata_kuliah_id', $this->mata_kuliah_id);
    }
}

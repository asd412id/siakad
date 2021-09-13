@extends('layouts.master')
@section('content')
<div class="row">
  @if (auth()->user()->is_admin)
  <div class="col-lg-3 col-6">
    <div class="small-box bg-primary">
      <div class="inner">
        <h3>{{ App\Models\Prodi::count() }}</h3>

        <p>Program Studi</p>
      </div>
      <div class="icon">
        <i class="fas fa-building"></i>
      </div>
      <a href="{{ route('prodi.index') }}" class="small-box-footer">
        Lihat <i class="fas fa-arrow-circle-right"></i>
      </a>
    </div>
  </div>
  <div class="col-lg-3 col-6">
    <div class="small-box bg-success">
      <div class="inner">
        <h3>{{ App\Models\MataKuliah::count() }}</h3>

        <p>Mata Kuliah</p>
      </div>
      <div class="icon">
        <i class="fas fa-book"></i>
      </div>
      <a href="{{ route('matakuliah.index') }}" class="small-box-footer">
        Lihat <i class="fas fa-arrow-circle-right"></i>
      </a>
    </div>
  </div>
  <div class="col-lg-3 col-6">
    <div class="small-box bg-warning">
      <div class="inner">
        <h3>{{ App\Models\Dosen::count() }}</h3>

        <p>Dosen</p>
      </div>
      <div class="icon">
        <i class="fas fa-user-graduate"></i>
      </div>
      <a href="{{ route('dosen.index') }}" class="small-box-footer">
        Lihat <i class="fas fa-arrow-circle-right"></i>
      </a>
    </div>
  </div>
  <div class="col-lg-3 col-6">
    <div class="small-box bg-danger">
      <div class="inner">
        <h3>{{ App\Models\Mahasiswa::count() }}</h3>

        <p>Mahasiswa</p>
      </div>
      <div class="icon">
        <i class="fas fa-users"></i>
      </div>
      <a href="{{ route('mahasiswa.index') }}" class="small-box-footer">
        Lihat <i class="fas fa-arrow-circle-right"></i>
      </a>
    </div>
  </div>
  @elseif (auth()->user()->is_dosen)
  <div class="col-lg-3 col-6">
    <div class="small-box bg-primary">
      <div class="inner">
        <h3>{{ App\Models\Mahasiswa::where('dosen_id',auth()->user()->dosen->id)->count() }}</h3>

        <p>Mahasiswa Bimbingan</p>
      </div>
      <div class="icon">
        <i class="fas fa-users"></i>
      </div>
    </div>
  </div>
  @elseif (auth()->user()->is_mahasiswa)
  <div class="col-lg-3 col-12">
    <div class="small-box bg-danger">
      <div class="inner">
        @php($sks = auth()->user()->mahasiswa->krs()->select('sks')->get()->pluck('sks')->toArray())
        <h3>{{ array_sum($sks) }}</h3>
        <p>SKS Diprogram</p>
      </div>
      <div class="icon">
        <i class="fas fa-book"></i>
      </div>
      <a href="{{ route('study.index') }}" class="small-box-footer">
        Lihat <i class="fas fa-arrow-circle-right"></i>
      </a>
    </div>
  </div>
  <div class="col-lg-6 col-12">
    <div class="small-box bg-primary">
      <div class="inner">
        <h4>{{ auth()->user()->mahasiswa->dosen->user->name??'Belum ditentukan' }}</h4>
        <p>Dosen Pembimbing</p>
      </div>
      <div class="icon">
        <i class="fas fa-user-graduate"></i>
      </div>
    </div>
  </div>
  @endif
</div>
@endsection
@extends('layouts.master')
@section('header')
<link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection
@section('content')
<div class="card">
  <div class="card-header">
    <form id="study-query" data-role="{{ auth()->user()->role!=0?'guest':'' }}" action="#"
      data-url="{{ route('study.query') }}" method="post" class="form-inline">
      @csrf
      @if (auth()->user()->role == 0)
      <div class="form-group m-1">
        <select name="prodi_id" class="form-control select2-ajax" data-placeholder="Pilih Program Studi"
          data-url="{{ route('prodi.search') }}">
          <option value="">Pilih Program Studi</option>
        </select>
      </div>
      <div class="form-group m-1">
        <select name="dosen_id" class="form-control select2-ajax" data-url="{{ route('dosen.search') }}"
          data-placeholder="Pilih Dosen Pembimbing">
          <option value="">Pilih Dosen Pembimbing</option>
        </select>
      </div>
      @endif
      <div class="form-group m-1">
        <button type="submit" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i> Tampilkan
          Data</button>
      </div>
    </form>
  </div>
  <div class="card-body">
    <h4 class="text-center">Klik tombol Tampilkan Data untuk
      menampilkan data studi mahasiswa</h4>
  </div>
</div>
@endsection
@section('footer')
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
<script>
</script>
@endsection
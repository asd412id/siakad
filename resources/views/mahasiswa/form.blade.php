<form action="#" class="modal-form" data-url="{{ $url }}" method="post">
  @csrf
  @if (@$data)
  @method('PUT')
  @else
  @method('POST')
  @endif
  <div class="container-fluid">
    <div class="form-group">
      <label for="inim">NIM / Username</label>
      <input type="text" name="nim" class="form-control" id="inim" placeholder="Masukkan NIM sebagai username dosen"
        value="{{ @$data->nim }}">
    </div>
    <div class="form-group">
      <label for="ipassword">Password</label>
      <input type="password" name="password" class="form-control" id="ipassword" placeholder="Masukkan password dosen">
    </div>
    <div class="form-group">
      <label for="iname">Nama</label>
      <input type="text" name="name" class="form-control" id="iname" placeholder="Masukkan nama dosen"
        value="{{ @$data->user->name }}" required>
    </div>
    <div class="form-group">
      <label for="itempat_lahir">Tempat Lahir</label>
      <input type="text" name="tempat_lahir" class="form-control" id="itempat_lahir" placeholder="Masukkan tempat lahir"
        value="{{ @$data->tempat_lahir }}">
    </div>
    <div class="form-group">
      <label for="itgl_lahir">Tanggal Lahir</label>
      <input type="text" name="tgl_lahir" class="form-control datepicker" id="itgl_lahir"
        placeholder="Masukkan tanggal lahir" value="{{ @$data->tgl_lahir_text }}" autocomplete="off">
    </div>
    <div class="form-group">
      <label for="ijenis_kelamin">Jenis Kelamin</label>
      <select name="jenis_kelamin" id="ijenis_kelamin" class="form-control select2">
        <option {{ @$data->jenis_kelamin=='L'?'selected':'' }} value="L">Laki - Laki</option>
        <option {{ @$data->jenis_kelamin=='P'?'selected':'' }} value="P">Perempuan</option>
      </select>
    </div>
    <div class="form-group">
      <label for="iprodi">Program Studi</label>
      <select name="prodi_id" data-placeholder="Pilih Program Studi" class="form-control select2-ajax"
        data-url="{{ route('prodi.search') }}" id="iprodi" required>
        @if (@$data && $data->prodi->name!='-')
        <option selected value="{{ $data->prodi_id }}">{{ $data->prodi->name }}</option>
        @endif
      </select>
    </div>
    <div class="form-group">
      <label for="idosen">Nama Dosen Pembimbing</label>
      <select name="dosen_id" data-placeholder="Pilih dosen pembimbing" class="form-control select2-ajax"
        data-url="{{ route('dosen.search') }}" id="idosen">
        @if (@$data && $data->dosen['user']['name']!='-')
        <option selected value="{{ $data->dosen_id }}">{{ $data->dosen->user->name }}</option>
        @endif
      </select>
    </div>
    <div class="form-group">
      <label for="istatus">Status</label>
      <select name="status" id="istatus" class="form-control select2">
        <option {{ @strtolower($data->status)=='aktif'?'selected':'' }} value="aktif">Aktif</option>
        <option {{ @strtolower($data->status)=='nonaktif'?'selected':'' }} value="nonaktif">Non Aktif</option>
        <option {{ @strtolower($data->status)=='cuti'?'selected':'' }} value="cuti">Cuti</option>
      </select>
    </div>
    <button type="submit" class="btn btn-block btn-primary">Simpan</button>
  </div>
</form>
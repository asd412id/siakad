<form action="#" class="modal-form" data-url="{{ $url }}" method="post">
  @csrf
  @if (@$data)
  @method('PUT')
  @else
  @method('POST')
  @endif
  <div class="container-fluid">
    <div class="form-group">
      <label for="iname">Nama</label>
      <input type="text" name="name" class="form-control" id="iname" placeholder="Masukkan nama operator"
        value="{{ @$data->name }}" required>
    </div>
    <div class="form-group">
      <label for="iusername">Username</label>
      <input type="text" name="username" class="form-control" id="iusername" placeholder="Masukkan username operator"
        value="{{ @$data->username }}">
    </div>
    <div class="form-group">
      <label for="ipassword">Password</label>
      <input type="password" name="password" class="form-control" id="ipassword" placeholder="Masukkan password dosen">
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
    <button type="submit" class="btn btn-block btn-primary">Simpan</button>
  </div>
</form>
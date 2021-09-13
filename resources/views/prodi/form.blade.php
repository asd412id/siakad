<form action="#" class="modal-form" data-url="{{ $url }}" method="post">
  @csrf
  @if (@$data)
  @method('PUT')
  @else
  @method('POST')
  @endif
  <div class="container-fluid">
    <div class="form-group">
      <label for="iname">Nama Prodi</label>
      <input type="text" name="name" class="form-control" id="iname" placeholder="Masukkan nama program studi"
        value="{{ @$data->name }}" required>
    </div>
    <button type="submit" class="btn btn-block btn-primary">Simpan</button>
  </div>
</form>
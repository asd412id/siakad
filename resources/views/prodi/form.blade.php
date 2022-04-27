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
    <div class="form-group">
      <label for="ikaprodiname">Nama Ketua Prodi</label>
      <input type="text" name="opt[kaprodi_name]" class="form-control" id="ikaprodiname"
        placeholder="Masukkan nama Ketua Prodi"
        value="{{ @$data->opt && isset($data->opt['kaprodi_name'])?$data->opt['kaprodi_name']:null }}" required>
    </div>
    <div class="form-group">
      <label for="ikaprodinip">NIP Ketua Prodi</label>
      <input type="text" name="opt[kaprodi_nip]" class="form-control" id="ikaprodinip"
        placeholder="Masukkan NIP Ketua Prodi"
        value="{{ @$data->opt && isset($data->opt['kaprodi_nip'])?$data->opt['kaprodi_nip']:null }}" required>
    </div>
    <div class="form-group">
      <label for="itgllulus">Tanggal Kelulusan (Print)</label>
      <input type="date" name="opt[tgl_lulus]" class="form-control" id="itgllulus"
        placeholder="Masukkan Tanggal Kelulusan untuk Transkrip Prestasi"
        value="{{ @$data->opt && isset($data->opt['tgl_lulus'])?$data->opt['tgl_lulus']:null }}" required>
    </div>
    <div class="form-group">
      <label for="itglttd">Tanggal Tanda Tangan (Print)</label>
      <input type="date" name="opt[tgl_ttd]" class="form-control" id="itglttd"
        placeholder="Masukkan Tanggal Tanda Tangan untuk Transkrip Prestasi"
        value="{{ @$data->opt && isset($data->opt['tgl_ttd'])?$data->opt['tgl_ttd']:null }}" required>
    </div>
    <button type="submit" class="btn btn-block btn-primary">Simpan</button>
  </div>
</form>
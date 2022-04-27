<form action="#" class="modal-form" data-url="{{ $url }}" method="post">
  @csrf
  @if (@$data)
  @method('PUT')
  @else
  @method('POST')
  @endif
  <div class="container-fluid">
    <div class="form-group">
      <label for="iname">Nama Mata Kuliah</label>
      <input type="text" name="name" class="form-control" id="iname" placeholder="Masukkan nama Mata Kuliah"
        value="{{ @$data->name }}" required>
    </div>
    <div class="form-group">
      <label for="isemester">Semester</label>
      <input type="number" name="semester" class="form-control" id="isemester" placeholder="Semester ..."
        value="{{ @$data->semester??1 }}" required>
    </div>
    <div class="form-group">
      <label for="isks">Jumlah SKS</label>
      <input type="number" name="sks" class="form-control" id="isks" placeholder="Jumlah SKS"
        value="{{ @$data->sks??2 }}">
    </div>
    @if (auth()->user()->isAdmin)
    <div class="form-group">
      <label for="iprodi">Program Studi</label>
      <select name="prodi_id" class="form-control select2-ajax" data-url="{{ route('prodi.search') }}" id="iprodi"
        required>
        <option value="">Pilih Program Studi</option>
        @if (@$data)
        <option selected value="{{ $data->prodi_id }}">{{ $data->prodi->name }}</option>
        @endif
      </select>
    </div>
    @endif
    <button type="submit" class="btn btn-block btn-primary">Simpan</button>
  </div>
</form>
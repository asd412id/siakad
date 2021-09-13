<form action="#" class="modal-form" data-url="{{ $url }}" method="post">
  @csrf
  @method('DELETE')
  <div class="container-fluid text-center">
    <div class="form-group">
      @if (!is_array($data))
      <h4>{{ $data }}</h4>
      @else
      @foreach ($data as $n)
      @if ($n)
      <h4>{{ $n }}</h4>
      @endif
      @endforeach
      @endif
      <h4 class="bg-danger px-4 py-1 mt-2 d-inline-block rounded">Hapus?</h4>
    </div>
    <button type="submit" class="btn btn-block btn-primary">YA</button>
    <button type="button" data-dismiss="modal" class="btn btn-block btn-default">TIDAK</button>
  </div>
</form>
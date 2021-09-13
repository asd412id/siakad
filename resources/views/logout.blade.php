<form action="#" data-url="{{ route('logout.process') }}" class="modal-form">
  @csrf
  <div class="text-center form-group">
    <h4>Yakin ingin keluar?</h4>
  </div>
  <div class="form-group text-center">
    <button class="btn btn-block btn-danger" type="submit">Ya</button>
    <button class="btn btn-block btn-default" data-dismiss="modal" type="button">Tidak</button>
  </div>
</form>
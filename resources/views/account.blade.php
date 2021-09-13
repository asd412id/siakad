<form class="modal-form" method="POST" data-url="{{ route('account.update') }}">
  @csrf
  <div class="container-fluid">
    @if (auth()->user()->role == 0)
    <div class="form-group">
      <label for="iname">Nama</label>
      <input type="text" name="name" class="form-control" id="iname" value="{{ $user->name }}"
        placeholder="Masukkan nama lengkap" required>
    </div>
    <div class="form-group">
      <label for="iusername">Username</label>
      <input type="text" name="username" class="form-control" id="iusername" value="{{ $user->username }}"
        placeholder="Masukkan username" required>
    </div>
    <div class="form-group">
      <label for="ipassword">Password (Untuk melakukan perubahan)</label>
      <input type="password" name="password" class="form-control" id="ipassword"
        placeholder="Masukkan password saat ini" required>
    </div>
    @endif
    <div class="form-group">
      <label for="inpassword">Password Baru</label>
      <input type="password" name="newpassword" class="form-control" id="inpassword"
        placeholder="Masukkan password baru jika ingin mengubah password">
    </div>
    <div class="form-group">
      <label for="irepassword">Ulang Password Baru</label>
      <input type="password" name="newpassword_confirmation" class="form-control" id="irepassword"
        placeholder="Masukkan ulang password baru">
    </div>
    @if (auth()->user()->role != 0)
    <div class="form-group">
      <label for="ipassword">Password (Untuk melakukan perubahan)</label>
      <input type="password" name="password" class="form-control" id="ipassword"
        placeholder="Masukkan password saat ini" required>
    </div>
    @endif
    <button type="submit" class="btn btn-block btn-primary">Simpan</button>
  </div>
</form>
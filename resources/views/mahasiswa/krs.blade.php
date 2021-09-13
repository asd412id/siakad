<div class="row">
  <div class="col-md-4">
    <table class="table table-mhs-info">
      <tr>
        <th colspan="3" class="text-center table-title">DATA MAHASISWA</th>
      </tr>
      <tr>
        <td>NIM</td>
        <td>:</td>
        <th>{{ $data->nim }}</th>
      </tr>
      <tr>
        <td>Nama</td>
        <td>:</td>
        <th>{{ $data->user->name }}</th>
      </tr>
      <tr>
      <tr>
        <td>TTL</td>
        <td>:</td>
        <th>{{ $data->tempat_lahir.', '.$data->tgl_lahir->translatedFormat('j F Y') }}</th>
      </tr>
      <tr>
        <td>JK</td>
        <td>:</td>
        <th>{{ $data->jenis_kelamin_text }}</th>
      </tr>
      <tr>
        <td>Prodi</td>
        <td>:</td>
        <th>{{ $data->prodi->name }}</th>
      </tr>
      <tr>
        <td>Dosen PA</td>
        <td>:</td>
        <th>{{ @$data->dosen->user->name??'-' }}</th>
      </tr>
      <tr>
        <td>Status</td>
        <td>:</td>
        <th><span
            class="badge badge-{{ strtolower($data->status)=='aktif'?'success':(strtolower($data->status)=='nonaktif'?'danger':'warning') }}">{{ $data->status }}</span>
        </th>
      </tr>
    </table>
  </div>
  <div class="col-md-8">
    <div class="card card-white card-tabs card-krs">
      @if (count($semester))
      <div class="card-header p-0 pt-1">
        <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
          @foreach ($semester as $key => $smt)
          <li class="nav-item">
            <a class="nav-link {{ $key==0?'active':'' }}" id="custom-tabs-{{ $smt->semester }}-tab" data-toggle="pill"
              href="#custom-tabs-{{ $smt->semester }}" role="tab" aria-controls="custom-tabs-{{ $smt->semester }}"
              aria-selected="true">{{ 'Semester '.$smt->semester }}</a>
          </li>
          @endforeach
        </ul>
      </div>
      <div class="card-body">
        <form class="modal-form" action="#" data-url="{{ $url }}" method="post">
          @csrf
          <div class="tab-content" id="custom-tabs-one-tabContent">
            @foreach ($semester as $key => $smt)
            @php($krsselected =
            $krs->clone()->count()?$krs->clone()->where('semester',$smt->semester)->get()->pluck('mata_kuliah_id')->toArray():[])
            @php($totalsks =
            $krs->clone()->count()?array_sum($krs->clone()->where('semester',$smt->semester)->get()->pluck('sks')->toArray()):0)
            <div class="tab-pane fade {{ $key==0?'show active':'' }}" id="custom-tabs-{{ $smt->semester }}"
              role="tabpanel" aria-labelledby="custom-tabs-{{ $smt->semester }}">
              <div class="row">
                <div class="col-md-6">
                  <table class="table table-bordered table-mk-choices">
                    <thead>
                      <tr>
                        <th>Pilih</th>
                        <th>Mata Kuliah</th>
                        <th>SMT</th>
                        <th>SKS</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($mata_kuliah as $mk)
                      <tr>
                        <td class="text-center"><input class="mk-choices" type="checkbox"
                            data-target="#mk-choice-{{ $smt->semester }}-{{ $mk->id }}"
                            name="mk[{{ $smt->semester }}][]" value="{{ $mk->id }}"
                            {{ @in_array($mk->id,$krsselected)?'checked':'' }}></td>
                        <td class="mk">{{ $mk->name }}</td>
                        <td class="smt text-center">{{ $mk->semester }}</td>
                        <td class="sks text-center">{{ $mk->sks }}</td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
                <div class="col-md-6">
                  <table class="table table-bordered table-mk-selected">
                    <thead>
                      <tr>
                        <th>Mata Kuliah</th>
                        <th>SMT</th>
                        <th>SKS</th>
                      </tr>
                    </thead>
                    <tbody class="prepend">
                      @php($listkrs = $krs->clone()->get())
                      @foreach ($listkrs as $v)
                      @continue($smt->semester != $v->semester)
                      <tr class="mk-selected" id="mk-choice-{{ $v->semester }}-{{ $v->mata_kuliah_id }}">
                        <td class="mk">{{ $v->mata_kuliah->name }}</td>
                        <td class="smt text-center">{{ $v->mata_kuliah->semester }}</td>
                        <td class="sks text-center">{{ $v->sks }}</td>
                      </tr>
                      @endforeach
                      <tr>
                        <th colspan="2">Total SKS Dipilih</th>
                        <th class="tsks text-center">{{ $totalsks }}</th>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            @endforeach
          </div>
          <div class="text-center">
            <button type="submit" class="btn btn-primary">SIMPAN</button>
            <button type="button" class="btn btn-warning" id="reset-mk">RESET</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">BATAL</button>
          </div>
        </form>
      </div>
      @else
      <span class="h4 p-2 mb-0 text-center">Mata Kuliah tidak tersedia</span>
      @endif
    </div>
  </div>
</div>
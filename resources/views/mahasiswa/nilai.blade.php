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
        <th>{{ ($data->tempat_lahir??'-').', '.(isset($data->tgl_lahir)?$data->tgl_lahir->translatedFormat('j F Y'):'-')
          }}</th>
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
            class="badge badge-{{ strtolower($data->status)=='aktif'?'success':(strtolower($data->status)=='nonaktif'?'danger':'warning') }}">{{
            $data->status }}</span>
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
            <div class="tab-pane fade {{ $key==0?'show active':'' }}" id="custom-tabs-{{ $smt->semester }}"
              role="tabpanel" aria-labelledby="custom-tabs-{{ $smt->semester }}">
              <div class="row">
                <div class="container-fluid">
                  <table class="table table-bordered table-nilai">
                    <thead>
                      <tr>
                        <th>Mata Kuliah</th>
                        <th class="text-center">Semester</th>
                        <th class="text-center" colspan="2">NILAI</th>
                        <th class="text-center">SKS</th>
                        <th class="text-center">Total</th>
                      </tr>
                    </thead>
                    <tbody class="prepend">
                      @php($listkrs = $krs->clone()->get())
                      @php($totalsks = 0)
                      @php($totalnilai = 0)
                      @foreach ($listkrs as $v)
                      @continue($smt->semester != $v->semester)
                      @php($totalsks += $v->sks)
                      @php($totalnilai += $v->sks * (@$v->nilai->poin_nilai??0))
                      <tr class="mk-selected" id="mk-choice-{{ $v->semester }}-{{ $v->mata_kuliah_id }}">
                        <td class="mk text-nowrap">{{ $v->mata_kuliah->name }}</td>
                        <td class="smt text-center">{{ $v->mata_kuliah->semester }}</td>
                        <td><input type="number" class="form-control nil"
                            name="bnilai[{{ $smt->semester }}][{{ $v->mata_kuliah_id }}][]"
                            value="{{ $v->nilai&&$v->nilai->bnilai?$v->nilai->bnilai:null }}"></td>
                        <td>
                          <select disabled name="index[{{ $smt->semester }}][{{ $v->mata_kuliah_id }}][]"
                            class="form-control index">
                            <option value="">Index</option>
                            <option {{ $v->nilai&&$v->nilai->poin_nilai==4?'selected':'' }} value="4">A+</option>
                            <option {{ $v->nilai&&$v->nilai->poin_nilai==3.75?'selected':'' }} value="3.75">A</option>
                            <option {{ $v->nilai&&$v->nilai->poin_nilai==3.5?'selected':'' }} value="3.5">A-</option>
                            <option {{ $v->nilai&&$v->nilai->poin_nilai==3.25?'selected':'' }} value="3.25">B+</option>
                            <option {{ $v->nilai&&$v->nilai->poin_nilai==3?'selected':'' }} value="3">B</option>
                            <option {{ $v->nilai&&$v->nilai->poin_nilai==2.75?'selected':'' }} value="2.75">B-</option>
                            <option {{ $v->nilai&&$v->nilai->poin_nilai==2.5?'selected':'' }} value="2.5">C+</option>
                            <option {{ $v->nilai&&$v->nilai->poin_nilai==2.25?'selected':'' }} value="2.25">C</option>
                            <option {{ $v->nilai&&$v->nilai->poin_nilai==2?'selected':'' }} value="2">C-</option>
                            <option {{ $v->nilai&&$v->nilai->poin_nilai==1?'selected':'' }} value="1">D</option>
                            <option {{ $v->nilai&&$v->nilai->poin_nilai==0?'selected':'' }} value="0">E</option>
                          </select>
                        </td>
                        <td class="sks text-center">{{ $v->sks }}</td>
                        <td class="total text-center">{{ @$v->nilai->total_nilai??$v->sks*4 }}</td>
                      </tr>
                      @endforeach
                      <tr>
                        <td colspan="4" class="text-center">TOTAL</td>
                        <th class="text-center totalsk">{{ $totalsks }}</th>
                        <th class="text-center totalnilai">{{ $totalnilai }}</th>
                      </tr>
                      <tr>
                        <td colspan="4" class="text-center">IPS</td>
                        <th colspan="3" class="text-center ips">{{ number_format(round($totalnilai/$totalsks,2),2) }}
                        </th>
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
            <button type="button" class="btn btn-warning" id="reset-nilai">RESET</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">BATAL</button>
          </div>
        </form>
      </div>
      @else
      <span class="h4 text-center p-2 mb-0">KRS belum diisi!</span>
      @endif
    </div>
  </div>
</div>
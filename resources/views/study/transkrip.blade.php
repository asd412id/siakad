<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Transkrip Prestasi {{ (isset($data->nim)?$data->nim.' - ':'').$data->user->name }}</title>
  <style>
    .bio th,
    .bio td {
      vertical-align: top;
    }

    #tnilai {
      border-collapse: collapse;
      border: solid 1px #000;
    }

    #tnilai th,
    #tnilai td {
      border: solid 1px #000;
      vertical-align: top;
      padding: 3px 5px;
    }

    table tr,
    table th,
    table td {
      break-inside: avoid !important;
      page-break-inside: avoid !important;
    }
  </style>
</head>

<body style="padding: 15px" onload="window.print()">
  <table style="width: 100%">
    <tr>
      <td style="width: 10px">
        <img src="{{ asset('img/logo.png') }}" alt="" style="width: 65px">
      </td>
      <td style="vertical-align: middle;font-size: 1.5rem;text-align: center;font-weight: bold">
        TRANSKRIP PRESTASI AKADEMIK SEMENTARA</td>
    </tr>
    <tr>
      <td colspan="2" align="center" style="font-weight: bold;font-size: 1rem">DIBERIKAN KEPADA</td>
    </tr>
  </table>
  <table style="width: 100%;margin-top: 15px">
    <tr>
      <td>
        <table class="bio">
          <tr>
            <th align="left" width="100">Nama</th>
            <th align="left" width="10">:</th>
            <td>{{ $data->user->name }}</td>
          </tr>
          <tr>
            <th align="left">NIM</th>
            <th align="left" width="10">:</th>
            <td>{{ $data->nim }}</td>
          </tr>
          <tr>
            <th align="left">TTL</th>
            <th align="left" width="10">:</th>
            <td>{{ ($data->tempat_lahir??'-').', '.(isset($data->tgl_lahir)?$data->tgl_lahir->translatedFormat('j F
              Y'):'-')
              }}</td>
          </tr>
        </table>
      </td>
      <td align="right">
        <table class="bio">
          <tr>
            <th align="left" width="100">Fakultas</th>
            <th align="left" width="10">:</th>
            <td>Tarbiyah dan Ilmu Keguruan</td>
          </tr>
          <tr>
            <th align="left">Prog. Studi</th>
            <th align="left" width="10">:</th>
            <td>{{ $data->prodi->name }}</td>
          </tr>
          <tr>
            <th align="left">Tgl. Lulus</th>
            <th align="left" width="10">:</th>
            <td>{{ isset($data->prodi->opt) && isset($data->prodi->opt['tgl_lulus']) &&
              $data->prodi->opt['tgl_lulus'] != null && $data->prodi->opt['tgl_lulus'] !=
              ''?Carbon\Carbon::parse($data->prodi->opt['tgl_lulus'])->translatedFormat('j
              F
              Y'):'-' }}</td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
  <table style="width: 100%;margin-top: 30px" id="tnilai">
    <thead>
      <tr>
        <th>No</th>
        <th>Nama Mata Kuliah</th>
        <th>Bobot Kredit (K)</th>
        <th>Nilai Huruf (NH)</th>
        <th>Kualitas (NH &times; K)</th>
      </tr>
    </thead>
    <tbody>
      @php
      $jk = 0;
      $jnh = 0;
      $jnhk = 0;
      @endphp
      @forelse ($data->krs as $key => $n)
      @php
      $jk+=$n->mata_kuliah->sks;
      $jnh += $n->nilai->poin_nilai;
      $jnhk+=$n->nilai->poin_nilai * $n->mata_kuliah->sks;
      @endphp
      <tr>
        <td align="center">{{ $key+1 }}.</td>
        <td>{{ $n->mata_kuliah->name }}</td>
        <td align="center">{{ $n->mata_kuliah->sks }}</td>
        <td align="center">{{ $n->nilai->index_nilai }}</td>
        <td align="center">{{ $n->nilai->poin_nilai * $n->mata_kuliah->sks }}</td>
      </tr>
      @if ($key==count($data->krs)-1)
      <tr>
        <td colspan="2" align="center" style="font-weight: bold">Jumlah</td>
        <td align="center" style="font-weight: bold">{{ $jk }}</td>
        <td align="center" style="font-weight: bold">{{ $jnh }}</td>
        <td align="center" style="font-weight: bold">{{ $jnhk }}</td>
      </tr>
      @endif
      @empty
      <tr>
        <td colspan="5" align="center">Transkrip tidak tersedia</td>
      </tr>
      @endforelse
    </tbody>
  </table>
  <table width="100%" style="margin-top: 30px">
    <tr>
      <td style="vertical-align: top">
        <table>
          <tr>
            <td>Indeks Prestasi Kumulatif (IPK)</td>
            <td>:</td>
            <td style="font-weight: bold">{{ $ipk = number_format(round($jnhk/$jk,2),2) }}</td>
          </tr>
          <tr>
            <td>Jumlah Kredit</td>
            <td>:</td>
            <td style="font-weight: bold">{{ $jk }}</td>
          </tr>
        </table>
      </td>
      <td style="vertical-align: top">
        @php
        switch($ipk){
        case $ipk >= 3.76 && $ipk <= 4: $predikat='CUMLAUDE' ; break; case $ipk>= 3.51 && $ipk <= 3.75:
            $predikat='PUJIAN' ; break; case $ipk>= 3.01 && $ipk <= 3.5: $predikat='SANGAT MEMUASKAN' ; break; case
              $ipk>= 2.76 && $ipk <= 3: $predikat='MEMUASKAN' ; break; default: $predikat='CUKUP' ; break; } @endphp
                <table>
    <tr>
      <td>Predikat Kelulusan</td>
      <td>:</td>
      <td style="font-weight: bold">{{ $predikat }}</td>
    </tr>
  </table>
  </td>
  </tr>
  </table>
  <table width="80%" style="margin: 30px auto 0">
    <tr>
      <td align="right">
        <table>
          <tr>
            <td>Palopo, {{ isset($data->prodi->opt) && isset($data->prodi->opt['tgl_ttd']) &&
              $data->prodi->opt['tgl_ttd'] != null && $data->prodi->opt['tgl_ttd'] !=
              ''?Carbon\Carbon::parse($data->prodi->opt['tgl_ttd'])->translatedFormat('j
              F
              Y'):now()->translatedFormat('j F Y') }}</td>
          </tr>
          <tr>
            <td>Ketua Prodi</td>
          </tr>
          <tr>
            <td height="65"></td>
          </tr>
          <tr>
            <td style="border-bottom: solid 1px;vertical-align: bottom;font-weight: bold" width="175">
              {{ isset($data->prodi->opt)?$data->prodi->opt['kaprodi_name']:'' }}
            </td>
          </tr>
          <tr>
            <td style="vertical-align: top">NIP. {{ isset($data->prodi->opt)?$data->prodi->opt['kaprodi_nip']:'' }}</td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>

</html>
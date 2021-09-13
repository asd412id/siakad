<table class="table table-bordered table-hover dtable">
  <thead>
    <tr>
      <th rowspan="2" class="text-center">NIM</th>
      <th rowspan="2" class="text-center">NAMA</th>
      @foreach ($semester as $smt)
      <th colspan="3" class="text-center">SMST {{ $smt->semester }}</th>
      @if ($smt->semester==6)
      <th rowspan="2">WARNING</th>
      @endif
      @if ($smt->semester==7)
      <th colspan="2" class="text-center">WARNING</th>
      @endif
      @if ($smt->semester==8)
      <th colspan="2" class="text-center">HASIL AKHIR</th>
      @endif
      @endforeach
    </tr>
    <tr>
      @foreach ($semester as $smt)
      <th class="text-center">L</th>
      <th class="text-center">TL</th>
      <th class="text-center">KET</th>
      @continue($smt->semester==6)
      @if ($smt->semester==7)
      <th class="text-center">KKN</th>
      <th class="text-center">UKOM</th>
      @endif
      @if ($smt->semester==8)
      <th class="text-center">TOTAL SKS</th>
      <th class="text-center">KETERANGAN</th>
      @endif
      @endforeach
    </tr>
  </thead>
  <tbody>
    @foreach ($mahasiswa as $mhs)
    @php
    $totalsks = 0;
    $totallulus = 0;
    $totaltidaklulus = 0;
    @endphp
    <tr>
      <td class="text-nowrap">{{ $mhs->nim }}</td>
      <td class="text-nowrap text-uppercase">{{ $mhs->user->name }}</td>
      @foreach ($semester as $smt)
      @php
      $getlulus = $mhs->nilai()->where('semester',$smt->semester)
      ->where('poin_nilai','>=',3)->select('sks')->get()
      ->pluck('sks')->toArray();
      $gettidaklulus = $mhs->nilai()->where('semester',$smt->semester)
      ->where('poin_nilai','<',3)->select('sks')->get()
        ->pluck('sks')->toArray();
        $lulus = array_sum($getlulus);
        $tidaklulus = array_sum($gettidaklulus);
        $ket = $lulus>$tidaklulus?'Studi lancar':'Studi tidak lancar';
        $totalsks += ($lulus+$tidaklulus);
        $totallulus += $lulus;
        $totaltidaklulus += $tidaklulus;
        @endphp
        <td class="text-center">{{ $lulus }}</td>
        <td class="text-center">{{ $tidaklulus }}</td>
        <td class="text-center text-nowrap">{{ $ket }}</td>
        @if ($smt->semester==6)
        <td>{{ $totallulus<=$totaltidaklulus?'Rekomendasi D.O.':'' }}</td>
        @endif
        @if ($smt->semester==7)
        <td class="text-nowrap">
          {{ $totallulus>0&&$totallulus>$totaltidaklulus?'Memenuhi syarat':'Belum memenuhi syarat' }}</td>
        <td class="text-nowrap">
          {{ $totallulus>0&&$totallulus>$totaltidaklulus?'Memenuhi syarat':'Belum memenuhi syarat' }}</td>
        @endif
        @endforeach
        <td class="text-center">{{ $totalsks }}</td>
        <td class="text-center"></td>
    </tr>
    @endforeach
  </tbody>
</table>
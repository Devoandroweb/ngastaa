@php
    $GLOBALS['mJadwalShift'] = $mJadwalShift;
    function getJadwalShift($nip,$tanggal){
        foreach ($GLOBALS['mJadwalShift'] as $value) {
            if($nip === $value->nip && $tanggal == $value->tanggal){
                return $value;
            }
        }
        // dd($nip,$tanggal);
        return null;
    }
@endphp

<table>
   <tr>
    <th style="color:white;background:brown;font-weight:bold;text-align:center;">NO</th>
    <th style="color:white;background:brown;font-weight:bold;text-align:center;">DIVISI</th>
    <th style="color:white;background:brown;font-weight:bold;text-align:center;">JABATAN</th>
    <th style="color:white;background:brown;font-weight:bold;text-align:center;">NAMA PEGAWAI</th>
    @foreach ($tanggalAwalAkhir as $tanggal)
        <th style="color:white;background:brown;font-weight:bold;text-align:center;">{{strtoupper(tanggal_indo($tanggal->format('d-m-Y')))}}</th>
    @endforeach
    </tr>
    @foreach ($mUsers as $i => $value)
        <tr>
            <td>{{($i+1)}}</td>
            <td>{{$value->getNamaDivisi()}}</td>
            <td>{{$value->getNamaJabatan()}}</td>
            <td>{{$value->getFullName()}}</td>
            @foreach ($tanggalAwalAkhir as $i => $tanggal )
                @php
                    $jadwalShift = getJadwalShift($value->nip,$tanggal->format('Y-m-d'));
                    $text = "";
                    $shift = null;
                    if($jadwalShift){
                        $shift = $jadwalShift->shift;
                        $text .= $shift?->nama.' ('.date('H:i',strtotime($shift?->jam_tepat_datang)).'-'.date('H:i',strtotime($shift?->jam_tepat_pulang)).')';
                    }else{
                        $text = "-";
                    }
                @endphp
                <td>{{$text}}</td>
            @endforeach
        </tr>
    @endforeach
</table>




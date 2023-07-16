@php
    $GLOBALS['dataPresensi'] = \App\Models\Presensi\TotalPresensiDetail::whereNip($pegawai->nip)->whereBetween('tanggal',[$tahun."-".$bulan."-01",$tahun."-".$bulan."-".lastDayInThisMonth($bulan,$tahun)])->get();
    // dd(lastDayInThisMonth("2023","06"));
    // dd($jamKerja);
    $styleTable = "border:1px solid black;";
    function searchDataPresensi($tanggal){
        foreach ($GLOBALS['dataPresensi'] as $key => $value) {
            if($value->tanggal == $tanggal){
                return $value;
            }
        }
        return null;
    }
    function hitungTelat($jamTepatDatang,$jamDatang,$toleransi){
        // dd($jamDatang, $jamTepatDatang);

        $jamTepatDatang = strtotime($jamTepatDatang." +".$toleransi." Minutes");
        $jamDatang = strtotime($jamDatang);
        $result = "-";
        if($jamDatang > $jamTepatDatang){
            $selisihDetik = abs($jamTepatDatang - $jamDatang);
            $selisihMenit = floor($selisihDetik / 60);
            $result = $selisihDetik;

            $jam = floor($selisihMenit / 60); // Menghitung jam
            $menit = $selisihMenit % 60;
            if($jam != 0){
                return $jam ." Jam ".$menit." Menit";
            }
            if($menit != 0){
                return $menit." Menit";
            }
            return "-";
        }
        return $result;
    }
    function hitungCepatPulang($jamTepatPulang,$jamPulang){
        // dd($jamPulang, $jamTepatPulang);
        if($jamPulang){
            $jamTepatPulang = strtotime($jamTepatPulang);
            $jamPulang = strtotime($jamPulang);
            $result = "-";
            if($jamPulang < $jamTepatPulang){
                $selisihDetik = abs($jamTepatPulang - $jamPulang);
                $selisihMenit = floor($selisihDetik / 60);
                $result = $selisihDetik;

                $jam = floor($selisihMenit / 60); // Menghitung jam
                $menit = $selisihMenit % 60;
                if($jam != 0){
                    return $jam ." Jam ".$menit." Menit";
                }
                if($menit != 0){
                    return $menit." Menit";
                }
                return "-";
            }
            return $result;
        }else{
            return "-";
        }
    }
@endphp
<html>
    <body>
        <table>
            <tr>
                <td colspan="10" style="text-align: center;font-size:15pt;font-weight:bold;"><h3>DRAFT RINCIAN KEHADIRAN</h3></td>
            </tr>
        </table>
        <tr>
            <td colspan="3">TANGGAL CETAK : {{tanggal_indo(date('Y-m-d'))}}</td>
        </tr>
        <tr><td></td></tr>
        <table width="100%">
            <tr>
                <td colspan="2">NO INDUK PEGAWAI</td>
                <td>: {{$pegawai->nip}}</td>
            </tr>
            <tr>
                <td colspan="2">NAMA</td>
                <td colspan="8">: {{$pegawai->name}}</td>
            </tr>
            <tr>
                <td colspan="2">JABATAN</td>
                <td colspan="8">: {{$pegawai->getJabatan()}}</td>
            </tr>
            <tr>
                <td colspan="2">DIVISI</td>
                <td colspan="8">: {{$pegawai->getDivisi()}}</td>
            </tr>
            <tr>
                <td colspan="2">BULAN / TAHUN</td>
                <td colspan="8">: {{$bulan." / ".$tahun}}</td>
            </tr>
            <tr>
                <td colspan="2">SHIFT/JAM KERJA</td>
                <td colspan="8">: {{$jamKerja->nama}}</td>
            </tr>
        </table>
        <br>
        <table width="100%">
            <tr>
                <th style="{{$styleTable}}font-weight:bold">No</th>
                <th style="{{$styleTable}}font-weight:bold">Status</th>
                <th style="{{$styleTable}}font-weight:bold">Hari</th>
                <th style="{{$styleTable}}font-weight:bold">Tanggal</th>
                <th style="{{$styleTable}}font-weight:bold">Jam Datang</th>
                <th style="{{$styleTable}}font-weight:bold">Telat Datang</th>
                <th style="{{$styleTable}}font-weight:bold">Jam Istirahat</th>
                <th style="{{$styleTable}}font-weight:bold">Jam Pulang</th>
                <th style="{{$styleTable}}font-weight:bold">Pulang Cepat</th>
                <th style="{{$styleTable}}font-weight:bold">Keterangan</th>
            </tr>
            @foreach (arrayTanggal("06","2023",1,lastDayInThisMonth("2023","06")) as $i => $item)

                @php
                    $statusName = "-";
                    $presensi = searchDataPresensi($item);
                    $jamDatang = $presensi?->tanggal_datang ? date("H:i",strtotime($presensi?->tanggal_datang)) : "-" ;
                    $jamIstirahat = $presensi?->tanggal_istirahat ? date("H:i",strtotime($presensi?->tanggal_istirahat)) : "-" ;
                    $jamPulang = $presensi?->tanggal_pulang ? date("H:i",strtotime($presensi?->tanggal_pulang)) : "-" ;
                    if($presensi){
                        $status = explode(",",$presensi->status);
                        if($status[0] == ""){
                            $status = [];
                        }
                        if (count($status) > 0) {
                            $statusName = "";
                            foreach ($status as $iter => $value) {
                                $statusName .= convertStatusAbsen($value);
                                if($iter != (count($status)-1)){
                                    $statusName .= ", ";
                                }
                            }
                        }
                    }
                @endphp
                <tr>
                    @php
                        $styleBgYellow = "background: yellow;";
                    @endphp
                    <td style="text-align: center;{{$styleTable}}@if(!$presensi) {{$styleBgYellow}} @endif">{{$i+1}}</td>
                    <td style="{{$styleTable}}@if(!$presensi) {{$styleBgYellow}} @endif">{{$statusName}}</td>
                    <td style="{{$styleTable}}@if(!$presensi) {{$styleBgYellow}} @endif">{{convertDateToNameDay($item)}}</td>
                    <td style="{{$styleTable}}@if(!$presensi) {{$styleBgYellow}} @endif">{{tanggal_indo($item)}}</td>
                    <td style="{{$styleTable}}@if(!$presensi) {{$styleBgYellow}} @endif">{{$jamDatang}}</td>
                    <td style="{{$styleTable}}@if(!$presensi) {{$styleBgYellow}} @endif">{{hitungTelat($item." ".$jamKerja->jam_tepat_datang,$presensi?->tanggal_datang,$jamKerja->toleransi_datang)}}</td>
                    <td style="{{$styleTable}}@if(!$presensi) {{$styleBgYellow}} @endif">{{$jamIstirahat}}</td>
                    <td style="{{$styleTable}}@if(!$presensi) {{$styleBgYellow}} @endif">{{$jamPulang}}</td>
                    <td style="{{$styleTable}}@if(!$presensi) {{$styleBgYellow}} @endif">{{hitungCepatPulang($item." ".$jamKerja->jam_tepat_pulang,$presensi?->tanggal_pulang)}}</td>
                    <td style="{{$styleTable}}@if(!$presensi) {{$styleBgYellow}} @endif"></td>
                </tr>
            @endforeach
        </table>
    </body>
</html>

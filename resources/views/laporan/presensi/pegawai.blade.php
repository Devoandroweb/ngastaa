@php
    $GLOBALS['dataPresensi'] = \App\Models\Presensi\TotalPresensiDetail::whereNip($pegawai->nip)->whereBetween('tanggal',[$tahun."-".$bulan."-01",$tahun."-".$bulan."-".lastDayInThisMonth($bulan,$tahun)])->get();
    // dd(lastDayInThisMonth("2023","06"));
    // dd($jamKerja);
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
    <style>
        table{
            border-collapse: collapse;
        }
        table td,table th{
            border: 1px solid black;
            padding: 0 5px;
        }
        body{
            font-size: 9pt;
        }
    </style>
    <body>
        <center>
            <h3>DRAFT RINCIAN KEHADIRAN</h3>
        </center>
        <p style="font-weight: bold">TANGGAL CETAK : {{tanggal_indo(date('Y-m-d'))}}</p>
        <table width="100%">
            <tr>
                <td style="width: 20%">NO INDUK PEGAWAI</td>
                <td>: {{$pegawai->nip}}</td>
            </tr>
            <tr>
                <td>NAMA</td>
                <td>: {{$pegawai->name}}</td>
            </tr>
            <tr>
                <td>JABATAN</td>
                <td>: {{$pegawai->getJabatan()}}</td>
            </tr>
            <tr>
                <td>DIVISI</td>
                <td>: {{$pegawai->getDivisi()}}</td>
            </tr>
            <tr>
                <td>BULAN / TAHUN</td>
                <td>: {{$bulan." / ".$tahun}}</td>
            </tr>
            <tr>
                <td>SHIFT/JAM KERJA</td>
                <td>: {{$jamKerja->nama}}</td>
            </tr>
        </table>
        <br>
        <table width="100%">
            <tr>
                <th>No</th>
                <th>Status</th>
                <th>Hari</th>
                <th>Tanggal</th>
                <th>Jam Datang</th>
                <th>Telat Datang</th>
                <th>Jam Istirahat</th>
                <th>Jam Pulang</th>
                <th>Pulang Cepat</th>
                <th>Keterangan</th>
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
                <tr @if(!$presensi) style="background: yellow" @endif>
                    <td style="text-align: center">{{$i+1}}</td>
                    <td>{{$statusName}}</td>
                    <td>{{convertDateToNameDay($item)}}</td>
                    <td>{{tanggal_indo($item)}}</td>
                    <td>{{$jamDatang}}</td>
                    <td>{{hitungTelat($item." ".$jamKerja->jam_tepat_datang,$presensi?->tanggal_datang,$jamKerja->toleransi_datang)}}</td>
                    <td>{{$jamIstirahat}}</td>
                    <td>{{$jamPulang}}</td>
                    <td>{{hitungCepatPulang($item." ".$jamKerja->jam_tepat_pulang,$presensi?->tanggal_pulang)}}</td>
                    <td></td>
                </tr>
            @endforeach
        </table>
    </body>
</html>

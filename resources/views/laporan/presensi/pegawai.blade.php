<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>

<head>

    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>Laporan Pegawai</title>
    <meta name="generator" content="LibreOffice 7.2.5.2 (Linux)" />
    <meta name="created" content="2022-05-07T13:02:00" />
    <meta name="changed" content="2022-06-22T20:09:28" />
    <meta name="KSOProductBuildVer" content="1033-3.2.0.6370" />

    <style type="text/css">
        body,
        div,
        table,
        thead,
        tbody,
        tfoot,
        tr,
        th,
        td,
        p {
            font-family: "Times New Roman";
            font-size: x-small
        }
    </style>

</head>

<body>
    <table cellspacing="0" border="0" width="100%" border="1">
        <tr>
            <td colspan=10 height="10" align="center" valign=bottom><b>
                    <font face="Arial" size=1>DRAFT RINCIAN KEHADIRAN
                    </font>
                </b></td>
        </tr>
        @php
            $hariKerja = hari_kerja($bulan, $tahun);
            $kehadiran = kehadiran($pegawai->email, $bulan, $tahun, $hariKerja);
            $totalAkhir = $kehadiran['total_akhir'];
        @endphp
        <tr>
            <td colspan=10 height="15" align="left" valign=middle><b>
                    <font face="Arial" size=1>TANGGAL CETAK : {{ strtoupper(tanggal_indo(date('Y-m-d'))) }}</font>
                </b></td>
        </tr>
        <tr>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                colspan=4 height="12" align="left" valign=top><b>
                    <font face="Arial" size=1>NO PEGAWAI</font>
                </b></td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                colspan=6 align="left" valign=top><b>
                    <font face="Arial" size=1>: {{ $pegawai->nip }}</font>
                </b></td>
        </tr>
        <tr>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                colspan=4 height="12" align="left" valign=top><b>
                    <font face="Arial" size=1>NAMA</font>
                </b></td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                colspan=6 align="left" valign=top><b>
                    <font face="Arial" size=1>: {{ $pegawai->name }}</font>
                </b></td>
        </tr>
        @php
            
        $jabatan = array_key_exists('0', $pegawai->jabatan_akhir->toArray()) ? $pegawai->jabatan_akhir[0] : null;

        $skpd           =  $jabatan?->skpd?->nama;
        $nama_jabatan   =  $jabatan?->tingkat?->nama;
        @endphp
        <tr>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                colspan=4 height="12" align="left" valign=top><b>
                    <font face="Arial" size=1>JABATAN</font>
                </b></td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                colspan=6 align="left" valign=top><b>
                    <font face="Arial" size=1>: {{ $nama_jabatan }}</font>
                </b></td>
        </tr>
        <tr>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                colspan=4 height="12" align="left" valign=top><b>
                    <font face="Arial" size=1>DIVISI</font>
                </b></td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                colspan=6 align="left" valign=top><b>
                    <font face="Arial" size=1>: {{ $skpd }}</font>
                </b></td>
        </tr>
        <tr>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                colspan=4 height="12" align="left" valign=top><b>
                    <font face="Arial" size=1>BULAN / TAHUN</font>
                </b></td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                colspan=6 align="left" valign=top><b>
                    <font face="Arial" size=1>: {{ strtoupper(bulan($bulan)) }} / {{ $tahun }}</font>
                </b></td>
        </tr>
        <tr>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000;"
                colspan=4 height="12" align="left" valign=top><b>
                    <font face="Arial" size=1>PERSENTASE KEHADIRAN</font>
                </b></td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                colspan=6 align="left" valign=top><b>
                    <font face="Arial" size=1>: {{ $totalAkhir }} %</font>
                </b></td>
        </tr>
        <tr>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                height="12" align="right" valign=top><b>
                    <font face="Arial" size=1>No</font>
                </b></td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                align="left" valign=top><b>
                    <font face="Arial" size=1>Hari</font>
                </b></td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                colspan=2 align="left" valign=top><b>
                    <font face="Arial" size=1>Tanggal</font>
                </b></td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                align="center" valign=top><b>
                    <font face="Arial" size=1>Jam datang</font>
                </b></td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                align="center" valign=top><b>
                    <font face="Arial" size=1>Telat datang</font>
                </b></td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                align="center" valign=top><b>
                    <font face="Arial" size=1>Jam Istirahat</font>
                </b></td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                align="center" valign=top><b>
                    <font face="Arial" size=1>Jam Pulang</font>
                </b></td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                align="center" valign=top><b>
                    <font face="Arial" size=1>Cepat Pulang</font>
                </b></td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                align="left" valign=top><b>
                    <font face="Arial" size=1>Keterangan</font>
                </b></td>
        </tr>
        @php
            $number = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
            $shift_id = "";
            $setting = new App\Models\Master\Shift();
        @endphp

        @for ($i = 1; $i <= $number; $i++)
            @php
                $day = date('Y-m-d', strtotime("$tahun-$bulan-$i"));
                $semua_data = kehadiran_pegawai("$tahun-$bulan-$i", $pegawai->nip);
                // dd("$tahun-$bulan-$i");
                $telat_datang = 0;
                $cepat_pulang = 0;
                
                $cek_data_datang = $semua_data ?  ($semua_data->tanggal_datang ? date('H:i', strtotime($semua_data->tanggal_datang)) : "-" ): '';
                
                if ($semua_data) {

                    if($shift_id != $semua_data->kode_shift){
                        $setting = get_shift($semua_data->kode_shift);
                        $shift_id = $semua_data->kode_shift;
                    }

                    if($semua_data->tanggal_datang){
                        if (strtotime($semua_data->tanggal_datang) >= strtotime(date('Y-m-d', strtotime($day)) . " " . $setting->jam_tepat_datang . ":59")) {
                            $dateTimeObject1 = date_create($day . " " . $setting->jam_tepat_datang); 
                            $dateTimeObject2 = date_create($semua_data->tanggal_datang); 
                            
                            $difference = date_diff($dateTimeObject1, $dateTimeObject2); 

                            $telat_datang += $difference->h * 60;
                            $telat_datang += $difference->i;
                        }
                    }else{
                        $telat_datang = 225;
                    }

                    if($semua_data->tanggal_pulang){
                            if (strtotime(date('Y-m-d', strtotime($day)) . " " . $setting->jam_tepat_pulang . ":00") >= strtotime($semua_data->tanggal_pulang)) {
                                $dateTimeObject1 = date_create($day . " " . $setting->jam_tepat_pulang . ":00"); 
                                $dateTimeObject2 = date_create($semua_data->tanggal_pulang); 
                                
                                $difference = date_diff($dateTimeObject1, $dateTimeObject2); 

                                $cepat_pulang += $difference->h * 60;
                                $cepat_pulang += $difference->i;
                        }
                    }else{
                        $cepat_pulang = 225;
                    }
                }

                $cek_data_istirahat = $semua_data ? ($semua_data->tanggal_istirahat ? date('H:i', strtotime($semua_data->tanggal_istirahat)) : '-' ) : '';
                $cek_data_pulang = $semua_data ? ($semua_data->tanggal_pulang ? date('H:i', strtotime($semua_data->tanggal_pulang)) : '-') : '';
                $liburAtauIzin = '';
       
            @endphp
            <tr>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                    width="12" height="12" align="center" valign=top sdval="1">
                    <font face="Arial" size=1 color="#000000">{{ $i }}</font>
                </td>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                    width="32" align="left" valign=top>
                    <font face="Arial" size=1>{{ hari(date('w', strtotime($day))) }}</font>
                </td>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                    colspan=2 align="center" valign=top>
                    <font face="Arial" size=1> {{ tanggal_indo($day) }}</font>
                </td>
                @if ($cek_data_datang || $cek_data_pulang || $cek_data_istirahat)
                    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                        align="center" valign=top sdval="0.364213" sdnum="1033;0;H:MM:SS;@">
                        <font face="Arial" size=1 color="#000000">{{ $cek_data_datang }}</font>
                    </td>
                    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                        align="center" valign=top sdval="0.364213" sdnum="1033;0;H:MM:SS;@">
                        <font face="Arial" size=1 color="#000000">{{ $telat_datang }} Menit</font>
                    </td>
                    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                        align="center" valign=top>
                        <font face="Arial" size=1>{{ $cek_data_istirahat }}</font>
                    </td>
                    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                        align="center" valign=top sdval="0" sdnum="1033;0;H:MM:SS;@">
                        <font face="Arial" size=1 color="#000000">{{ $cek_data_pulang }}</font>
                    </td>
                    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                        align="center" valign=top>
                        <font face="Arial" size=1>{{ $cepat_pulang }} Menit</font>
                    </td>
                @else
                    @php
                        if(date('w', strtotime($day)) != 0 && date('w', strtotime($day)) != 6){
                            $liburAtauIzin = "Tanpa Keterangan";
                        }
                        $hari = date('l', strtotime("$tahun-$bulan-$i"));
                        //$libur = check_libur("$tahun-$bulan-$i");
                        //if($libur){
                        //    $liburAtauIzin = $libur->keterangan;
                       // }
                    @endphp
                    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; background-color:{{ $hari == 'Saturday' || $hari == 'Sunday' ? '#f1416c' : 'white' }}"
                        align="center" valign=top sdval="0.364213" sdnum="1033;0;H:MM:SS;@">
                        <font face="Arial" size=1 color="#000000">-</font>
                    </td>
                    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; background-color:{{ $hari == 'Saturday' || $hari == 'Sunday' ? '#f1416c' : 'white' }}"
                        align="center" valign=top sdval="0.364213" sdnum="1033;0;H:MM:SS;@">
                        <font face="Arial" size=1 color="#000000">-</font>
                    </td>
                    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; background-color:{{ $hari == 'Saturday' || $hari == 'Sunday' ? '#f1416c' : 'white' }}"
                        align="center" valign=top>
                        <font face="Arial" size=1>-</font>
                    </td>
                    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; background-color:{{ $hari == 'Saturday' || $hari == 'Sunday' ? '#f1416c' : 'white' }}"
                        align="center" valign=top sdval="0" sdnum="1033;0;H:MM:SS;@">
                        <font face="Arial" size=1 color="#000000">-</font>
                    </td>
                    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; background-color:{{ $hari == 'Saturday' || $hari == 'Sunday' ? '#f1416c' : 'white' }}"
                        align="center" valign=top>
                        <font face="Arial" size=1>-</font>
                    </td>
                @endif
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; background-color:{{ $liburAtauIzin != '' ? '#f1416c' : 'white' }};  color:{{ $liburAtauIzin != '' ? 'white' : 'black' }};"
                    align="left" valign=middle>
                    <font color="#000000">{{ $liburAtauIzin }}</font>
                </td>
            </tr>
        @endfor

        <tr>
            <td colspan="7"></td>
            <td colspan=3 height="43" align="center" valign=bottom><b>
                    <br>
                    <br>
                    <font face="Arial" size=1>................... , {{ strtoupper(tanggal_indo(date('Y-m-d'))) }}</font>
                    <br>
                    <br>
                    <br>
                    <br>
                    <font face="Arial" size=1>{{ $pegawai->name }}</font>
                    <br>
                    <font face="Arial" size=1>No. Pegawai : {{ $pegawai->nip }}</font>
                </b></td>
        </tr>
    </table>
</body>

</html>

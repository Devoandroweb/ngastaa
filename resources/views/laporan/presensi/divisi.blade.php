<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Kehadiran Bulan</title>
    <style>
        table,
        th,
        td {
            border-collapse: collapse;
        }

    </style>
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
            font-family: "Calibri";
            font-size: x-small
        }

        .text-center{
            text-align: center;
        }

    </style>
</head>

<body>
    <div style="text-align: center; font-size: 20px; font-weight:bold; margin-bottom:0px;">
        LAPORAN KEHADIRAN PEGAWAI
        <br>
        BULAN {{ strtoupper(bulan($bulan)) }} TAHUN {{ $tahun }}
        @if($kode)
            <br>
           DIVISI KERJA : {{ strtoupper(get_skpd($kode)) }}
        @endif
    </div>
    <br>
    <br>
    @php
        $number = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun); 
    @endphp
    <table border="1" width="100%">
        <thead>
            <tr>
                <th style="text-align:center;">No</th>
                <th style="text-align:center;">Nomor Pegawai</th>
                <th style="text-align:center;">Nama</th>
                <th>Hari <br> Kerja</th>
                <th>Tanpa <br> Keterangan</th>
                <th>Total <br> Izin</th>
                <th>Total <br> Telat Datang</th>
                <th>Total <br> Cepat Pulang</th>
                <th>Total <br> Kehadiran</th>
            </tr>
        </thead>
        <tbody>
            @php
                $no = 1;
            @endphp
            @foreach($pegawai->chunk(100) as $key => $values)
                @foreach($values as $value)
                    @php
                        $kehadiran = kehadiran($value->nip, $bulan, $tahun);
                    @endphp
                    <tr>
                        <td style="text-align:center;">{{ $no++ }}</td>
                        <td>&nbsp;&nbsp;{{ $value->nip }}</td>
                        <td>&nbsp;&nbsp;{{ $value->name }}</td>
                        <td style="text-align:center;">{{ $kehadiran['hari_kerja'] }}</td>
                        <td style="text-align:center;">{{ $kehadiran['total_alfa'] }}</td>
                        <td style="text-align:center;">{{ $kehadiran['total_izin'] }}</td>
                        <td style="text-align:center;">{{ count($kehadiran['total_telat_datang']) }}</td>
                        <td style="text-align:center;">{{ count($kehadiran['total_telat_pulang']) }}</td>
                        <td style="text-align:center;">{{ number_indo($kehadiran['total_akhir'], 2) }} %</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>

</body>

</html>

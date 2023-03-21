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
    <div style="text-align: center; font-size: 40px; font-weight:bold; margin-bottom:0px;">
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
    <table>
        <thead>
            <tr>
                <th width="10" style="border: 1px solid black; text-align:center;">No</th>
                <th width="30" style="border: 1px solid black; text-align:center;">Nomor Pegawai</th>
                <th width="30" style="border: 1px solid black; text-align:center;">Nama</th>
                <th width="15" style="border: 1px solid black; text-align:center;">Hari <br> Kerja</th>
                <th width="15" style="border: 1px solid black; text-align:center;">Tanpa <br> Keterangan</th>
                <th width="15" style="border: 1px solid black; text-align:center;">Total <br> Izin</th>
                <th width="15" style="border: 1px solid black; text-align:center;">Total <br> Telat Datang</th>
                <th width="15" style="border: 1px solid black; text-align:center;">Total <br> Cepat Pulang</th>
                <th width="15" style="border: 1px solid black; text-align:center;">Total <br> Kehadiran</th>
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
                        <td style="border: 1px solid black; text-align:center;">{{ $no++ }}</td>
                        <td style="border: 1px solid black; text-align:center;">&nbsp;&nbsp;{{ $value->nip }}</td>
                        <td style="border: 1px solid black; text-align:center;">&nbsp;&nbsp;{{ $value->name }}</td>
                        <td style="border: 1px solid black; text-align:center;">{{ $kehadiran['hari_kerja'] }}</td>
                        <td style="border: 1px solid black; text-align:center;">{{ $kehadiran['total_alfa'] }}</td>
                        <td style="border: 1px solid black; text-align:center;">{{ $kehadiran['total_izin'] }}</td>
                        <td style="border: 1px solid black; text-align:center;">{{ count($kehadiran['total_telat_datang']) }}</td>
                        <td style="border: 1px solid black; text-align:center;">{{ count($kehadiran['total_telat_pulang']) }}</td>
                        <td style="border: 1px solid black; text-align:center;">{{ number_indo($kehadiran['total_akhir'], 2) }} %</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>

</body>

</html>

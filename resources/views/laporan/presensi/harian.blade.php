<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Presensi Harian</title>
</head>
<body>
    <table>
        <tr>
            <td colspan="{{ $colspan }}" style="text-align: center">TANGGAL</td>
        </tr>
        <tr>
            <th>NO</th>
            <th>JABATAN</th>
            <th>NIP</th>
            <th>NAMA</th>
            @foreach ($tanggalAwalAkhir as $h)
            <th>{{ $h->format("F-d")}}</th>
            @endforeach
        </tr>
        @foreach ($data as $d)
        <tr>
            <td>{{ $d["jabatan"] }}</td>
            <td>{{ $d["nip"] }}</td>
            <td>{{ $d["nama_pegawai"] }}</td>
            @foreach ($tanggalAwalAkhir as $tanggal )
            <td>{{ $d["day_".$tanggal->format('d')] }}</td>
            @endforeach
            <td>{{ $d["rekap"] }}</td>
        </tr>
        @endforeach
    </table>
</body>
</html>

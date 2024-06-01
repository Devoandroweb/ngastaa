<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Excel</title>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>NIP</th>
                <th>Nama Lengkap</th>
                <th>Divisi Kerja</th>
                <th>Jabatan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($notPresent as $present)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $present->nip }}</td>
                    <td>{{ $present->fullname() }}</td>
                    <td>@php
                            $skpd = "-";
                            $jabatan = array_key_exists('0', $present->jabatan_akhir->toArray()) ? $present->jabatan_akhir[0] : null;
                            if($jabatan){
                                $skpd = $jabatan?->skpd?->nama;
                            }
                        @endphp
                        {{ $skpd }}
                    </td>
                    <td>
                        @php
                            $jabatan = array_key_exists('0', $present->jabatan_akhir->toArray()) ? $present->jabatan_akhir[0] : null;
                            $nama_jabatan = $jabatan?->tingkat?->nama;
                            $nama_jabatan = $nama_jabatan ?? "-";
                        @endphp
                        {{ $nama_jabatan }}

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>

@php
    $styleAlignMiddle = 'vertical-align: middle; text-align:center;';
    $GLOBALS['gajiUMK'] = $gajiUMK;



    function getDivisiAndJabatan($row){
        $result = ["-","-","-","-"];
        $jabatan = array_key_exists('0', $row->jabatan_akhir->toArray()) ? $row->jabatan_akhir[0] : null;
        if( $jabatan != null){
            $result[0] = $jabatan?->skpd?->nama; # Divisi
            $result[1] = ((is_null($jabatan->tingkat?->nama)) ? "-" : $jabatan->tingkat?->nama); # Jabatan
            $result[2] = $jabatan?->skpd?->code_city; # Divisi
            $result[3] = ((is_null($jabatan->tingkat?->kode_tingkat)) ? "-" : $jabatan->tingkat?->kode_tingkat); # Jabatan
        }
        return $result;
    }
    function takeSalaryByDivision($code_city){
        foreach ($GLOBALS['gajiUMK'] as $gaji) {
            if($gaji->kode_kabupaten == $code_city){
                return $gaji->nominal;
            }
        }
        return "-";
    }
@endphp
<table>
    <thead>
        <tr>
            <td rowspan="2" style="{{$styleAlignMiddle}}">No</td>
            <td rowspan="2" style="{{$styleAlignMiddle}}">NIP</td>
            <td rowspan="2" style="{{$styleAlignMiddle}}">Nama</td>
            <td rowspan="2" style="{{$styleAlignMiddle}}">Divisi</td>
            <td rowspan="2" style="{{$styleAlignMiddle.'width:0px;'}}">Kode Tingkat</td>
            <td rowspan="2" style="{{$styleAlignMiddle}}">Jabatan</td>
            <td rowspan="2" style="{{$styleAlignMiddle}}">Gaji Pokok *</td>
            <td colspan="{{$countTunjangan}}" style="{{$styleAlignMiddle}}">Tunjangan</td>
            <td rowspan="2" style="{{$styleAlignMiddle}}">Total Tunjangan</td>
            <td rowspan="2" style="{{$styleAlignMiddle}}">Total Penerimaan</td>
            <td colspan="{{$countPotongan}}" style="{{$styleAlignMiddle}}">Potongan</td>
            <td rowspan="2" style="{{$styleAlignMiddle}}">Total Potongan</td>
            <td rowspan="2" style="{{$styleAlignMiddle}}">Total Gaji</td>
        </tr>
        <tr>
            @foreach ($tunjangans as $item)
                <td>{{$item->nama}}</td>
            @endforeach
            @foreach ($potongans as $item)
                <td>{{$item->nama}}</td>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @php
            $startCoor = 0;
        @endphp
        @foreach ($pegawais as $pegawai)
            @php
                $startCoorTotalTujangan = $loop->iteration+2; # X/ROW
                $endCoorTotalTunjangan = ($countTunjangan+7); # Y/COL

                $row = ($loop->iteration+2);

                $startCellTunjangan = "H".$row;
                $endColTunjangan = $countTunjangan+7;
                $endCellTunjangan = excelCoordinate($row,($endColTunjangan));

                $sumTunjangan = "=SUM($startCellTunjangan:$endCellTunjangan)";

                $coorGajiPokok = "G".$row;
                $coorTotalTunjangan = excelCoordinate($startCoorTotalTujangan,$endCoorTotalTunjangan);
                $sumTotalPenerimaan = "=SUM($coorGajiPokok:$coorTotalTunjangan)";

                $startCellPotongan = excelColumn(($endColTunjangan+3)).$row;
                $endCellPotongan = excelCoordinate($row,(($endColTunjangan+2)+$countPotongan));

                $sumPotongan = "=SUM($startCellPotongan:$endCellPotongan)";

                $cellTotalPenerimaan = excelCoordinate($startCoorTotalTujangan,$endCoorTotalTunjangan+2);
                $cellTotalPotongan = excelCoordinate($startCoorTotalTujangan,(($endColTunjangan+3)+$countPotongan));
                $totalGaji = "=($cellTotalPenerimaan-$cellTotalPotongan)";
                // dd($totalGaji);
            @endphp
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$pegawai->nip}}</td>
                <td>{{$pegawai->name}}</td>
                <td>{{getDivisiAndJabatan($pegawai)[0]}}</td>
                <td>{{getDivisiAndJabatan($pegawai)[3]}}</td>
                <td>{{getDivisiAndJabatan($pegawai)[1]}}</td>
                <td></td>
                {{-- <td>{{takeSalaryByDivision(getDivisiAndJabatan($pegawai)[2])}}</td> --}}
                @foreach ($tunjangans as $item)
                <td></td>
                @endforeach
                <td>{{$sumTunjangan}}</td>
                <td>{{$sumTotalPenerimaan}}</td>
                @foreach ($potongans as $item)
                <td></td>
                @endforeach
                <td>{{$sumPotongan}}</td>
                <td>{{$totalGaji}}</td>
            </tr>
        @endforeach
    </tbody>
</table>

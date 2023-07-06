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
            <td colspan="{{$countBonus}}" style="{{$styleAlignMiddle}}">Insentif</td>
            <td rowspan="2" style="{{$styleAlignMiddle}}">Total Insentif</td>
            <td rowspan="2" style="{{$styleAlignMiddle}}">Total Penerimaan</td>
            <td colspan="{{$countPotongan}}" style="{{$styleAlignMiddle}}">Potongan</td>
            <td rowspan="2" style="{{$styleAlignMiddle}}">Total Potongan</td>
            <td rowspan="2" style="{{$styleAlignMiddle}}">Total Gaji</td>
        </tr>
        <tr>
            @foreach ($tunjangans as $item)
                <td>{{$item->nama}}</td>
            @endforeach
            @foreach ($bonus as $item)
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
                $row = ($loop->iteration+2);# X/ROW

                $coorGajiPokok = "G".$row;

                $startCellTunjangan = "H".$row;
                $endColTunjangan = $countTunjangan+7;# Y/COL
                $endCellTunjangan = excelCoordinate($row,($endColTunjangan));
                $manyColumnInTunjangan = $endColTunjangan+1;
                $sumTunjangan = "=SUM($startCellTunjangan:$endCellTunjangan)";
                $coorTotalTunjangan = excelCoordinate($row,$manyColumnInTunjangan);

                $startColBonus = $manyColumnInTunjangan+1;
                $endColBonus = $manyColumnInTunjangan+$countBonus;
                $startCellBonus = excelCoordinate($row,$startColBonus);
                $endCellBonus = excelCoordinate($row,$endColBonus);
                $manyColumnBonus = $endColBonus+1;
                $sumBonus = "=SUM($startCellBonus:$endCellBonus)";
                $coorTotalBonus = excelCoordinate($row,$manyColumnBonus);

                $sumTotalPenerimaan = "=$coorGajiPokok+$coorTotalBonus+$coorTotalTunjangan";
                $manyColumnPenerimaan = $manyColumnBonus+1;
                $coorTotalPenerimaan = excelCoordinate($row,$manyColumnPenerimaan);

                $startColPotongan = $manyColumnPenerimaan+1;
                $endColPotonngan = $manyColumnPenerimaan+$countPotongan;
                $startCellPotongan = excelCoordinate($row,$startColPotongan);
                $endCellPotongan = excelCoordinate($row,$endColPotonngan);
                $manyColumnPotongan = $endColPotonngan+1;
                $sumPotongan = "=SUM($startCellPotongan:$endCellPotongan)";
                $coorTotalPotongan = excelCoordinate($row,$manyColumnPotongan);

                $totalGaji = "=($coorTotalPenerimaan-$coorTotalPotongan)";
                // dd($sumTotalPenerimaan,$coorTotalPotongan);
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
                @foreach ($bonus as $item)
                <td></td>
                @endforeach
                <td>{{$sumBonus}}</td>
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

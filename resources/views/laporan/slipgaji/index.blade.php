<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Slip Gaji - {{ $payroll->nip }}</title>
    <style>
         @font-face {
            font-family: 'poppins'; //you can set your custom name also here..
            src: url({{ storage_path('fonts/Poppins.ttf') }}) format('truetype');
            font-weight: 400;
            font-style: normal;
         }
         @font-face {
            font-family: 'poppins-elight'; //you can set your custom name also here..
            src: url({{ storage_path('fonts/Poppins-ExtraLight.ttf') }}) format('truetype');
            font-weight: 400;
            font-style: normal;
         }
        *{
             padding: 0;
             margin: 0;
            font-family:'poppins';

        }
        .circle{
            background-color: #fff;
            height: 100px;
            width: 100px;
        }
        body{
            font-family: 'poppins';
            /* background-color: #0850A5; */
        }

        header{
            background-color: #0850A5;
            color: #fff;
            padding: 2rem;
            height: 230px;
            /* margin-bottom: rem; */
        }

        .logo{
            background: #fff;
            display: flex;
            align-items: center;
            width: 50px;
            height: 50px;
            padding: 5px;
            border-radius: 100%;

        }
        .logo img{
            width: 100%;
        }
        .h-left{
            /* float: left; */
            text-align: left;

        }
        .h-right{
            float: right;
            text-align: right;
        }
        p,small,table,.content,h1,h2,h3,h4{
            font-family:'poppins';
        }
        .content-main{
            /* position: relative; */
            width: 100%
        }
        .content{
            margin-top: -120px;
            background: #fff;
            text-align: center;
            border-radius:120px 0 0 0;
            border: #a50808;
            /* border-top: 10px solid #DBBA6B; */
            padding: 2rem;
            font-size: 12pt;
            position: relative;
            z-index: 1;

        }
        .card-line {
            position: absolute;
            top: -10px;
            height: 200px;
            width: 100%;
            border-top-left-radius: 120px;
            margin-top: 175px;
            /* border-top-right-radius: 0.5rem; */
            background: #DBBA6B;
            /* z-index: -111; */
        }
        .hr{
            /* border: 0.1px solid #D3D3D3; */
            height: 0.2px;
            width: 100%;
            background: #D3D3D3;
            margin: 1.5rem 0rem;
        }
        .table-main th{
            background: #DBBA6B;
            border: 1px solid #FFFFFF;
            color: #fff;
            padding: 0.5rem 1rem;
            font-family:'poppins';

        }
        .table-main td{
            padding: 1rem 1rem;
        }
        .table-main td ul li{
            margin-bottom: 2px;
            font-family:'poppins';
            /* font-weight: 100; */

        }
        .table-main td .title{
            font-family:'poppins';
            font-weight: 500;
        }
        .table-main td ul{
            margin-left: 1rem;
            margin-top: 2px;
            list-style-type: circle;
        }
        .table-main td ul li{
            width: 100%;
            /* background: red; */
        }
        .table-main tr:nth-child(1) td{
            background: #DBBA6B;
            border: 1px solid #FFFFFF;
            color: #fff;
            padding: .5rem 1rem .8rem 1rem !important;
            margin: 0;
            font-family:'poppins';
            font-weight: 500;
        }
        table{
            border-collapse: collapse;
            font-size: 10pt;
        }
    </style>
    </head>
    <body>
        @php
            $perusahan = getPerusahaan();
            // $kehadiran = kehadiran($payroll->nip, $payroll->bulan, $payroll->tahun);
            $persen_kehadiran = $payroll->persen_kehadiran;
        @endphp
        <header>
            <table width="100%" style="">
                <tr>
                    <td class="h-left">
                        <span class="logo">
                            <img src="{{url('public/'.$perusahan->logo)}}" alt="">
                        </span>
                    </td>
                    <td class="h-right">
                        <p style="font-size: 15pt;">{{ $perusahan->nama }}</p>
                        <p style="font-size: 10pt;">{{ $perusahan->alamat }}</p>
                    </td>
                </tr>
            </table>
            <h1>Invoice</h1>
        </header>
        <div class="content-main">
            <div class="card-line" height="200px" width="100%"></div>
            <div class="content">
                <table width="100%">
                    <tr>
                        <td width="50%" rowspan="3">
                            <center>
                                <small>No Invoice</small>
                                <h3 style="margin-top: 5px;font-family: poppins;font-weight: 600;">{{$payroll->kode_payroll}}</h3>
                            </center>
                        </td>
                        <td width="10%">NIP</td>
                        <td width="2%">:</td>
                        <td width="28%">{{ $payroll->nip }}</td>
                    </tr>
                    <tr>
                        <td width="10%">Nama</td>
                        <td width="2%">:</td>
                        <td width="15%">{{ $payroll->user?->name }}</td>
                    </tr>
                    <tr>
                        <td width="10%">Status</td>
                        <td width="2%">:</td>
                        <td width="15%">{!! is_aktif($payroll->is_aktif) !!}</td>
                    </tr>
                </table>
                <div class="hr"></div>
                <table width="100%" style="margin-bottom: 1.5rem">
                    <tr>
                        <td widht="15%">Divisi Kerja</td>
                        <td width="2%">:</td>
                        <td width="83%">{{ $payroll->divisi }}</td>
                    </tr>
                    <tr>

                        <td>Jabatan</td>
                        <td width="2%">:</td>
                        <td>{{ $payroll->jabatan }}</td>
                    </tr>
                    <tr>

                        <td>Tanggal</td>
                        <td width="2%">:</td>
                        <td>{{ bulan($payroll->bulan)." - ".$payroll->tahun }}</td>
                    </tr>
                </table>
                <table class="table-main" width="100%;">
                    <tr>
                        <td width="50%">Deskripsi</td>
                        <td style="text-align: center;">Nominal</td>
                        <td style="text-align: center;">Total</td>
                    </tr>
                    <tr style="border-bottom: 1px solid #D3D3D3;">
                        <td colspan="2">
                            <div class="title" style="font-family: poppins">Gaji Pokok <span style="float:right;">Rp. {{ number_indo($payroll->gaji_pokok) }}</span></div>
                            <ul style="list-style: none">
                                <li>Kehadiran  <span style="float:right;">{{ number_indo($persen_kehadiran) }} %</span></li>
                            </ul>
                        </td>
                        <td style="text-align: right;">
                            <div style="font-family: poppins;font-weight: 600;float:right;">Rp. {{ number_indo($payroll->gaji_pokok) }}</div>
                        </td>
                    </tr>
                    @if(count($penambahan) != 0)
                    <tr style="border-bottom: 0.1px solid #D3D3D3 !important;">
                        <td colspan="2">
                            <div class="title" style="font-family: poppins">Tunjangan</div>
                            <ul>
                                @foreach ($penambahan as $tambah)
                                <li>{{ $tambah->keterangan }} <span style="float:right;">Rp. {{ number_indo($tambah->nilai) }}</span></li>
                                @endforeach
                            </ul>
                        </td>
                        <td style="text-align: right;">
                            <div style="font-family: poppins;font-weight: 600;">Rp. {{ number_indo($payroll->total_penambahan) }}</div>
                        </td>
                    </tr>
                    @endif
                    @if(count($potongan) != 0)
                    <tr style="">
                        <td colspan="2">
                            <div class="title" style="font-family: poppins">Potongan</div>
                            <ul>
                                @foreach ($potongan as $potong)
                                <li>{{ $potong->keterangan }} <span style="float:right;">Rp. {{ number_indo($potong->nilai) }}</span></li>
                                @endforeach
                            </ul>
                        </td>
                        <td style="text-align: right;">
                            <div style="font-family: poppins;font-weight: 600;">Rp. {{ number_indo($payroll->total_potongan) }}</div>
                        </td>
                    </tr>
                    @endif
                </table>
                <table class="total" width="100%;">
                    <tr>
                        <td class="terbilang" width="50%" style="padding:1rem">
                            <div style="font-family: poppins;font-weight: 600;">Terbilang :</div>
                            <div style="font-family: poppins;font-style: italic;">{{ terbilang($payroll->total) }}</div>
                        </td>
                        <td class="sum-total" style="
                            padding:1rem 0rem 1rem 1rem;">
                            <div class="gaji-bersih"  style="font-family: poppins;font-weight: 600;text-align: right;
                            border-left:1px dashed black;
                            border-top:1px dashed black;
                            border-bottom:1px dashed black;
                            padding:1rem 1rem 1.5rem 1rem;">
                                GAJI BERSIH
                            </div>
                        </td>
                        <td style="padding:1rem 0rem 1rem 0rem;">
                            <div class="gaji-bersih-nominal" style="font-family: poppins;font-weight: 600;text-align: right;
                            border-right:1px dashed black;
                            border-top:1px dashed black;
                            border-bottom:1px dashed black;
                            padding:1rem 1rem 1.5rem 1rem;">
                                Rp. {{ number_indo($payroll->total) }}
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </body>
</html>

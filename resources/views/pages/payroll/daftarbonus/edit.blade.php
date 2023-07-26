@extends('app')
@section('breadcrumps')
    <h2 class="pg-title">Edit Daftar Bonus</h2>
    {{ Breadcrumbs::render('edit-daftar-bonus') }}
@endsection
@section('content')
<form class="edit-post-form" action="{{route('payroll.bonus.store')}}" method="post">
    @if($bonus != null)
        <input type="hidden" name="id" value="{{$bonus->id}}">
    @endif
    @csrf
    <div class="row">
        <div class="col-md-6">
            <div class="form-group has-validation">
                <label class="form-label">Komponen</label>
                <select class="form-control komponen" name="kode_bonus" required>
                    @foreach (\App\Models\Master\Payroll\Tambahan::orderBy('nama')->get() as $item)
                        @if($bonus->kode_bonus == $item->kode_tambah)
                            <option selected value="{{$item->kode_tambah}}">{{$item->nama}}</option>
                        @else
                            <option value="{{$item->kode_bonus}}">{{$item->nama}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group has-validation">
                <label class="form-label">Periode</label>
                <select class="form-control periode" name="is_periode" required>

                    @if($bonus->is_periode == 0)
                    <option selected value="0">Selamanya</option>
                    <option value="1">Periode Tertentu</option>
                    @else
                    <option  value="0">Selamanya</option>
                    <option selected value="1">Periode Tertentu</option>
                    @endif
                </select>
            </div>
        </div>
    </div>
    <div class="element-periode"></div>
    <div class="form-group">
        <label class="form-label">Untuk</label>
        <select class="form-control keterangan" name="keterangan" required>
            {!! GenerateKetarangan($bonus->keterangan) !!}
        </select>
    </div>
    <div class="element-keterangan"></div>
    {{-- {{dd("sadasd")}} --}}
    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="{{route('payroll.bonus.index')}}" class="btn btn-light">Kembali</a>
</form>
@php
// dd($bonus);
function searchId($id,$data)
{
    $data = explode(",",$data);
    foreach ($data as $item):
    if((int)$item == $id):
            // dd($id);
            return true;
        endif;
    endforeach;
    return false;
}
@endphp
@endsection
@push('js')
    <script>
        var buildKomponen = "{!!includeAsJsString('pages/payroll/daftarbonus/element-periode',$bonus)!!}";
        var buildPegawai = "{!!includeAsJsString('pages/payroll/daftarbonus/element-pegawai',$bonus->kode_keterangan)!!}";
        var buildJabatan = "{!!includeAsJsString('pages/payroll/daftarbonus/element-jabatan',$bonus->kode_keterangan)!!}";
        var buildEselon = "{!!includeAsJsString('pages/payroll/daftarbonus/element-eselon',$bonus->kode_keterangan)!!}";
        var buildSkpd = "{!!includeAsJsString('pages/payroll/daftarbonus/element-divisi',$bonus->kode_keterangan)!!}";
        // console.log(buildPegawai);
        $('.komponen').select2({
            // minimumInputLength: 2,
            placeholder: "Ketikkan Komponen Potongan",
        })

        $(".periode").select2();
        $(".keterangan").select2();
        showKomponenKeterangan(parseInt('{{$bonus->keterangan}}'))
        showKomponenPeriode(parseInt('{{$bonus->is_periode}}'))

        $('.periode').change(function (e) {
            e.preventDefault();
            console.log($(this).val())
            var val = $(this).val()
            showKomponenPeriode(val)
        });
        $('.keterangan').change(function (e) {
            e.preventDefault();
            console.log($(this).val())
            var val = $(this).val()
            showKomponenKeterangan(val)
        });
        function showKomponenPeriode(val){
            if(val == 1){
                $('.element-periode').html(buildKomponen);
                $("#bulan").select2();
                $("#tahun").select2();
            }else{
                $('.element-periode').empty();
            }
        }
        function showKomponenKeterangan(val){
            if(val == 1){
                $('.element-keterangan').html(buildPegawai);
                $(".pegawai").select2({
                    allowClear: true
                });
            }else if(val == 2){
                $('.element-keterangan').html(buildJabatan);
                $(".tingkat-jabatan").select2();
            }else if(val == 3){
                $('.element-keterangan').html(buildEselon);
                $(".eselon").select2();
            }else if(val == 4){
                $('.element-keterangan').html(buildSkpd);
                $(".skpd").select2();
            }else{
                $('.element-keterangan').empty();
            }
        }
    </script>

@endpush
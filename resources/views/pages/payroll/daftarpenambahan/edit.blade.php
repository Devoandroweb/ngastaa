@extends('app')
@section('breadcrumps')
    <h2 class="pg-title">Edit Daftar Penambahan</h2>
    {{ Breadcrumbs::render('edit-daftar-penambahan') }}
@endsection
@section('content')
<form class="edit-post-form" action="{{route('payroll.tambah.store')}}" method="post">
    @if($tambah != null)
        <input type="hidden" name="id" value="{{$tambah->id}}">
    @endif
    @csrf
    <div class="row">
        <div class="col-md-6">
            <div class="form-group has-validation">
                <label class="form-label">Komponen</label>
                <select class="form-control komponen" name="kode_tambah" required>
                    @foreach (\App\Models\Master\Payroll\Tunjangan::orderBy('nama')->get() as $item)
                        @if($tambah->kode_tambah == $item->kode_tunjangan)
                            <option selected value="{{$item->kode_tunjangan}}">{{$item->nama}}</option>
                        @else
                            <option value="{{$item->kode_tunjangan}}">{{$item->nama}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group has-validation">
                <label class="form-label">Periode</label>
                <select class="form-control periode" name="is_periode" required>

                    @if($tambah->is_periode == 0)
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
            {!! GenerateKetarangan($tambah->keterangan) !!}
        </select>
    </div>
    <div class="element-keterangan"></div>
    {{-- {{dd("sadasd")}} --}}
    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="{{route('payroll.tambah.index')}}" class="btn btn-light">Kembali</a>
</form>
@php
// dd($tambah);
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
        var buildKomponen = "{!!includeAsJsString('pages/payroll/daftarpenambahan/element-periode',$tambah)!!}";
        var buildPegawai = "{!!includeAsJsString('pages/payroll/daftarpenambahan/element-pegawai',$tambah->kode_keterangan)!!}";
        var buildJabatan = "{!!includeAsJsString('pages/payroll/daftarpenambahan/element-jabatan',$tambah->kode_keterangan)!!}";
        var buildEselon = "{!!includeAsJsString('pages/payroll/daftarpenambahan/element-eselon',$tambah->kode_keterangan)!!}";
        var buildSkpd = "{!!includeAsJsString('pages/payroll/daftarpenambahan/element-divisi',$tambah->kode_keterangan)!!}";
        console.log(buildPegawai);
        $('.komponen').select2({
            // minimumInputLength: 2,
            placeholder: "Ketikkan Komponen Potongan",
        })

        $(".periode").select2();
        $(".keterangan").select2();
        showKomponenKeterangan(parseInt('{{$tambah->keterangan}}'))
        showKomponenPeriode(parseInt('{{$tambah->is_periode}}'))

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

@extends('app')
@section('breadcrumps')
    <h2 class="pg-title">Daftar Potongan</h2>
    {{ Breadcrumbs::render('tambah-daftar-pengurangan') }}
@endsection
@section('content')
<form class="edit-post-form" action="{{route('payroll.kurang.store')}}" method="post">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <div class="form-group has-validation">
                <label class="form-label">Komponen</label>
                <select class="form-control komponen" name="kode_kurang" required>
                    
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group has-validation">
                <label class="form-label">Periode</label>
                <select class="form-control periode" name="is_periode" required>
                    <option value="0">Selamanya</option>
                    <option value="1">Periode Tertentu</option>
                </select>
            </div>
        </div>
    </div>
    <div class="element-periode"></div>
    <div class="form-group">
        <label class="form-label">Untuk</label>
        <select class="form-control keterangan" name="keterangan" required>
            {!! GenerateKetarangan() !!}
        </select>
    </div>
    <div class="element-keterangan"></div>
    
    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="{{route('payroll.kurang.index')}}" class="btn btn-light">Kembali</a>
</form>
@php
function searchId($id,$data)
{
    foreach ($data as $item):
        if($item['id'] == $id):
            return true;
        endif;
    endforeach;
    return false;
}    
@endphp
@endsection
@push('js')
    <script>
        var buildKomponen = "{!!includeAsJsString('pages/payroll/daftarpengurangan/element-periode')!!}";
        var buildPegawai = "{!!includeAsJsString('pages/payroll/daftarpengurangan/element-pegawai')!!}";
        var buildJabatan = "{!!includeAsJsString('pages/payroll/daftarpengurangan/element-jabatan')!!}";
        var buildEselon = "{!!includeAsJsString('pages/payroll/daftarpengurangan/element-eselon')!!}";
        var buildSkpd = "{!!includeAsJsString('pages/payroll/daftarpengurangan/element-divisi')!!}";
        var komponen = $('.komponen');
        $('.komponen').select2({
            ajax: {
                url: "{{route('master.payroll.pengurangan.json')}}",
                processResults: function (data) {
                    console.log(data);
                    
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: item['label'],
                                id: item['kode_kurang']
                            }
                        })
                    };
                }
            },
            
        });
        

        $(".periode").select2();
        $(".keterangan").select2();
        
        $('.periode').change(function (e) { 
            e.preventDefault();
            console.log($(this).val())
            if($(this).val() == 1){
                $('.element-periode').html(buildKomponen);
                $("#bulan").select2();
                $("#tahun").select2();
            }else{
                $('.element-periode').empty();
            }
        });
        $('.keterangan').change(function (e) { 
            e.preventDefault();
            console.log($(this).val())
            if($(this).val() == 1){
                $('.element-keterangan').html(buildPegawai);
                $(".pegawai").select2({
                    allowClear: true
                });
            }else if($(this).val() == 2){
                $('.element-keterangan').html(buildJabatan);
                $(".tingkat-jabatan").select2();
            }else if($(this).val() == 3){
                $('.element-keterangan').html(buildEselon);
                $(".eselon").select2();
            }else if($(this).val() == 4){
                $('.element-keterangan').html(buildSkpd);
                $(".skpd").select2();
            }else{
                $('.element-keterangan').empty();
            }
        });
    </script>
@endpush

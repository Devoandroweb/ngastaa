@extends('app')
@section('breadcrumps')
    <h2 class="pg-title">Generate Payroll</h2>
    {{ Breadcrumbs::render('tambah-generate-payroll') }}
@endsection
@section('content')
@if(session('messages'))
<div class="alert alert-inv alert-inv-@if(session('type') == 'error'){{'danger'}}@else{{'success'}}@endif alert-wth-icon alert-dismissible fade show" role="alert">
	<span class="alert-icon-wrap"><i class="zmdi @if(session('type') == 'error') {{'zmdi-bug'}}  @else {{'zmdi-check-circle'}} @endif "></i></span> {{session('messages')}}
	<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
<form class="edit-post-form" action="{{route('payroll.generate.store')}}" method="post">
    @csrf
    <div class="row">
        <div class="form-group has-validation">
            <label class="form-label">Pilih Divisi Kerja</label>
            <p class="text-danger mb-2">*Kosongkan Jika ingin Generate Semua Pegawai</p>
            <select class="form-control select2" name="kode_skpd" id="divisi">
                <option selected disabled>Select Divisi Kerja</option>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="form-group has-validation">
            <label class="form-label">Pilih Bulan</label>
            <select class="form-control select2" name="bulan" required>
                {!!GenerateOptionMont()!!}
            </select>
        </div>
    </div>
    <div class="row">
        <div class="form-group has-validation">
            <label class="form-label">Pilih Tahun</label>
            <select class="form-control select2" name="tahun" required>
                <option selected disabled>Select Tahun</option>
                {!!GenerateOptionYear()!!}
            </select>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="{{route('payroll.generate.index')}}" class="btn btn-light">Kembali</a>
</form>
@endsection

@push('js')
<script>
    $('#divisi').select2({
        minimumInputLength: 2,
        placeholder: "Pilih Divisi Kerja",
        language : {
            inputTooShort: function () {
                return "Masukkan minimal 2 karakter";
            }
        },
        ajax : {                
            url : "{{route('master.skpd.json')}}",
            dataType : 'JSON',                
            type : 'GET',                
            quietMillis: 50,                
                processResults: function (data) {                    
                    console.log(data);                    
                    return {                        
                        results: $.map(data, function (item) {                            
                            return {                                
                                text: item['label'],                                
                                id: item['kode_skpd']                            
                            }                        
                        })                    
                    };                
                }            
            }        
    }).val("").trigger("change");
</script>
    
@endpush

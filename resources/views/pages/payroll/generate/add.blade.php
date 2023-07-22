@extends('app')
@section('breadcrumps')
    <h2 class="pg-title">Generate Payroll</h2>
    {{ Breadcrumbs::render('tambah-generate-payroll') }}
@endsection
@section('content')
<style>
    .lottie-anima{
        width: 100%;
        height: 100vh;
        position: fixed;
        top: 0;
        right: 0;
        background: #fff;
        z-index: 99999;
        display: flex;
    }
    .lottie-anima .body{
        margin: 200px auto;
    }
</style>
@if(session('messages'))
<div class="alert alert-inv alert-inv-@if(session('type') == 'error'){{'danger'}}@else{{'success'}}@endif alert-wth-icon alert-dismissible fade show" role="alert">
	<span class="alert-icon-wrap"><i class="zmdi @if(session('type') == 'error') {{'zmdi-bug'}}  @else {{'zmdi-check-circle'}} @endif "></i></span> {{session('messages')}}
	<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
<form class="form" action="" method="post">
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
    <button type="submit" class="btn btn-primary btn-save">Simpan</button>
    <a href="{{route('payroll.generate.index')}}" class="btn btn-light">Kembali</a>
</form>
<script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
<div class="lottie-anima" style="display: none">
{{-- <div class="lottie-anima"> --}}
    <div class="body">
        <lottie-player src="{{asset('../assets/json/payroll.json')}}" background="Transparent" speed="1" style="width: 400px; height: 400px" direction="1" mode=“normal” loop autoplay></lottie-player>
        <p class="mt-5 mb-2 text-center">Sedang membuat Gaji, mohon tunggu ...</p>
        <div class="progress progress-bar-rounded mb-5">
            <div class="progress-bar bg-primary"  id="progress-bar" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
    </div>
</div>
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
    var perc = 1;
    var ElprogressBar = $('#progress-bar');
    // progressBar80()

    $(".btn-save").click(function (e) {
        perc = 0;
        e.preventDefault();
        $(".lottie-anima").show();
        progressBar80()
        $.ajax({
            method:"post",
            url: "{{route('payroll.generate.store')}}",
            data: $(".form").serialize(),
            success:function(response){
                progressBar100()
            },
            error:function(response){
                $(".lottie-anima").hide();
                showAlert("Gagal membuat payroll",'error')
            }
        })
    });
    var progressInterval = null
    var progress80 = () => {
        if(perc < 80){
            perc += 1;
            ElprogressBar.text(perc+'%');
            ElprogressBar.attr('aria-valuenow',perc);
            ElprogressBar.css('width',perc+'%');
        }else{
            clearInterval(progressInterval);
        }
    }
    var progress100 = () => {
        if(perc <= 100){
            perc += 1;
            ElprogressBar.text(perc+'%');
            ElprogressBar.attr('aria-valuenow',perc);
            ElprogressBar.css('width',perc+'%');
        }else{
            $(".lottie-anima").hide();
            clearInterval(progressInterval);
            showAlert("Sukses membuat Payroll",'success');
        }
    }
    function progressBar80(){
        progressInterval = setInterval(() => {
            progress80();
        }, 300);
    }
    function progressBar100(){
        progressInterval = setInterval(() => {
            progress100();
        }, 10);
    }
    function showAlert(msg,type){
        Swal.fire(
          'Payroll Generate',
          msg,
          type
        )
    }
</script>

@endpush

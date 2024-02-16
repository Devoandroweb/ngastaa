<div id="change-pegawai" class="pb-4 sticky-top bg-white" @style("display:none")>
    <form id="form-update">
        <h4>Ubah Pegawai</h4>
        <div class="row mb-2">
            @include('komponen.select.divisi-tingkat-jabatan')
            <div class="col">
                @include('komponen.select.lokasi-kerja')
            </div>
            <div class="col">
                @include('komponen.select.jam-kerja')
            </div>
            <div class="col">
                @include('komponen.select.status-pegawai')
            </div>
        </div>
    </form>
    <button id="save-update" type="button" class="btn btn-info" disabled>Simpan</button>
</div>
@push('js')
    <script>
        $(".lokasiKerja").select2({
            placeholder:"Pilih Lokasi Kerja",
            allowClear: true,
        }).val("").change()
        $(".jamKerja").select2({
            placeholder:"Pilih Jam Kerja",
            allowClear: true,
        }).val("").change()
        $(".statusPegawai").select2({
            placeholder:"Pilih Status Pegawai",
            allowClear: true,
        }).val("").change()
        /* CHECKBOX NIP */
        $("#check-all").click(function (e) {
            // e.preventDefault();
            if($(this).is(':checked')){
                $(".checkbox-nip").prop('checked',true)
                $("#save-update").prop('disabled',false)
            }else{
                $("#save-update").prop('disabled',true)
                $(".checkbox-nip").prop('checked',false)
            }
        });
        $(document).on("click",".checkbox-nip",function (e) {

            var sumElCheckNip = $(".checkbox-nip").length
            var sumElCheckedNip = $(".checkbox-nip:checked").length
            if(sumElCheckNip == sumElCheckedNip){
                $("#check-all").prop('checked',true)
            }else{
                $("#check-all").prop('checked',false)
            }
            if(sumElCheckedNip == 0){
                $("#save-update").prop('disabled',true)
            }else{
                $("#save-update").prop('disabled',false)
            }
        });
        $("#save-update").click(function (e) {
            e.preventDefault();
            // console.log($("[name=kode_tingkat]").val());
            // return;
            // if($("[name=kode_tingkat]").val() == null){
            //     iziToast.error({
            //         title: 'Error',
            //         message: "Divisi Kerja harus di pilih",
            //         position: 'bottomRight'
            //     });
            //     return;
            // }
            var btn = $(this);
            var rollbackBtn = btn.html();
            btn.html(`<div class="spinner-border spinner-border-sm" role="status">
                <span class="visually-hidden">Loading...</span>
            </div> Tunggu sebentar ...`)
            var nip = $(".checkbox-nip:checked");
            var dataNip = [];
            for (let index = 0; index < nip.length; index++) {
                const element = nip[index];
                dataNip.push($(element).val())
            }

            $.ajax({
                type: "POST",
                url: "{{route('pegawai.pegawai.update-kepegawaian')}}",
                data: $("#form-update").serialize()+"&nip="+dataNip.join(","),
                dataType: "JSON",
                success: function (response) {
                    iziToast.success({
                        title: 'Success',
                        message: response.message,
                        position: 'bottomRight'
                    });
                    btn.html(rollbackBtn)
                    _TABLE.ajax.reload()

                },
                error : function (response){
                    // console.log(response.responseJSON.message);
                    iziToast.error({
                        title: 'Error',
                        message: response.responseJSON.message,
                        position: 'bottomRight'
                    });

                }
            });
        });
        window.addEventListener('scroll', function() {
            var changePegawai = document.getElementById('change-pegawai');
            var scrollTop = window.pageYOffset || document.documentElement.scrollTop;

            if (scrollTop > 320) {
                $("#change-pegawai").css({paddingTop:"6rem"})
                $("#change-pegawai").css({scale:"1"})
                $("#change-pegawai").addClass("shadow")
                $("#change-pegawai").addClass("px-4")
            } else {
                $("#change-pegawai").css({paddingTop:"0rem"})
                $("#change-pegawai").removeClass("shadow")
                $("#change-pegawai").removeClass("px-4")
            }
            })
    </script>
@endpush

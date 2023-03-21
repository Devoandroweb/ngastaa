"user strict"
$(document).on('click','.approv', function (e) {
    e.preventDefault();
    var approv = $(this);
    Swal.fire({
        html:
        '<div class="mb-3"><i class="ri-check-double-fill fs-5 text-success"></i></div><h5 class="text-success">Apakah anda yakin menerima data ini?</h5><p>Mohon diperhatikan kembali!.</p>',
        customClass: {
            confirmButton: 'btn btn-outline-secondary text-success',
            cancelButton: 'btn btn-outline-secondary text-gray',
            container:'swal2-has-bg'
        },
        icon: 'success',
        showCancelButton: true,
        buttonsStyling: false,
        confirmButtonText: 'Ya',
        cancelButtonText: 'Tidak',
        reverseButtons: true,

    }).then((result) => {
        console.log(result)
        if (result.value) {
                redirect(approv.attr("href"));
        }
    })
    
});
$(document).on('click','.reject', function (e) {
    e.preventDefault();
    var rejectE = $(this);
    Swal.fire({
        // title: '<strong>Masukkan Alasan Penolakan</strong>',
        customClass: {
            confirmButton: 'btn btn-outline-secondary text-danger',
            cancelButton: 'btn btn-outline-secondary text-gray',
            container:'swal2-has-bg',
            input:'m-auto w-90 d-block mt-2 comment'
        },
        input: 'textarea',
        inputLabel: 'Masukkan Alasan Penolakan',
        inputPlaceholder: 'Masukkan Alasan Penolakan ...',
        inputAttributes: {
            'aria-label': 'Tulis Disini'
        },
        showCancelButton: true,
        buttonsStyling: false,
        confirmButtonText: 'Ya',
        cancelButtonText: 'Tidak',
        reverseButtons: true,
        preConfirm: (result) => {
            const comment = Swal.getPopup().querySelector('.comment').value
            if (!comment) {
                Swal.showValidationMessage('Komentar Harap di isi')
            }
        }

    }).then((result) => {
        if(result.value){
            console.log(result)
            redirect(rejectE.attr("href")+"?komentar="+result.value);
        }
        
    })
    
});
$(document).on('click','.log', function (e) {
    e.preventDefault();
    $.ajax({
        type: "get",
        url: $(this).attr('href'),
        dataType: "json",
        success: function (response) {
            logHtml(response)
        }
    });
});
function logHtml(response){
    Swal.fire({
        title: '<strong>Log Pengajuan</strong>',
        html:
            buildLogHtml(response),
        customClass: {
            confirmButton: 'btn btn-outline-secondary text-danger',
            cancelButton: 'btn btn-outline-secondary text-gray',
            container:'swal2-has-bg'
        },
        showCancelButton: false,
        buttonsStyling: false,
        reverseButtons: true,
        confirmButtonText:'Tutup',
    })
}
function buildLogHtml(response){
    var htmlLog = `<div id="todo_collapse_3" class="collapse show">
        <div class="card-body">
            <ul id="todo_list_2" class="advance-list">`;
                response.forEach(row => {
                    htmlLog += `<li class="advance-list-item single-task-list">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                    <div>	
                                        <div class="avatar avatar-xs avatar-rounded d-md-inline-block d-none">
                                        <img src="${row.foto}" alt="user" class="avatar-img">
                                    </div>
                                    <span class="badge badge-warning badge-indicator"></span>
                                    <small class="todo-text text-dark text-truncate">Oleh : ${row.user}</small>
                                </div>
                            </div>	
                            <div class="d-flex flex-shrink-0 align-items-center ms-3">
                                <small class="todo-time d-lg-inline-block d-none text-danger me-3">${row.tanggal}</small>
                                ${row.action}
                            </div>
                        </div>	
                    </li>`
                });
    htmlLog += `</ul>
        </div>
    </div>`;
    return htmlLog;
}
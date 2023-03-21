$(document).on("click",".delete", function (e) {
    e.preventDefault();
    Swal.fire({
        html:
        '<div class="mb-3"><i class="ri-delete-bin-6-line fs-5 text-danger"></i></div><h5 class="text-danger">Yakin ingin menghapus data ini?</h5><p>Data tidak dapat dikembalikan!.</p>',
        customClass: {
            confirmButton: 'btn btn-outline-secondary text-danger',
            cancelButton: 'btn btn-outline-secondary text-gray',
            container:'swal2-has-bg'
        },
        showCancelButton: true,
        buttonsStyling: false,
        confirmButtonText: 'Ya',
        cancelButtonText: 'Tidak',
        reverseButtons: true,
    }).then((result) => {
        console.log("tyaa "+result.value);
        if (result.value) {
            window.location.href = $(this).attr('href');
        }
    })
});
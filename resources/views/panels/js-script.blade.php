<!-- jQuery -->
    <script src="{{asset('/')}}vendors/jquery/dist/jquery.min.js"></script>
	<script src="{{asset('/')}}vendors/jquery-toast-plugin/dist/jquery.toast.min.js"></script>

    <!-- Bootstrap Core JS -->
	<script src="{{asset('/')}}vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

	<!-- Amcharts Maps JS -->
	<script src="{{asset('/')}}vendors/@amcharts/amcharts4/core.js"></script>
	<script src="{{asset('/')}}vendors/@amcharts/amcharts4/maps.js"></script>
	<script src="{{asset('/')}}vendors/@amcharts/amcharts4-geodata/worldLow.js"></script>
	<script src="{{asset('/')}}vendors/@amcharts/amcharts4-geodata/worldHigh.js"></script>
	<script src="{{asset('/')}}vendors/@amcharts/amcharts4/themes/animated.js"></script>

	<!-- Apex JS -->
	<script src="{{asset('/')}}vendors/apexcharts/dist/apexcharts.min.js"></script>

    <!-- FeatherIcons JS -->
    <script src="{{asset('/')}}dist/js/feather.min.js"></script>

    <!-- Fancy Dropdown JS -->
    <script src="{{asset('/')}}dist/js/dropdown-bootstrap-extended.js"></script>

	<!-- Simplebar JS -->
	<script src="{{asset('/')}}vendors/simplebar/dist/simplebar.min.js"></script>

	<!-- Data Table JS -->
    <script src="{{asset('/')}}vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="{{asset('/')}}vendors/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
	<script src="{{asset('/')}}vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
	<script src="{{asset('/')}}vendors/datatables.net-select/js/dataTables.select.min.js"></script>
	<script src="{{asset('/')}}vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>

    <script src=https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js></script>
    <script src=https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js></script>
    <script src=https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js></script>
    <script src=https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js></script>
    <script src=https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js></script>

	<!-- Daterangepicker JS -->
    <script src="{{asset('/')}}vendors/moment/min/moment.min.js"></script>
	<script src="{{asset('/')}}vendors/daterangepicker/daterangepicker.js"></script>
	<script src="{{asset('/')}}dist/js/daterangepicker-data.js"></script>


	<!-- Amcharts Maps JS -->
	<script src="{{asset('/')}}vendors/@amcharts/amcharts4/core.js"></script>
	<script src="{{asset('/')}}vendors/@amcharts/amcharts4/maps.js"></script>
	<script src="{{asset('/')}}vendors/@amcharts/amcharts4-geodata/worldLow.js"></script>
	<script src="{{asset('/')}}vendors/@amcharts/amcharts4-geodata/worldHigh.js"></script>
	<script src="{{asset('/')}}vendors/@amcharts/amcharts4/themes/animated.js"></script>
	<script src="{{asset('/')}}vendors/sweetalert2/dist/sweetalert2.min.js"></script>
	<script src="{{asset('/')}}vendors/leaflet/leaflet.js"></script>
	<script src="{{asset('/')}}vendors/izitoast/js/iziToast.min.js"></script>
	
	<script src="{{asset('/')}}vendors/fullcalendar/main.min.js"></script>

	<!-- Init JS -->
	<script src="{{asset('/')}}dist/js/init.js"></script>

	<script src="{{asset('/')}}autoNumeric.js"></script>
	<script src="{{asset('/')}}custom.js"></script>
	<script src="{{asset('/')}}component.js"></script>
	<script src="{{asset('/')}}clock.js"></script>


	<script src="{{asset('/')}}vendors/select2/dist/js/select2.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js" integrity="sha512-ozq8xQKq6urvuU6jNgkfqAmT7jKN2XumbrX1JiB3TnF7tI48DPI4Gy1GXKD/V3EExgAs1V+pRO7vwtS1LHg0Gw==" crossorigin="anonymous" referrerpolicy="no-referrer" ></script>;
	<script>
		$(".select2").select2();
		setNumeric();

		$(".btn-calculate-presensi").click(function(e){
			e.preventDefault();
			var contentDefault = $(this).html()
			var contentLoading = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
									Menghitung...`;
			var el = $(this)
			el.html(contentLoading)
			el.attr('disabled','disabled')
			$.ajax({
				type: "get",
				url: el.attr('href'),
				success: function (response) {
					if(response.status){
						Swal.fire({
							title: '<strong>Berhasil !!</strong>',
							icon: 'success',
							html: response.message
						})
					}else{
						Swal.fire({
							title: '<strong>Gagal !!</strong>',
							icon: 'error',
							html: `<span class="text-danger">${response.message}</span>`
						})
					}
					el.html(contentDefault)
					el.removeAttr('disabled')
                    if(_TABLE_REKAP_HARIAN !== undefined){
                        // _TABLE_REKAP_HARIAN.ajax.reload();
                    }
				},
                error:function(response){
                    el.html(contentDefault)
					el.removeAttr('disabled')
                    console.log(response.responseJSON)
                    Swal.fire({
                        title: '<strong>'+response.responseJSON.message+'</strong>',
                        icon: 'error',
                    })

                }
			});
		})
	</script>

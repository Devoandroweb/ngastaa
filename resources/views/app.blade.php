@include('panels.header')
<style>
	.bottom-right{
		position: fixed;
		right: 35%;
		bottom: 75px;
	}
	.select2-selection .select2-selection--multiple{
		padding: 5px 10px !important;
	}

	ul .sub2menu::before {
		content: "";
		width: 1px;
		height: calc(100% - 45px);
		position: absolute;
		left: 50px;
		top: 20px;
		bottom: 0;
		margin: auto;
		background: #d2d2d2;
	}
	.sub2menu .nav-item .nav .nav-item .nav-link{
		padding-left:3.8rem !important;
	}
	.hk-wrapper[data-layout="vertical"] .hk-menu .menu-content-wrap .menu-group .navbar-nav .nav-item .nav-link .nav-icon-wrap > *:not(.badge) {
		font-size: 1.3rem !important;
	}
	.cursor-pointer{
		cursor:pointer !important;
	}
</style>
<body>
	@php
		$perusahaan = \App\Models\Perusahaan::first();
	@endphp
   	<!-- Wrapper -->
	<div class="hk-wrapper" data-layout="vertical" data-layout-style="default" data-menu="light" data-footer="simple">
		@include('panels.navbar')
		@include('panels.sidebar')
		<!-- Main Content -->
		<div class="hk-pg-wrapper">
			<div class="container-fluid px-4">
				@include('panels.content')
			</div>
            @include('panels.footer')
		</div>
		<!-- /Main Content -->
	</div>
    <!-- /Wrapper -->

	@include('panels.js-script')
	<script>
        $(document).ready(function() {
            $('input').on('keypress', function (event) {
                var regex = new RegExp("^[a-zA-Z0-9 ]+$");
                var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
                if (!regex.test(key)) {
                	event.preventDefault();
                	return false;
                }
            });
        });
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		$.extend(true, $.fn.dataTable.defaults, {
			language:{
				processing:`<div class="loadingio-spinner-ellipsis-ul1uzlc5yan mt-0"><div class="ldio-cvh2xv40fr">
            <div></div><div></div><div></div><div></div><div></div>
            </div></div>
            <p>Tunggu sebentar, sedang memuat data ....</p>`
			},
			responsive:{
				details:{
					renderer: function (api,rowIdx){
						// Select hidden columns for the given row
						var data = api.cells(rowIdx,':hidden').eq(0).map(function(cell) {
							var header = $(api.column(cell.column).header());

							return '<tr style="border-style:hidden;">'+
									'<th class="text-dark">'+
										header.text()+':'+
									'</th> '+
									'<td>'+
										api.cell(cell).data()+
									'</td>'+
								'</tr>';
						}).toArray().join('');

						return data ?
							$('<table/>').append(data) :
							false;
					}
				}
			}
		});
		console.log($(".menu-content-wrap").find(".active").find(".nav-children").first().addClass("show"));
	</script>
	@stack('js')
</body>
</html>

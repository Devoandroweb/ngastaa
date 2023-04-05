<ul class="nav nav-icon nav-tabs nav-justified nav-segmented-tabs nav-light mt-6">
    <li class="nav-item">
        <a class="nav-link tab-utama" data-bs-toggle="tab" href="#data_pribadi" data-ajax="{{route('pegawai.pegawai.detail_pribadi',$pegawai->nip)}}">
            <span class="nav-icon-wrap"><span class="feather-icon"><i class="fas fa-user-tie"></i></span></span>
            <span class="nav-link-text">Data Pribadi</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link tab-utama" data-bs-toggle="tab" href="#posisi_jabatan" data-ajax="{{route('pegawai.posisi.index',$pegawai->nip)}}">
            <span class="nav-icon-wrap"><span class="feather-icon"><i class="fas fa-id-card-alt"></i></span></span>
            <span class="nav-link-text">Posisi dan Jabatan</span>
        </a>
    </li>
    <li class="nav-item ">
        <a class="nav-link tab-utama" data-bs-toggle="tab" href="#data_koor" id="tab-koor" data-ajax="{{route('pegawai.kordinat.index',$pegawai->nip)}}">
            <span class="nav-icon-wrap"><span class="feather-icon"><i class="fas fa-map-marker"></i></span></span>
            <span class="nav-link-text">Data Koordinat</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link tab-utama" data-bs-toggle="tab" href="#data_pribadi" data-ajax="{{route('pegawai.pegawai.detail_pribadi',$pegawai->nip)}}">
            <span class="nav-icon-wrap"><span class="feather-icon"><i class="fas fa-user-tie"></i></span></span>
            <span class="nav-link-text">Akses Akun</span>
        </a>
    </li>
</ul>

{{-- <div class="integrationsapp-wrap">
	<nav class="integrationsapp-sidebar">
		<div data-simplebar="init" class="nicescroll-bar"><div class="simplebar-wrapper" style="margin: 0px;"><div class="simplebar-height-auto-observer-wrapper"><div class="simplebar-height-auto-observer"></div></div><div class="simplebar-mask"><div class="simplebar-offset" style="right: 0px; bottom: 0px;"><div class="simplebar-content-wrapper" style="height: 100%; overflow: hidden;"><div class="simplebar-content" style="padding: 0px;">
			<div class="menu-content-wrap">
				<div class="menu-group">
					<ul class="nav nav-light navbar-nav flex-column">
						<li class="nav-item active">
							<a class="nav-link tab-utama" data-bs-toggle="tab" href="#posisi_jabatan" data-ajax="{{route('pegawai.posisi.index',$pegawai->nip)}}">
								<span class="nav-icon-wrap">{!!icons('c-arror-right')!!}</span>
								<span class="nav-link-text">Data Pribadi</span>
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link tab-utama" data-bs-toggle="tab" href="#data_koor" id="tab-koor" data-ajax="{{route('pegawai.kordinat.index',$pegawai->nip)}}">
								<span class="nav-icon-wrap">{!!icons('c-arror-right')!!}</span>
								<span class="nav-link-text">Posisi dan Jabatan</span>
							</a>
						</li>
					</ul>
				</div>
				<div class="menu-gap"></div>
			</div>
		</div></div></div></div><div class="simplebar-placeholder" style="width: 269px; height: 153px;"></div></div><div class="simplebar-track simplebar-horizontal" style="visibility: hidden;"><div class="simplebar-scrollbar" style="width: 0px; display: none;"></div></div><div class="simplebar-track simplebar-vertical" style="visibility: hidden;"><div class="simplebar-scrollbar" style="height: 0px; transform: translate3d(0px, 47px, 0px); display: none;"></div></div></div>
		<!--Sidebar Fixnav-->
		
		<!--/ Sidebar Fixnav-->
	</nav>
	<div class="integrationsapp-content">
		<div class="integrationsapp-detail-wrap">
			<header class="integrations-header">
				<div class="d-flex align-items-center flex-1">
					<a href="#" class="integrationsapp-title link-dark flex-shrink-0">
						<h1>Data Pribadi</h1>
					</a>
				</div>
				<div class="hk-sidebar-togglable"></div>
			</header>
			<div class="integrations-body">
				<div data-simplebar="init" class="nicescroll-bar"><div class="simplebar-wrapper" style="margin: -20px;"><div class="simplebar-height-auto-observer-wrapper"><div class="simplebar-height-auto-observer"></div></div><div class="simplebar-mask"><div class="simplebar-offset" style="right: 0px; bottom: 0px;"><div class="simplebar-content-wrapper" style="height: 100%; overflow: hidden;"><div class="simplebar-content" style="padding: 20px;">
                <div class="container mt-md-7 mt-3">
                        
                </div>
				</div></div></div></div><div class="simplebar-placeholder" style="width: 1194px; height: 40px;"></div></div><div class="simplebar-track simplebar-horizontal" style="visibility: hidden;"><div class="simplebar-scrollbar" style="width: 0px; display: none;"></div></div><div class="simplebar-track simplebar-vertical" style="visibility: hidden;"><div class="simplebar-scrollbar" style="height: 0px; transform: translate3d(0px, 0px, 0px); display: none;"></div></div></div>
			</div>
		</div>
	</div>
</div> --}}

@push("js")
<script>
    var loading = '<div class="loader mb-4"><div class="bar"></div></div>';
    $(".nav-segmented-tabs .nav-link").click(function (e) { 
        e.preventDefault();
        $('.nav-segmented-tabs .nav-link').removeClass('active')
        $(this).addClass('active')
    });
    $(".tab-utama").click(function (e) { 
        e.preventDefault();
        var target = $(this).attr("href");
        var url = $(this).data("ajax");
        dataAjax(target,url);
    });
    function dataAjax(target,url) { 
        $(".view-data-utama").empty();
        loadingFormStart()
        $.ajax({
            type: "get",
            url: url,
            dataType: "json",
            success: function (response) {
                loadingFormStop()
                $(target).html(response.view); 
                if(target == "#data_koor"){
                    maps();
                }
                $('.target-view').empty();
            }
        });
    }

</script>
<script>
    "use strict"
    function maps(){
        var ltlgOld = $('input[name="kordinat[kordinat]"]').val().split(",");
        console.log(ltlgOld)
        console.log(ltlgOld.length)
        if(ltlgOld.length == 1){
            ltlgOld = [0,0]
        }
        const map = L.map('map',{scrollWheelZoom: false}).setView(ltlgOld, 15);

        const tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        const marker = L.marker(ltlgOld).addTo(map);

        const circle = L.circle(ltlgOld, {
            color: 'red',
            fillColor: '#f03',
            fillOpacity: 0.5,
            radius: 0
        }).addTo(map);
            // circle.setRadius($("#radius").val());

        $("#radius").on('change', function () {
            const range = $(this);
            circle.setRadius(range.val());
            $("#radius_count").val(range.val())
        });

        $("#koordinat").change(function (e) { 
            e.preventDefault();
            const val = $(this).val();
            var ltlg = val.split(",")
            if(ltlg.length == 1){
                ltlg = [0,0]
            }
            updateMap(ltlg)

            $("#latitude").val(ltlg[0]);
            $("#longitude").val(ltlg[1]);
        });
        function updateMap(ltlg){
            map.setView(ltlg,15);
            // marker.addTo(map);
            var newLatLng = new L.LatLng(ltlg[0],ltlg[1]);
            circle.setLatLng(newLatLng)
            marker.setLatLng(newLatLng); 
        }
    }
</script>
@endpush


@extends('app',["dashboard"=>true])
@section('content')

<div class="row gx-3 mb-3">
    <div class="col-md-3">
        <div class="card shadow border-info contact-card">
            <div class="card-body">
                <h5 class="card-title pb-2">Jumlah Pegawai</h5>
                <div class="d-flex align-items-center ">
                    <div class="avatar avatar-icon avatar-l avatar-soft-blue avatar-rounded rounded-circle-bordered">
                        <span class="initial-wrap">
                            <span class="feather-icon">
                                <i class="bi bi-people"></i>
                            </span>
                        </span>
                    </div>
                    <div class="ps-3">
                        <h3>{{$jumlah_pegawai}}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow border-success contact-card">
            <div class="card-body">
                <h5 class="card-title pb-2">Presensi Hari Ini</h5>
                <div class="d-flex align-items-center">
                    <div class="avatar avatar-icon avatar-l avatar-soft-success avatar-rounded rounded-circle-bordered">
                        <span class="initial-wrap">
                            <span class="feather-icon">
                                <i class="bi bi-calendar2-day"></i>
                            </span>
                        </span>
                    </div>
                    <div class="ps-3">
                        <h3>{{$presensi}}</h3>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow border-danger contact-card">
            <div class="card-body">
                <h5 class="card-title pb-2">Presensi Bulan Ini</h5>
                <div class="d-flex align-items-center">
                    <div class="avatar avatar-icon avatar-l avatar-soft-pink avatar-rounded rounded-circle-bordered">
                        <span class="initial-wrap">
                            <span class="feather-icon">
                                <i class="bi bi-calendar2-month"></i>
                            </span>
                        </span>
                    </div>
                    <div class="ps-3">
                        <h3>{{$bulan}}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow border-warning contact-card">
            <div class="card-body">
                <h5 class="card-title pb-2">Presensi Tahun Ini</h5>
                <div class="d-flex align-items-center">
                    <div class="avatar avatar-icon avatar-l avatar-soft-orange avatar-rounded rounded-circle-bordered">
                        <span class="initial-wrap">
                            <span class="feather-icon">
                                <i class="bi bi-calendar3"></i>
                            </span>
                        </span>
                    </div>
                    <div class="ps-3">
                        <h3>{{$tahun}}</h3>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row mb-2">
    <div class="col-md-12 mb-md-4 mb-3">
        <div class="card card-border border-info mb-0 h-100">
            <div class="card-header  border-bottom border-info shadow card-header-action">
                <h6 class="text-bold">Lokasi Kerja</h6>
                <div class="card-action-wrap">
                    <a class="btn btn-xs btn-icon btn-rounded btn-flush-dark flush-soft-hover full-screen"  href="#"><span class="icon"><span class="feather-icon"><i data-feather="maximize"></i></span><span class="feather-icon d-none"><i data-feather="minimize"></i></span></span></a>
                    <a class="btn btn-xs btn-icon btn-rounded btn-flush-dark flush-soft-hover"  data-bs-toggle="collapse" href="#collapse_4" aria-expanded="true"><span class="icon"><span class="feather-icon"><i data-feather="chevron-down"></i></span></span></a>
                </div>
            </div>
            {{-- <div class="hk-ribbon-type-1 hk-ribbon-danger end-over">
                    <span>Coming Soon</span>
            </div> --}}
            <div class="card-body p-0">
                <div id="collapse_2" class="collapse show">
                    <div class="row">
                        <div class="col-md-8">
                            <div id="anim_map_2" class="h-300p"></div>
                        </div>
                        <div class="col-md-4 p-4">
                            <div data-simplebar class="nicescroll-bar" style="height:40vh;">
                                @foreach($lokasiVisit as $lokasi)
                                <div class="media align-items-center mb-3">
                                    <div class="media-head me-3">
                                        <div class="avatar avatar-xxs avatar-rounded">
                                            <img src="{{asset('/')}}dist/img/location.png" alt="user" class="avatar-img">
                                        </div>
                                    </div>
                                   <div class="media-body">
                                        <small>
                                            <div class="text-high-em">{{$lokasi->nama}}</div>
                                            <div class="fs-7">Kode Lokasi : <span class="text-primary fw-bold">{{$lokasi->kode_lokasi}}</span></div>
                                        </small>
                                    </div>
                                </div>
                                @endforeach
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row mb-5 d-none">
    <div class="col-lg-6 col-sm-12 mb-4 mb-md-0">
        <div class="card card-refresh shadow border-primary mb-0  h-100">
            <div class="refresh-container">
                <div class="loader-pendulums"></div>
            </div>
            <div class="card-header border-bottom border-primary shadow card-header-action">

                <h6>Payroll Statistic</h6>
                <div class="card-action-wrap">
                    <div class="d-flex">
                        <input type="text" name="year_payroll" class="form-control form-control-sm datepicker-single-year" value="{{date("d-m-Y")}}" id="">
                    </div>
                    <a class="btn btn-xs btn-icon btn-rounded btn-flush-dark flush-soft-hover refresh"  href="#"><span class="icon"><span class="feather-icon"><i data-feather="disc"></i></span></span></a>
                    <a class="btn btn-xs btn-icon btn-rounded btn-flush-dark flush-soft-hover full-screen"  href="#"><span class="icon"><span class="feather-icon"><i data-feather="maximize"></i></span><span class="feather-icon d-none"><i data-feather="minimize"></i></span></span></a>
                    <a class="btn btn-xs btn-icon btn-rounded btn-flush-dark flush-soft-hover"  data-bs-toggle="collapse" href="#collapse_1" aria-expanded="true"><span class="icon"><span class="feather-icon"><i data-feather="chevron-down"></i></span></span></a>
                </div>
            </div>
            <div id="collapse_1" class="collapse show">
                <div class="card-body">
                    <div id="line_chart_8"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-sm-12">
         <div class="card card-refresh shadow border-primary mb-0  h-100">
            <div class="refresh-container">
                <div class="loader-pendulums"></div>
            </div>
            <div class="card-header border-bottom border-primary shadow card-header-action position-relative">
                <h6>Attendance Statistic</h6>
                <div class="card-action-wrap">
                    <div class="d-flex">
                        <input type="text" name="date_attedance" class="form-control form-control-sm datepicker" value="{{date("m-Y")}}" id="">
                    </div>
                    <a class="btn btn-xs btn-icon btn-rounded btn-flush-dark flush-soft-hover refresh"  href="#"><span class="icon"><span class="feather-icon"><i data-feather="disc"></i></span></span></a>
                    <a class="btn btn-xs btn-icon btn-rounded btn-flush-dark flush-soft-hover full-screen"  href="#"><span class="icon"><span class="feather-icon"><i data-feather="maximize"></i></span><span class="feather-icon d-none"><i data-feather="minimize"></i></span></span></a>
                    <a class="btn btn-xs btn-icon btn-rounded btn-flush-dark flush-soft-hover"  data-bs-toggle="collapse" href="#collapse_2" aria-expanded="true"><span class="icon"><span class="feather-icon"><i data-feather="chevron-down"></i></span></span></a>
                </div>
            </div>
            <div id="collapse_2" class="collapse show">
                <div class="card-body">
                    <div id="column_chart_5"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row mb-3">
    <div class="col">
        <div class="card border-danger ">
            <div class="card-header border-bottom border-danger shadow card-header-action">
                <h6 class="text-bold py-2"> Daftar Pegawai Yang Akan Habis Kontrak Pada Bulan ini </h6>
                <div class="card-action wrap">
                    <a href="#" class="btn btn-custom btn-sm btn-danger icon-wthot-bg btn-rounded"><span><span>Download PDF</span><span class="icon"><i class="far fa-file-pdf"></i> </span></span></a>
                </div>
            </div>
            <div class="card-body">
                <table id="data" class="table mt-2 nowrap w-100 mb-5 table-responsive ">
                    <thead>
                        <tr className="fw-bolder text-muted">
                            <th>{{__('No')}}</th>
                            <th>{{__('NIP')}}</th>
                            <th>{{__('Nama Lengkap')}}</th>
                            <th>{{__('Divisi Kerja')}}</th>
                            <th>{{__('Jabatan')}}</th>
                            <th>{{__('Tanggal Berakhir Kontrak')}}</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="row ">
    <div class="col-sm-6">
        <div class="card border-pink ">
            <div class="card-header border-bottom border-pink shadow card-header-action">
                <h6 class="text-bold py-2"> Kepegawaian Berdasarkan Status Pegawai </h6>
                <div class="card-action-wrap">
                    <div class="d-flex">
                        <input type="text" name="year_payroll" class="form-control form-control-sm datepicker-single-year" value="{{date("d-m-Y")}}" id="">
                    </div>

                    <a class="btn btn-xs btn-icon btn-rounded btn-flush-dark flush-soft-hover full-screen"  href="#"><span class="icon"><span class="feather-icon"><i data-feather="maximize"></i></span><span class="feather-icon d-none"><i data-feather="minimize"></i></span></span></a>

                </div>
            </div>
            <div class="card-body">
                <div id="chart_kepegawaian" style="height:350px"></div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="card border-pink ">
            <div class="card-header border-bottom border-pink shadow card-header-action">
                <h6 class="text-bold py-2"> Kepegawaian Berdasarkan Perkawinan </h6>
                <div class="card-action-wrap">
                    <div class="d-flex">
                        <input type="text" name="year_payroll" class="form-control form-control-sm datepicker-single-year" value="{{date("d-m-Y")}}" id="">
                    </div>

                    <a class="btn btn-xs btn-icon btn-rounded btn-flush-dark flush-soft-hover full-screen"  href="#"><span class="icon"><span class="feather-icon"><i data-feather="maximize"></i></span><span class="feather-icon d-none"><i data-feather="minimize"></i></span></span></a>

                </div>
            </div>
            <div class="card-body">
                <div id="chart_perkawinan" style="height:350px"></div>
            </div>
        </div>
    </div>
</div>


@endsection
@push('js')


<!-- Amcharts Maps JS -->
<script src="{{asset('/')}}vendors/@amcharts/amcharts4/core.js"></script>
<script src="{{asset('/')}}vendors/@amcharts/amcharts4/maps.js"></script>
<script src="{{asset('/')}}vendors/@amcharts/amcharts4-geodata/worldLow.js"></script>
<script src="{{asset('/')}}vendors/@amcharts/amcharts4-geodata/worldHigh.js"></script>
<script src="{{asset('/')}}vendors/@amcharts/amcharts4/themes/animated.js"></script>

<!-- Apex JS -->
<script src="{{asset('/')}}vendors/apexcharts/dist/apexcharts.min.js"></script>
<script>
initDatePickerSingleCL()
initDatePickerCC()
function initDatePickerSingleCL(){
    $(".datepicker-single-year").daterangepicker(
        {
            // singleDatePicker: true,
            changeMonth: true,
            changeYear: true,
            // depth: "month",
            // start: "year",
            startDate: $(".datepicker-single-year").val(),
            // showDropdowns: true,
            autoApply: true,
            minYear: 2022,
            maxYear: new Date().getFullYear(),
            locale: {
                format: "DD/MM/YYYY",
            },
        },
        function (start, end, label) {
            getPayroll(start.format("YYYY-MM-DD"),end.format("YYYY-MM-DD"));
        }
    );
}
function initDatePickerCC(){
    $(".datepicker").daterangepicker(
        {
            // singleDatePicker: true,
            changeMonth: true,
            changeYear: true,
            startDate: $(".datepicker").val(),
            alwaysShowCalendars:false,
            autoApply: true,
            minYear: 2022,
            maxYear: new Date().getFullYear(),
            locale: {
                format: "MM/YYYY",
            },
        },
        function (start, end, label) {
            // getPayroll(start.format("YYYY-MM-DD"),end.format("YYYY-MM-DD"));
        }
    );
}
/* LINE CHART */
var _LINE_CHART_OPT = null;
var _URL_CHART_LINE = "{{route('payrollStatistic')}}";
var _CHART_LINE = null;
$.ajax({url:_URL_CHART_LINE , success: function(response){
    initLineChart(response.categories,response.data,response.max_range_total)
}});
let getPayroll = (dateStart = null,dateEnd = null) => {
    $.ajax({url: _URL_CHART_LINE+`?d=${dateStart},${dateEnd}`, success: function(response){
        _LINE_CHART_OPT.series[0].data = response.data;
        _LINE_CHART_OPT.xaxis.categories = response.categories;
        _LINE_CHART_OPT.yaxis.max = response.max_range_total;
        _CHART_LINE.updateOptions(_LINE_CHART_OPT)
    }});
}

var initLineChart = (categories = [],data = [],max = 0) => {
    /*Gradient Line*/
    _LINE_CHART_OPT = {
        series: [{
            name: 'Total',
            data: data
        }],
        chart: {
            height: 350,
            type: 'line',
        },
        stroke: {
            width: 2,
            curve: 'smooth'
        },
        xaxis: {
            // type: 'datetime',
            axisBorder: {
                show: false,
            },
            categories: categories,
        },
        fill: {
            type: 'gradient',
            gradient: {
                shade: 'dark',
                gradientToColors: ['#FDD835'],
                shadeIntensity: 1,
                type: 'horizontal',
                opacityFrom: 1,
                opacityTo: 1,
                stops: [0, 100, 100, 100]
            },
        },
        markers: {
            size: 4,
            colors: ["#FFA41B"],
            strokeColors: "#fff",
            strokeWidth: 2,
            hover: {
                size: 7,
            }
        },
        yaxis: {
            min: 0,
            max: max,
            labels: {
                formatter: (value) => {
                    var number = (value / 1000);
                    if(number >= 1000){
                        return (number/1000) + "M"
                    }
                    return number + "K"
                },
            },
        },
        noData: {
            text: "No Data",
            align: 'center',
            verticalAlign: 'middle',
            offsetX: 0,
            offsetY: 0,
            style: {
                color: "#0850A5",
                fontSize: '16px',
            }
        }
    };
    _CHART_LINE = new ApexCharts(document.querySelector("#line_chart_8"), _LINE_CHART_OPT);
    _CHART_LINE.render();
}

// ===========================

/*Distributed Column*/
var colors = @json($colorTotalPresensi);
console.log(@json($dataTotalPresensi));
var options4 = {
	series: [{
		data: @json($dataTotalPresensi)
	}],
	chart: {
		height: 350,
		type: 'bar',
		events: {
			click: function(chart, w, e) {
				// console.log(chart, w, e)
			}
		}
	},
	colors: colors,
	plotOptions: {
		bar: {
			columnWidth: '45%',
			distributed: true
		}
	},
	dataLabels: {
		enabled: false
	},
	legend: {
		show: false
	},
	xaxis: {
		categories: @json($textTotalPresensi),
		labels: {
			style: {
				colors: colors,
				fontSize: '12px'
			}
		}
	}
};

var chart4 = new ApexCharts(document.querySelector("#column_chart_5"), options4);
chart4.render();
// ==================================

/*Animated Map*/
am4core.ready(function() {

	// Themes begin
	am4core.useTheme(am4themes_animated);
	// Themes end

	// Create map instance
	var chart2 = am4core.create("anim_map_2", am4maps.MapChart);

	// Set map definition
	chart2.geodata = am4geodata_worldLow;
	chart2.homeZoomLevel = 7;
    chart2.homeGeoPoint = {
        latitude: -2.0421272,
        longitude: 120.2801101
    };

	// Set projection
	chart2.projection = new am4maps.projections.Miller();

	// Create map polygon series
	var polygonSeries = chart2.series.push(new am4maps.MapPolygonSeries());
	polygonSeries.mapPolygons.template.fill = am4core.color("#E6E9EB");
	polygonSeries.mapPolygons.template.fillOpacity = 1;

	// Exclude Antartica
	polygonSeries.exclude = ["AQ"];

	// Make map load polygon (like country names) data from GeoJSON
	polygonSeries.useGeodata = true;

	// Configure series
	var polygonTemplate = polygonSeries.mapPolygons.template;
	polygonTemplate.tooltipText = "{name}";


	// Create hover state and set alternative fill color
	var hs = polygonTemplate.states.create("hover");
	hs.properties.fill = am4core.color("#CCE5E7");

	// Add image series
	var imageSeries = chart2.series.push(new am4maps.MapImageSeries());
	imageSeries.mapImages.template.propertyFields.longitude = "longitude";
	imageSeries.mapImages.template.propertyFields.latitude = "latitude";
	imageSeries.mapImages.template.tooltipText = "{title}";
	imageSeries.mapImages.template.propertyFields.url = "url";

	var circle = imageSeries.mapImages.template.createChild(am4core.Circle);
	circle.radius = 0.5;
	circle.propertyFields.fill = "color";

	var circle2 = imageSeries.mapImages.template.createChild(am4core.Circle);
	circle2.radius = 0.5;
	circle2.propertyFields.fill = "color";



	circle2.events.on("inited", function(event){
	  animateBullet(event.target);
	})


	function animateBullet(circle) {
		var animation = circle.animate([{ property: "scale", from: 1, to: 5 }, { property: "opacity", from: 1, to: 0 }], 1000, am4core.ease.circleOut);
		animation.events.on("animationended", function(event){
		  animateBullet(event.target.object);
		})
	}

	var colorSet = new am4core.ColorSet();
	console.log(@json($mapsRadar))
	imageSeries.data = @json($mapsRadar);
}); // end am4core.ready()


/*Donut Chart*/
var status_pegawai_statistic = @json($status_pegawai_statistic);
console.log(@json($status_pegawai_statistic));
console.log(status_pegawai_statistic.labels);
var options1 = {
	series: status_pegawai_statistic.series,
	chart: {
        type: 'donut',
        width: 450,

    },
    plotOptions: {
        pie: {
            donut: {
                labels: {
                    show: true,
                    name: {
                        fontSize: '22px',
                    },
                    value: {
                        fontSize: '16px',
                    },
                    total: {
                        show: true,
                        label: 'Total',
                    },
                }
            }
        }
    },

    labels:status_pegawai_statistic.labels,
    colors: status_pegawai_statistic.colors,
    responsive: [{
            breakpoint: 480,
            options: {
            chart: {
                width: 200
            },
            legend: {
                position: 'bottom'
            }
        }
    }]
};

var chart1 = new ApexCharts(document.querySelector("#chart_kepegawaian"), options1);
chart1.render();

// Pie Chart
var options = {
  series: @json($status_kawin_statistic['series']),
  chart: {
  width: 500,
  type: 'pie',
},
colors: @json($status_kawin_statistic['colors']),
labels: @json($status_kawin_statistic['labels']),
responsive: [{
  breakpoint: 480,
  options: {
	chart: {
	  width: 300
	},
	legend: {
	  position: 'bottom'
	}
  }
}]
};

var chart = new ApexCharts(document.querySelector("#chart_perkawinan"), options);
chart.render();
var _TABLE = null;
        var _URL_DATATABLE = '{{url("dashboard-datatable")}}';
        // SESUAIKAN COLUMN DATATABLE
        // SESUAIKAN FIELD EDIT MODAL
        setDataTable();
        function setDataTable() {
            _TABLE = $('#data').DataTable({
                responsive:true,
                processing: true,
                serverSide: true,
                ajax: {
                    url: _URL_DATATABLE,
                },
                rowReorder: {
                    selector: 'td:nth-child(1)'
                },
                language:{
                    searchPlaceholder: "Cari",
                    search: ""
                },
                columns: [{
                        "data": 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                    },{
                        data: 'resource.nip',
                        name: 'resource.nip',
                    },{
                        data: 'resource.name',
                        name: 'resource.name',
                    },{
                        data: 'divisi_kerja',
                        name: 'divisi_kerja',
                    },{
                        data: 'nama_jabatan',
                        name: 'nama_jabatan',
                    },{
                        data: 'tanggal_tmt',
                        name: 'tanggal_tmt',
                    }],

            });
        }
		$('.dataTables_wrapper .dataTables_filter input').css('width','85% !important');


</script>
@endpush

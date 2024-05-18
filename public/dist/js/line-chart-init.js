/*Apex Line Chart*/
window.Apex = {
	chart: {
		foreColor: "#646A71",
		toolbar: {
			tools: {
				download: '<svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg>',
				selection: '<img src="/static/icons/reset.png" width="20">',	
				zoom: '<svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line><line x1="11" y1="8" x2="11" y2="14"></line><line x1="8" y1="11" x2="14" y2="11"></line></svg>',
				zoomin: '<svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>',
				zoomout: '<svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><circle cx="12" cy="12" r="10"></circle><line x1="8" y1="12" x2="16" y2="12"></line></svg>',
				pan: '<svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><polyline points="5 9 2 12 5 15"></polyline><polyline points="9 5 12 2 15 5"></polyline><polyline points="15 19 12 22 9 19"></polyline><polyline points="19 9 22 12 19 15"></polyline><line x1="2" y1="12" x2="22" y2="12"></line><line x1="12" y1="2" x2="12" y2="22"></line></svg>',
				reset: '<svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>',
			}
		}
	},
	grid: {
        borderColor: '#F4F5F6',
    },
	xaxis: {
        labels: {
            style: {
				fontSize: '12px',
				fontFamily: 'inherit',
				fontWeight: 500,
            },
        },
        axisBorder: {
            show: false,
        },
        title: {
			style: {
                fontSize: '12px',
                fontFamily: 'inherit',
                fontWeight: 500,
            }
        }
    },
    yaxis: {
        labels: {
            style: {
                fontSize: '12px',
                fontFamily: 'inherit',
                fontWeight: 500,
            },
        },
        title: {
            style: {
                fontSize: '12px',
                fontFamily: 'inherit',
                fontWeight: 500,
                
            }
        },
    },
};
/*Basic Line*/
var options = {
    series: [{
        name: "Desktops",
        data: [145, 52, 38, 24, 33, 26, 21, 20, 6, 8, 15, 10]
    }],
    chart: {
        height: 350,
        type: 'line',
        zoom: {
            enabled: false
        }
    },
    dataLabels: {
        enabled: false
    },
	stroke: {
        curve: 'straight',
        width: 2
    },
    xaxis: {
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep','oct','Nov','Dec'],
        axisBorder: {
            show: false,
        },

    }
};
var chart = new ApexCharts(document.querySelector("#line_chart_1"), options);
chart.render();

/*Line with data labels*/
var options1 = {
    series: [{
            name: "High - 2013",
            data: [28, 29, 33, 36, 32, 32, 33]
        },
        {
            name: "Low - 2013",
            data: [12, 11, 14, 18, 17, 13, 13]
        }
    ],
    chart: {
        height: 350,
        type: 'line',
        dropShadow: {
            enabled: true,
            color: '#000',
            top: 18,
            left: 7,
            blur: 10,
            opacity: 0.2
        },
        toolbar: {
            show: false
        }
    },
    colors: ['#77B6EA', '#545454'],
    dataLabels: {
        enabled: true,
    },
    stroke: {
        curve: 'smooth',
        width: 2
    },
    markers: {
        size: 1
    },
    xaxis: {
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
        labels: {
            style: {
               
            },
        },
		title: {
            text: 'Month',
		}
    },
    yaxis: {
        title: {
            text: 'Temperature',
        },
        min: 5,
        max: 40
    },
    legend: {
        position: 'top',
        horizontalAlign: 'right',
        floating: true,
        offsetY: -25,
        offsetX: -5
    }
};
var chart1 = new ApexCharts(document.querySelector("#line_chart_2"), options1);
chart1.render();

/*Zoomable time series*/
var ts2 = 1484418600000;
var dates = [];
var spikes = [5, -5, 3, -3, 8, -8]
for (var i = 0; i < 120; i++) {
    ts2 = ts2 + 86400000;
    var innerArr = [ts2, dataSeries[1][i].value];
    dates.push(innerArr)
}
var options2 = {
    series: [{
        name: 'XYZ MOTORS',
        data: dates
    }],
    chart: {
        type: 'area',
        stacked: false,
        height: 350,
        zoom: {
            type: 'x',
            enabled: true,
            autoScaleYaxis: true
        },
        toolbar: {
            autoSelected: 'zoom'
        }
    },
    dataLabels: {
        enabled: false
    },
    stroke: {
        width: 2
    },
    markers: {
        size: 0,
    },
    fill: {
        type: 'gradient',
        gradient: {
            shadeIntensity: 1,
            inverseColors: false,
            opacityFrom: 0.5,
            opacityTo: 0,
            stops: [0, 90, 100]
        },
    },
    yaxis: {
        labels: {
            formatter: function(val) {
                return (val / 1000000).toFixed(0);
            },

        },
        title: {
            text: 'Price'
        },
    },
    xaxis: {
        type: 'datetime',
        axisBorder: {
            show: false,
        },
    },
   tooltip: {
        shared: false,
        y: {
            formatter: function(val) {
                return (val / 1000000).toFixed(0)
            }
        }
    }
};

var chart2 = new ApexCharts(document.querySelector("#line_chart_3"), options2);
chart2.render();


/*Sychronised charts*/
function generateDayWiseTimeSeries(baseval, count, yrange) {
    var i = 0;
    var series = [];
    while (i < count) {
        var x = baseval;
        var y = Math.floor(Math.random() * (yrange.max - yrange.min + 1)) + yrange.min;

        series.push([x, y]);
        baseval += 86400000;
        i++;
    }
    return series;
}

var options3 = {
    series: [{
        data: generateDayWiseTimeSeries(new Date('11 Feb 2017').getTime(), 20, {
            min: 10,
            max: 60
        })
    }],
    chart: {
        id: 'fb',
        group: 'social',
        type: 'line',
        height: 160
    },
    dataLabels: {
        enabled: false
    },
    stroke: {
        curve: 'straight',
        width: 2
    },
    toolbar: {
        tools: {
            selection: false
        }
    },
    markers: {
        size: 6,
        hover: {
            size: 10
        }
    },
    yaxis: {
        tickAmount: 2
    },
    xaxis: {
        type: 'datetime',
        axisBorder: {
            show: false,
        },
    },
    colors: ['#008FFB'],
    yaxis: {
        labels: {
            minWidth: 40
        }
    }
};

var chart3 = new ApexCharts(document.querySelector("#line_chart_4"), options3);
chart3.render();

var optionsLine2 = {
    series: [{
        data: generateDayWiseTimeSeries(new Date('11 Feb 2017').getTime(), 20, {
            min: 10,
            max: 30
        }),

    }],
    chart: {
        id: 'tw',
        group: 'social',
        type: 'line',
        height: 160
    },
    dataLabels: {
        enabled: false
    },
    stroke: {
        curve: 'straight',
        width: 2
    },
    toolbar: {
        tools: {
            selection: false
        }
    },
    markers: {
        size: 6,
        hover: {
            size: 10
        }
    },
    xaxis: {
        type: 'datetime',
        axisBorder: {
            show: false,
        },
    },
    colors: ['#546E7A'],
    yaxis: {
        labels: {
            minWidth: 40
        }
    }
};

var chartLine2 = new ApexCharts(document.querySelector("#line_chart_5"), optionsLine2);
chartLine2.render();

var optionsArea = {
    series: [{
        data: generateDayWiseTimeSeries(new Date('11 Feb 2017').getTime(), 20, {
            min: 10,
            max: 60
        })
    }],
    chart: {
        id: 'yt',
        group: 'social',
        type: 'area',
        height: 160
    },
    dataLabels: {
        enabled: false
    },
    stroke: {
        curve: 'straight',
        width: 2
    },
    toolbar: {
        tools: {
            selection: false
        }
    },
    markers: {
        size: 6,
        hover: {
            size: 10
        }
    },
    xaxis: {
        type: 'datetime',
        axisBorder: {
            show: false,
        },
    },

    colors: ['#00E396'],
    yaxis: {
        labels: {
            minWidth: 40
        }
    }
};

var chartArea = new ApexCharts(document.querySelector("#area_chart"), optionsArea);
chartArea.render();


/*Brush Chart*/
var data = generateDayWiseTimeSeries(new Date('11 Feb 2017').getTime(), 185, {
    min: 30,
    max: 90
})

var options4 = {
    series: [{
        data: data
    }],
    chart: {
        type: 'line',
        id: 'chart2',
        height: 230,
        toolbar: {
            autoSelected: 'pan',
            show: false
        }
    },
    colors: ['#546E7A'],
    stroke: {
        width: 2
    },
    dataLabels: {
        enabled: false
    },
    fill: {
        opacity: 1,
    },
    markers: {
        size: 0
    },
    xaxis: {
        type: 'datetime',
        axisBorder: {
            show: false,
        },
    }
};

var chart4 = new ApexCharts(document.querySelector("#line_chart_6"), options4);
chart4.render();

var optionsLine = {
    series: [{
        data: data
    }],
    chart: {
        height: 130,
        id: 'chart1',
        type: 'area',
        brush: {
            target: 'chart2',
            enabled: true
        },
        selection: {
            enabled: true,
            xaxis: {
                min: new Date('19 Jun 2017').getTime(),
                max: new Date('14 Aug 2017').getTime()
            }
        },
    },
    colors: ['#008FFB'],
    fill: {
        type: 'gradient',
        gradient: {
            opacityFrom: 0.91,
            opacityTo: 0.1,
        }
    },
    xaxis: {
        type: 'datetime',
        axisBorder: {
            show: false,
        },
        tooltip: {
            enabled: false
        }
    },
    yaxis: {
        tickAmount: 2
    },
};

var chartLine = new ApexCharts(document.querySelector("#line_chart_7"), optionsLine);
chartLine.render();

/*Gradient Line*/
var options5 = {
    series: [{
        name: 'Likes',
        data: [4, 3, 10, 9, 29, 19, 22, 9, 12, 7, 19, 5, 13, 9, 17, 2, 7, 5]
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
        type: 'datetime',
        axisBorder: {
            show: false,
        },
        categories: ['1/11/2000', '2/11/2000', '3/11/2000', '4/11/2000', '5/11/2000', '6/11/2000', '7/11/2000', '8/11/2000', '9/11/2000', '10/11/2000', '11/11/2000', '12/11/2000', '1/11/2001', '2/11/2001', '3/11/2001', '4/11/2001', '5/11/2001', '6/11/2001'],
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
        min: -10,
        max: 40,
        title: {
            text: 'Engagement',
        },
    }
};

var chart5 = new ApexCharts(document.querySelector("#line_chart_8"), options5);
chart5.render();


/*Realtime Line*/
var lastDate = 0;
var data = []
var TICKINTERVAL = 86400000
let XAXISRANGE = 777600000

function getDayWiseTimeSeries(baseval, count, yrange) {
    var i = 0;
    while (i < count) {
        var x = baseval;
        var y = Math.floor(Math.random() * (yrange.max - yrange.min + 1)) + yrange.min;

        data.push({
            x,
            y
        });
        lastDate = baseval
        baseval += TICKINTERVAL;
        i++;
    }
}

getDayWiseTimeSeries(new Date('11 Feb 2017 GMT').getTime(), 10, {
    min: 10,
    max: 90
})

function getNewSeries(baseval, yrange) {
    var newDate = baseval + TICKINTERVAL;
    lastDate = newDate

    for (var i = 0; i < data.length - 10; i++) {
        // IMPORTANT
        // we reset the x and y of the data which is out of drawing area
        // to prevent memory leaks
        data[i].x = newDate - XAXISRANGE - TICKINTERVAL
        data[i].y = 0
    }

    data.push({
        x: newDate,
        y: Math.floor(Math.random() * (yrange.max - yrange.min + 1)) + yrange.min
    })
}

function resetData() {
    // Alternatively, you can also reset the data at certain intervals to prevent creating a huge series 
    data = data.slice(data.length - 10, data.length);
}

var options6 = {
    series: [{
        data: data.slice()
    }],
    chart: {
        id: 'realtime',
        height: 350,
        type: 'line',
        animations: {
            enabled: true,
            easing: 'linear',
            dynamicAnimation: {
                speed: 1000
            }
        },
        toolbar: {
            show: false
        },
        zoom: {
            enabled: false
        }
    },
    dataLabels: {
        enabled: false
    },
    stroke: {
        curve: 'smooth',
        width: 2
    },
    markers: {
        size: 0
    },
    xaxis: {
        type: 'datetime',
        range: XAXISRANGE,
        axisBorder: {
            show: false,
        },
    },
    yaxis: {
        max: 100
    },
    legend: {
        show: false
    },
};

var chart6 = new ApexCharts(document.querySelector("#line_chart_9"), options6);
chart6.render();


window.setInterval(function() {
    getNewSeries(lastDate, {
        min: 10,
        max: 90
    })

    chart6.updateSeries([{
        data: data
    }])
}, 1000)

/*Dashed*/
var options7 = {
    series: [{
            name: "Session Duration",
            data: [45, 52, 38, 24, 33, 26, 21, 20, 6, 8, 15, 10]
        },
        {
            name: "Page Views",
            data: [35, 41, 62, 42, 13, 18, 29, 37, 36, 51, 32, 35]
        },
        {
            name: 'Total Visits',
            data: [87, 57, 74, 99, 75, 38, 62, 47, 82, 56, 45, 47]
        }
    ],
    chart: {
        height: 350,
        type: 'line',
        zoom: {
            enabled: false
        },
    },
    dataLabels: {
        enabled: false
    },
    stroke: {
        width: [2, 2, 2],
        curve: 'straight',
        dashArray: [0, 8, 5]
    },

    legend: {
        tooltipHoverFormatter: function(val, opts) {
            return val + ' - ' + opts.w.globals.series[opts.seriesIndex][opts.dataPointIndex] + ''
        }
    },
    markers: {
        size: 0,
        hover: {
            sizeOffset: 6
        }
    },
    xaxis: {
        categories: ['01 Jan', '02 Jan', '03 Jan', '04 Jan', '05 Jan', '06 Jan', '07 Jan', '08 Jan', '09 Jan',
            '10 Jan', '11 Jan', '12 Jan'
        ],
        axisBorder: {
            show: false,
        },
    },
    tooltip: {
        y: [{
                title: {
                    formatter: function(val) {
                        return val + " (mins)"
                    }
                }
            },
            {
                title: {
                    formatter: function(val) {
                        return val + " per session"
                    }
                }
            },
            {
                title: {
                    formatter: function(val) {
                        return val;
                    }
                }
            }
        ]
    },
};

var chart7 = new ApexCharts(document.querySelector("#line_chart_10"), options7);
chart7.render();
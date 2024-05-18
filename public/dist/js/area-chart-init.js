/*Apex Area Chart*/
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

/*Basic Area*/
var options = {
    series: [{
        name: "STOCK ABC",
        data: series.monthDataSeries1.prices
    }],
    chart: {
        type: 'area',
        height: 350,
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

    labels: series.monthDataSeries1.dates,
    xaxis: {
        type: 'datetime',
    },
    legend: {
        horizontalAlign: 'left'
    }
};

var chart = new ApexCharts(document.querySelector("#area_chart_1"), options);
chart.render();

/*Spline Area*/
var options1 = {
    series: [{
        name: 'series1',
        data: [31, 40, 28, 51, 42, 109, 100]
    }, {
        name: 'series2',
        data: [11, 32, 45, 32, 34, 52, 41]
    }],
    chart: {
        height: 350,
        type: 'area'
    },
    dataLabels: {
        enabled: false
    },
    stroke: {
        curve: 'smooth',
		width: 2
    },
    xaxis: {
        type: 'datetime',
        categories: ["2018-09-19T00:00:00.000Z", "2018-09-19T01:30:00.000Z", "2018-09-19T02:30:00.000Z", "2018-09-19T03:30:00.000Z", "2018-09-19T04:30:00.000Z", "2018-09-19T05:30:00.000Z", "2018-09-19T06:30:00.000Z"]
    },
    tooltip: {
        x: {
            format: 'dd/MM/yy HH:mm'
        },
    },
};

var chart1 = new ApexCharts(document.querySelector("#area_chart_2"), options1);
chart1.render();

/*Negative Area*/
var options2 = {
    series: [{
        name: 'north',
        data: [{
                x: 1996,
                y: 322
            },
            {
                x: 1997,
                y: 324
            },
            {
                x: 1998,
                y: 329
            },
            {
                x: 1999,
                y: 342
            },
            {
                x: 2000,
                y: 348
            },
            {
                x: 2001,
                y: 334
            },
            {
                x: 2002,
                y: 325
            },
            {
                x: 2003,
                y: 316
            },
            {
                x: 2004,
                y: 318
            },
            {
                x: 2005,
                y: 330
            },
            {
                x: 2006,
                y: 355
            },
            {
                x: 2007,
                y: 366
            },
            {
                x: 2008,
                y: 337
            },
            {
                x: 2009,
                y: 352
            },
            {
                x: 2010,
                y: 377
            },
            {
                x: 2011,
                y: 383
            },
            {
                x: 2012,
                y: 344
            },
            {
                x: 2013,
                y: 366
            },
            {
                x: 2014,
                y: 389
            },
            {
                x: 2015,
                y: 334
            }
        ]
    }, {
        name: 'south',
        data: [{
                x: 1996,
                y: 162
            },
            {
                x: 1997,
                y: 90
            },
            {
                x: 1998,
                y: 50
            },
            {
                x: 1999,
                y: 77
            },
            {
                x: 2000,
                y: 35
            },
            {
                x: 2001,
                y: -45
            },
            {
                x: 2002,
                y: -88
            },
            {
                x: 2003,
                y: -120
            },
            {
                x: 2004,
                y: -156
            },
            {
                x: 2005,
                y: -123
            },
            {
                x: 2006,
                y: -88
            },
            {
                x: 2007,
                y: -66
            },
            {
                x: 2008,
                y: -45
            },
            {
                x: 2009,
                y: -29
            },
            {
                x: 2010,
                y: -45
            },
            {
                x: 2011,
                y: -88
            },
            {
                x: 2012,
                y: -132
            },
            {
                x: 2013,
                y: -146
            },
            {
                x: 2014,
                y: -169
            },
            {
                x: 2015,
                y: -184
            }
        ]
    }],
    chart: {
        type: 'area',
        height: 350
    },
    dataLabels: {
        enabled: false
    },
    stroke: {
        curve: 'straight',
		width: 2
    },
	xaxis: {
        type: 'datetime',
        axisBorder: {
            show: false
        },
        axisTicks: {
            show: false
        }
    },
    yaxis: {
        tickAmount: 4,
        floating: false,

        labels: {
            style: {
                colors: '#8e8da4',
            },
            offsetY: -7,
            offsetX: 0,
        },
        axisBorder: {
            show: false,
        },
        axisTicks: {
            show: false
        }
    },
    fill: {
        opacity: 0.5
    },
    tooltip: {
        x: {
            format: "yyyy",
        },
        fixed: {
            enabled: false,
            position: 'topRight'
        }
    },
 };

var chart2 = new ApexCharts(document.querySelector("#area_chart_3"), options2);
chart2.render();

/*Stacked*/
var generateDayWiseTimeSeries = function(baseval, count, yrange) {
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
            name: 'South',
            data: generateDayWiseTimeSeries(new Date('11 Feb 2017 GMT').getTime(), 20, {
                min: 10,
                max: 60
            })
        },
        {
            name: 'North',
            data: generateDayWiseTimeSeries(new Date('11 Feb 2017 GMT').getTime(), 20, {
                min: 10,
                max: 20
            })
        },
        {
            name: 'Central',
            data: generateDayWiseTimeSeries(new Date('11 Feb 2017 GMT').getTime(), 20, {
                min: 10,
                max: 15
            })
        }
    ],
    chart: {
        type: 'area',
        height: 350,
        stacked: true,
        events: {
            selection: function(chart, e) {
                console.log(new Date(e.xaxis.min))
            }
        },
    },
    colors: ['#008FFB', '#00E396', '#CED4DC'],
    dataLabels: {
        enabled: false
    },
    stroke: {
        curve: 'smooth',
		width: 2
    },
    fill: {
        type: 'gradient',
        gradient: {
            opacityFrom: 0.6,
            opacityTo: 0.8,
        }
    },
    legend: {
        position: 'top',
        horizontalAlign: 'left'
    },
    xaxis: {
        type: 'datetime'
    },
};

var chart3 = new ApexCharts(document.querySelector("#area_chart_4"), options3);
chart3.render();

/*Irregular Timeseries*/
var ts1 = 1388534400000;
var ts2 = 1388620800000;
var ts3 = 1389052800000;

var dataSet = [
    [],
    [],
    []
];

for (var i = 0; i < 12; i++) {
    ts1 = ts1 + 86400000;
    var innerArr = [ts1, dataSeries[2][i].value];
    dataSet[0].push(innerArr)
}
for (var i = 0; i < 18; i++) {
    ts2 = ts2 + 86400000;
    var innerArr = [ts2, dataSeries[1][i].value];
    dataSet[1].push(innerArr)
}
for (var i = 0; i < 12; i++) {
    ts3 = ts3 + 86400000;
    var innerArr = [ts3, dataSeries[0][i].value];
    dataSet[2].push(innerArr)
}

var options4 = {
    series: [{
        name: 'PRODUCT A',
        data: dataSet[0]
    }, {
        name: 'PRODUCT B',
        data: dataSet[1]
    }, {
        name: 'PRODUCT C',
        data: dataSet[2]
    }],
    chart: {
        type: 'area',
        stacked: false,
        height: 350,
        zoom: {
            enabled: false
        },
    },
    dataLabels: {
        enabled: false
    },
    markers: {
        size: 0,
    },
    fill: {
        type: 'gradient',
        gradient: {
            shadeIntensity: 1,
            inverseColors: false,
            opacityFrom: 0.45,
            opacityTo: 0.05,
            stops: [20, 100, 100, 100]
        },
    },
    yaxis: {
        labels: {
            style: {
                colors: '#8e8da4',
            },
            offsetX: 0,
            formatter: function(val) {
                return (val / 1000000).toFixed(2);
            },
        },
        axisBorder: {
            show: false,
        },
        axisTicks: {
            show: false
        }
    },
    xaxis: {
        type: 'datetime',
        tickAmount: 8,
        min: new Date("01/01/2014").getTime(),
        max: new Date("01/20/2014").getTime(),
        labels: {
            rotate: -15,
            rotateAlways: true,
            formatter: function(val, timestamp) {
                return moment(new Date(timestamp)).format("DD MMM YYYY")
            }
        }
    },
	tooltip: {
        shared: true
    },
	stroke: {
        curve: 'smooth',
		width: 2
    },
    legend: {
        position: 'top',
        horizontalAlign: 'right',
        offsetX: -10
    }
};

var chart4 = new ApexCharts(document.querySelector("#area_chart_5"), options4);
chart4.render();
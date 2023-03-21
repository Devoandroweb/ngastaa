/*Apex Column Chart*/
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

/*Basic*/
var options = {
    series: [{
        name: 'Net Profit',
        data: [44, 55, 57, 56, 61, 58, 63, 60, 66]
    }, {
        name: 'Revenue',
        data: [76, 85, 101, 98, 87, 105, 91, 114, 94]
    }, {
        name: 'Free Cash Flow',
        data: [35, 41, 36, 26, 45, 48, 52, 53, 41]
    }],
    chart: {
        type: 'bar',
        height: 350
    },
    plotOptions: {
        bar: {
            horizontal: false,
            columnWidth: '55%',
        },
    },
    dataLabels: {
        enabled: false
    },
    stroke: {
        show: true,
        width: 2,
        colors: ['transparent']
    },
    xaxis: {
        categories: ['Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'],
    },
    yaxis: {
        title: {
            text: '$ (thousands)'
        }
    },
    fill: {
        opacity: 1
    },
    tooltip: {
        y: {
            formatter: function(val) {
                return "$ " + val + " thousands"
            }
        }
    }
};

var chart = new ApexCharts(document.querySelector("#column_chart_1"), options);
chart.render();

/*Stacked Column*/
var options1 = {
    series: [{
        name: 'PRODUCT A',
        data: [44, 55, 41, 67, 22, 43]
    }, {
        name: 'PRODUCT B',
        data: [13, 23, 20, 8, 13, 27]
    }, {
        name: 'PRODUCT C',
        data: [11, 17, 15, 15, 21, 14]
    }, {
        name: 'PRODUCT D',
        data: [21, 7, 25, 13, 22, 8]
    }],
    chart: {
        type: 'bar',
        height: 350,
        stacked: true,
        toolbar: {
            show: true
        },
        zoom: {
            enabled: true
        }
    },
    responsive: [{
        breakpoint: 480,
        options: {
            legend: {
                position: 'bottom',
                offsetX: -10,
                offsetY: 0
            }
        }
    }],
    plotOptions: {
        bar: {
            horizontal: false,
        },
    },
    xaxis: {
        type: 'datetime',
        categories: ['01/01/2011 GMT', '01/02/2011 GMT', '01/03/2011 GMT', '01/04/2011 GMT',
            '01/05/2011 GMT', '01/06/2011 GMT'
        ],
    },
    legend: {
        position: 'right',
        offsetY: 40
    },
    fill: {
        opacity: 1
    }
};
var chart1 = new ApexCharts(document.querySelector("#column_chart_2"), options1);
chart1.render();

/*Column with negative Value*/
var options2 = {
    series: [{
        name: 'Cash Flow',
        data: [1.45, 5.42, 5.9, -0.42, -12.6, -18.1, -18.2, -14.16, -11.1, -6.09, 0.34, 3.88, 13.07,
            5.8, 2, 7.37, 8.1, 13.57, 15.75, 17.1, 19.8, -27.03, -54.4, -47.2, -43.3, -18.6, -
            48.6, -41.1, -39.6, -37.6, -29.4, -21.4, -2.4
        ]
    }],
    chart: {
        type: 'bar',
        height: 350
    },
    plotOptions: {
        bar: {
            colors: {
                ranges: [{
                    from: -100,
                    to: -46,
                    color: '#F15B46'
                }, {
                    from: -45,
                    to: 0,
                    color: '#FEB019'
                }]
            },
            columnWidth: '80%',
        }
    },
    dataLabels: {
        enabled: false,
    },
    yaxis: {
        title: {
            text: 'Growth',
        },
        labels: {
            formatter: function(y) {
                return y.toFixed(0) + "%";
            }
        }
    },
    xaxis: {
        type: 'datetime',
        categories: [
            '2011-01-01', '2011-02-01', '2011-03-01', '2011-04-01', '2011-05-01', '2011-06-01',
            '2011-07-01', '2011-08-01', '2011-09-01', '2011-10-01', '2011-11-01', '2011-12-01',
            '2012-01-01', '2012-02-01', '2012-03-01', '2012-04-01', '2012-05-01', '2012-06-01',
            '2012-07-01', '2012-08-01', '2012-09-01', '2012-10-01', '2012-11-01', '2012-12-01',
            '2013-01-01', '2013-02-01', '2013-03-01', '2013-04-01', '2013-05-01', '2013-06-01',
            '2013-07-01', '2013-08-01', '2013-09-01'
        ],
        labels: {
            rotate: -90
        }
    }
};

var chart2 = new ApexCharts(document.querySelector("#column_chart_3"), options2);
chart2.render();



/*Distributed Column*/
var options4 = {
    series: [{
        data: [21, 22, 10, 28, 16, 21, 13, 30]
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
        categories: [
            ['John', 'Doe'],
            ['Joe', 'Smith'],
            ['Jake', 'Williams'],
            'Amber',
            ['Peter', 'Brown'],
            ['Mary', 'Evans'],
            ['David', 'Wilson'],
            ['Lily', 'Roberts'],
        ],
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

/*Dynamic Loaded Chart*/

Apex = {
    chart: {
        toolbar: {
            show: false
        }
    },
    tooltip: {
        shared: false
    },
    legend: {
        show: false
    }
}

var colors = ['#008FFB', '#00E396', '#FEB019', '#FF4560', '#775DD0', '#00D9E9', '#FF66C3'];

/**
 * Randomize array element order in-place.
 * Using Durstenfeld shuffle algorithm.
 */
function shuffleArray(array) {
    for (var i = array.length - 1; i > 0; i--) {
        var j = Math.floor(Math.random() * (i + 1));
        var temp = array[i];
        array[i] = array[j];
        array[j] = temp;
    }
    return array;
}

var arrayData = [{
    y: 400,
    quarters: [{
        x: 'Q1',
        y: 120
    }, {
        x: 'Q2',
        y: 90
    }, {
        x: 'Q3',
        y: 100
    }, {
        x: 'Q4',
        y: 90
    }]
}, {
    y: 430,
    quarters: [{
        x: 'Q1',
        y: 120
    }, {
        x: 'Q2',
        y: 110
    }, {
        x: 'Q3',
        y: 90
    }, {
        x: 'Q4',
        y: 110
    }]
}, {
    y: 448,
    quarters: [{
        x: 'Q1',
        y: 70
    }, {
        x: 'Q2',
        y: 100
    }, {
        x: 'Q3',
        y: 140
    }, {
        x: 'Q4',
        y: 138
    }]
}, {
    y: 470,
    quarters: [{
        x: 'Q1',
        y: 150
    }, {
        x: 'Q2',
        y: 60
    }, {
        x: 'Q3',
        y: 190
    }, {
        x: 'Q4',
        y: 70
    }]
}, {
    y: 540,
    quarters: [{
        x: 'Q1',
        y: 120
    }, {
        x: 'Q2',
        y: 120
    }, {
        x: 'Q3',
        y: 130
    }, {
        x: 'Q4',
        y: 170
    }]
}, {
    y: 580,
    quarters: [{
        x: 'Q1',
        y: 170
    }, {
        x: 'Q2',
        y: 130
    }, {
        x: 'Q3',
        y: 120
    }, {
        x: 'Q4',
        y: 160
    }]
}];

function makeData() {
    var dataSet = shuffleArray(arrayData)

    var dataYearSeries = [{
        x: "2011",
        y: dataSet[0].y,
        color: colors[0],
        quarters: dataSet[0].quarters
    }, {
        x: "2012",
        y: dataSet[1].y,
        color: colors[1],
        quarters: dataSet[1].quarters
    }, {
        x: "2013",
        y: dataSet[2].y,
        color: colors[2],
        quarters: dataSet[2].quarters
    }, {
        x: "2014",
        y: dataSet[3].y,
        color: colors[3],
        quarters: dataSet[3].quarters
    }, {
        x: "2015",
        y: dataSet[4].y,
        color: colors[4],
        quarters: dataSet[4].quarters
    }, {
        x: "2016",
        y: dataSet[5].y,
        color: colors[5],
        quarters: dataSet[5].quarters
    }];

    return dataYearSeries
}

function updateQuarterChart(sourceChart, destChartIDToUpdate) {
    var series = [];
    var seriesIndex = 0;
    var colors = []

    if (sourceChart.w.globals.selectedDataPoints[0]) {
        var selectedPoints = sourceChart.w.globals.selectedDataPoints;
        for (var i = 0; i < selectedPoints[seriesIndex].length; i++) {
            var selectedIndex = selectedPoints[seriesIndex][i];
            var yearSeries = sourceChart.w.config.series[seriesIndex];
            series.push({
                name: yearSeries.data[selectedIndex].x,
                data: yearSeries.data[selectedIndex].quarters
            })
            colors.push(yearSeries.data[selectedIndex].color)
        }

        if (series.length === 0) series = [{
            data: []
        }]

        return ApexCharts.exec(destChartIDToUpdate, 'updateOptions', {
            series: series,
            colors: colors,
            fill: {
                colors: colors
            }
        })
    }
}

var options3 = {
    series: [{
        data: makeData()
    }],
    chart: {
        id: 'barYear',
        height: 400,
        width: '100%',
        type: 'bar',
        events: {
            dataPointSelection: function(e, chart, opts) {
                var quarterChartEl = document.querySelector("#chart_quarter");
                var yearChartEl = document.querySelector("#chart_year");

                if (opts.selectedDataPoints[0].length === 1) {
                    if (quarterChartEl.classList.contains("active")) {
                        updateQuarterChart(chart, 'barQuarter')
                    } else {
                        yearChartEl.classList.add("chart_quarter-activated")
                        quarterChartEl.classList.add("active");
                        updateQuarterChart(chart, 'barQuarter')
                    }
                } else {
                    updateQuarterChart(chart, 'barQuarter')
                }

                if (opts.selectedDataPoints[0].length === 0) {
                    yearChartEl.classList.remove("chart_quarter-activated")
                    quarterChartEl.classList.remove("active");
                }

            },
            updated: function(chart) {
                updateQuarterChart(chart, 'barQuarter')
            }
        }
    },
    plotOptions: {
        bar: {
            distributed: true,
            horizontal: true,
            barHeight: '75%',
            dataLabels: {
                position: 'bottom'
            }
        }
    },
    dataLabels: {
        enabled: true,
        textAnchor: 'start',
        style: {
            colors: ['#fff']
        },
        formatter: function(val, opt) {
            return opt.w.globals.labels[opt.dataPointIndex]
        },
        offsetX: 0,
        dropShadow: {
            enabled: true
        }
    },

    colors: colors,

    states: {
        normal: {
            filter: {
                type: 'desaturate'
            }
        },
        active: {
            allowMultipleDataPointsSelection: true,
            filter: {
                type: 'darken',
                value: 1
            }
        }
    },
    tooltip: {
        x: {
            show: false
        },
        y: {
            title: {
                formatter: function(val, opts) {
                    return opts.w.globals.labels[opts.dataPointIndex]
                }
            }
        }
    },
    title: {
        text: 'Yearly Results',
        offsetX: 15
    },
    subtitle: {
        text: '(Click on bar to see details)',
        offsetX: 15
    },
    yaxis: {
        labels: {
            show: false
        }
    }
};

var chart3 = new ApexCharts(document.querySelector("#chart_year"), options3);
chart3.render();

var optionsQuarter = {
    series: [{
        data: []
    }],
    chart: {
        id: 'barQuarter',
        height: 400,
        width: '100%',
        type: 'bar',
        stacked: true
    },
    plotOptions: {
        bar: {
            columnWidth: '50%',
            horizontal: false
        }
    },
    legend: {
        show: false
    },

    yaxis: {
        labels: {
            show: false
        }
    },
    title: {
        text: 'Quarterly Results',
        offsetX: 10
    },
    tooltip: {
        x: {
            formatter: function(val, opts) {
                return opts.w.globals.seriesNames[opts.seriesIndex]
            }
        },
        y: {
            title: {
                formatter: function(val, opts) {
                    return opts.w.globals.labels[opts.dataPointIndex]
                }
            }
        }
    }
};

var chartQuarter = new ApexCharts(document.querySelector("#chart_quarter"), optionsQuarter);
chartQuarter.render();


chart.addEventListener('dataPointSelection', function(e, chart, opts) {
    var quarterChartEl = document.querySelector("#chart_quarter");
    var yearChartEl = document.querySelector("#chart_year");

    if (opts.selectedDataPoints[0].length === 1) {
        if (quarterChartEl.classList.contains("active")) {
            updateQuarterChart(chart, 'barQuarter')
        } else {
            yearChartEl.classList.add("chart_quarter-activated")
            quarterChartEl.classList.add("active");
            updateQuarterChart(chart, 'barQuarter')
        }
    } else {
        updateQuarterChart(chart, 'barQuarter')
    }

    if (opts.selectedDataPoints[0].length === 0) {
        yearChartEl.classList.remove("chart_quarter-activated")
        quarterChartEl.classList.remove("active");
    }

})

chart.addEventListener('updated', function(chart) {
    updateQuarterChart(chart, 'barQuarter')
})
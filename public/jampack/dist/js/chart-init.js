/*Apex Line Chart*/

/*Basic Line*/
var options = {
    series: [{
        name: "Desktops",
        data: [45, 30, 60, 50, 100, 70, 91, 30, 6, 130, 15, 10]
    }],
    chart: {
        height: 200,
        type: 'line',
        toolbar: {
            show: false
        },
        zoom: {
            enabled: false
        },
    },
    colors: ['#298DFF'],

    tooltip: {
        enabled: false,
    },
    dataLabels: {
        enabled: false
    },
    stroke: {
        curve: 'straight',
        width: 2
    },
    grid: {
        borderColor: '#F4F5F6',
        padding: {
            top: 0,
            right: 0,
            bottom: 0,
            left: 0
        }
    },
    xaxis: {
        labels: {
            show: false,
            maxWidth: 0,
        },
        axisBorder: {
            show: false,
        },
    },
    yaxis: {
        labels: {
            show: false,
            maxWidth: 0,
        },
    }
};
var chart = new ApexCharts(document.querySelector("#line_chart_1"), options);
chart.render();

/*Zoomable time series*/
var ts2 = 1484418600000;
var dates = [];
var spikes = [5, -5, 3, -3, 8, -8]
for (var i = 0; i < 120; i++) {
    ts2 = ts2 + 86400000;
    var innerArr = [ts2, dataSeries[1][i].value];
    dates.push(innerArr)
}
var options1 = {
    series: [{
        name: 'XYZ MOTORS',
        data: dates
    }],
    chart: {
        type: 'area',
        stacked: false,
        height: 200,
        toolbar: {
            show: false
        },
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
            opacityFrom: 0.5,
            opacityTo: 0,
            stops: [0, 90, 100]
        },
    },
    colors: ['#298DFF'],
    tooltip: {
        enabled: false,
    },
    dataLabels: {
        enabled: false
    },
    stroke: {
        curve: 'straight',
        width: 2
    },
    grid: {
        borderColor: '#F4F5F6',
        padding: {
            top: 0,
            right: 0,
            bottom: 0,
            left: 0
        }
    },
    xaxis: {
        labels: {
            show: false,
            maxWidth: 0,
        },
        axisBorder: {
            show: false,
        },
    },
    yaxis: {
        labels: {
            show: false,
            maxWidth: 0,
        },
    },
};

var chart1 = new ApexCharts(document.querySelector("#area_chart_1"), options1);
chart1.render();

/*Column Chart*/
var options2 = {
    series: [{
        name: 'Revenue',
        data: [56, 85, 101, 58, 87, 76, 45, 101, 98, 37, 55, 91, 114, 94, 56, 85, 101, 58, 87, 76]
    }],
    chart: {
        type: 'bar',
        height: 200,
        toolbar: {
            show: false
        },
        zoom: {
            enabled: false
        },
    },
    colors: ['#298DFF'],
    plotOptions: {
        bar: {
            horizontal: false,
            columnWidth: '45%',
        },
    },
    grid: {
        borderColor: '#F4F5F6',
        padding: {
            top: 0,
            right: 0,
            bottom: 0,
            left: 0
        }
    },
    xaxis: {
        labels: {
            show: false,
            maxWidth: 0,
        },
        axisBorder: {
            show: false,
        },
        axisTicks: {
            show: false
        }
    },
    yaxis: {
        labels: {
            show: false,
            maxWidth: 0,
        },
        axisTicks: {
            show: false
        }
    },
    tooltip: {
        enabled: false,
    },
    dataLabels: {
        enabled: false
    },
    legend: {
        show: false
    }
};

var chart2 = new ApexCharts(document.querySelector("#column_chart_1"), options2);
chart2.render();

/*Grouped Chart*/
var options3 = {
    series: [{
        data: [44, 55, 41, 64, 22, 43, 21]
    }, {
        data: [53, 32, 33, 52, 13, 44, 32]
    }],
    chart: {
        type: 'bar',
        height: 200,
        toolbar: {
            show: false
        },
        zoom: {
            enabled: false
        },
    },
    colors: ['#298DFF', '#ADB5BD'],
    plotOptions: {
        bar: {
            horizontal: true,
        }
    },

    grid: {
        borderColor: '#F4F5F6',
        padding: {
            top: 0,
            right: 0,
            bottom: 0,
            left: 0
        }
    },
    xaxis: {
        categories: [2001, 2002, 2003, 2004, 2005, 2006, 2007],
        labels: {
            show: false,
            maxWidth: 0,
        },
        axisBorder: {
            show: false,
        },
        axisTicks: {
            show: false
        }
    },
    yaxis: {
        labels: {
            show: false,
            maxWidth: 0,
        },
        axisTicks: {
            show: false
        }
    },
    tooltip: {
        enabled: false,
    },
    dataLabels: {
        enabled: false
    },
    legend: {
        show: false
    }
};

var chart3 = new ApexCharts(document.querySelector("#bar_chart_1"), options3);
chart3.render();

/*Mix Chart*/
var options4 = {
    series: [{
        name: 'Website Blog',
        type: 'column',
        data: [440, 505, 414, 671, 227, 413, 201, 352, 752, 320, 257, 160]
    }, {
        name: 'Social Media',
        type: 'line',
        data: [23, 42, 35, 27, 43, 22, 17, 31, 22, 22, 12, 16]
    }],
    chart: {
        height: 200,
        type: 'line',
        toolbar: {
            show: false
        },
        zoom: {
            enabled: false
        },
    },
    colors: ['#298DFF', '#00D67F'],
    stroke: {
        width: [0, 2]
    },
    dataLabels: {
        enabled: true,
        enabledOnSeries: [1]
    },
    labels: ['01 Jan 2001', '02 Jan 2001', '03 Jan 2001', '04 Jan 2001', '05 Jan 2001', '06 Jan 2001', '07 Jan 2001', '08 Jan 2001', '09 Jan 2001', '10 Jan 2001', '11 Jan 2001', '12 Jan 2001'],
    xaxis: {
        type: 'datetime',
        labels: {
            show: false,
            maxWidth: 0,
        },
        axisTicks: {
            show: false
        },
        axisBorder: {
            show: false,
        },
    },
    yaxis: [{
        labels: {
            show: false,
            maxWidth: 0,
        },
        axisTicks: {
            show: false
        }
    }, {
        opposite: true,
        labels: {
            show: false,
            maxWidth: 0,
        },
        axisTicks: {
            show: false
        }
    }],
    tooltip: {
        enabled: false,
    },
    legend: {
        show: false
    },
    grid: {
        borderColor: '#F4F5F6',
        padding: {
            top: 0,
            right: 0,
            bottom: 0,
            left: 0
        }
    },
};

var chart4 = new ApexCharts(document.querySelector("#mix_chart_1"), options4);
chart4.render();

/*Timeline Chart*/
var options5 = {
    series: [{
        data: [{
                x: 'Analysis',
                y: [
                    new Date('2019-02-27').getTime(),
                    new Date('2019-03-04').getTime()
                ],
                fillColor: '#FF0000'
            },
            {
                x: 'Design',
                y: [
                    new Date('2019-03-04').getTime(),
                    new Date('2019-03-08').getTime()
                ],
                fillColor: '#298DFF'
            },
            {
                x: 'Coding',
                y: [
                    new Date('2019-03-07').getTime(),
                    new Date('2019-03-10').getTime()
                ],
                fillColor: '#00B0FF'
            },
            {
                x: 'Testing',
                y: [
                    new Date('2019-03-08').getTime(),
                    new Date('2019-03-12').getTime()
                ],
                fillColor: '#18DDEF'
            },
            {
                x: 'Deployment',
                y: [
                    new Date('2019-03-12').getTime(),
                    new Date('2019-03-17').getTime()
                ],
                fillColor: '#FFC400'
            }
        ]
    }],
    chart: {
        height: 200,
        type: 'rangeBar',
        toolbar: {
            show: false
        },
    },
    plotOptions: {
        bar: {
            horizontal: true,
            distributed: true,
            dataLabels: {
                hideOverflowingLabels: false
            }
        }
    },
    dataLabels: {
        enabled: true,
        formatter: function(val, opts) {
            var label = opts.w.globals.labels[opts.dataPointIndex]
            var a = moment(val[0])
            var b = moment(val[1])
            var diff = b.diff(a, 'days')
            return label + ': ' + diff + (diff > 1 ? ' days' : ' day')
        },
        style: {
            colors: ['#f3f4f5', '#fff']
        }
    },
    xaxis: {
        type: 'datetime',
        labels: {
            show: false,
            maxWidth: 0,
        },
        axisTicks: {
            show: false
        }
    },
    yaxis: {
        show: false,
        labels: {
            show: false,
            maxWidth: 0,
        },
        axisTicks: {
            show: false
        }
    },
    grid: {
        row: {
            colors: ['#f3f4f5', '#fff'],
            opacity: 1
        },
        padding: {
            top: 0,
            right: 0,
            bottom: 0,
            left: 0
        }
    },
    tooltip: {
        enabled: false,
    },
    legend: {
        show: false
    }
};

var chart5 = new ApexCharts(document.querySelector("#tline_chart_1"), options5);
chart5.render();

/*CandleStick Chart*/
var options6 = {
    series: [{
        data: [{
                x: new Date(1538778600000),
                y: [6629.81, 6650.5, 6623.04, 6633.33]
            },
            {
                x: new Date(1538780400000),
                y: [6632.01, 6643.59, 6620, 6630.11]
            },
            {
                x: new Date(1538782200000),
                y: [6630.71, 6648.95, 6623.34, 6635.65]
            },
            {
                x: new Date(1538784000000),
                y: [6635.65, 6651, 6629.67, 6638.24]
            },
            {
                x: new Date(1538785800000),
                y: [6638.24, 6640, 6620, 6624.47]
            },
            {
                x: new Date(1538787600000),
                y: [6624.53, 6636.03, 6621.68, 6624.31]
            },
            {
                x: new Date(1538789400000),
                y: [6624.61, 6632.2, 6617, 6626.02]
            },
            {
                x: new Date(1538791200000),
                y: [6627, 6627.62, 6584.22, 6603.02]
            },
            {
                x: new Date(1538793000000),
                y: [6605, 6608.03, 6598.95, 6604.01]
            },
            {
                x: new Date(1538794800000),
                y: [6604.5, 6614.4, 6602.26, 6608.02]
            },
            {
                x: new Date(1538796600000),
                y: [6608.02, 6610.68, 6601.99, 6608.91]
            },
            {
                x: new Date(1538798400000),
                y: [6608.91, 6618.99, 6608.01, 6612]
            },
            {
                x: new Date(1538800200000),
                y: [6612, 6615.13, 6605.09, 6612]
            },
            {
                x: new Date(1538802000000),
                y: [6612, 6624.12, 6608.43, 6622.95]
            },
            {
                x: new Date(1538803800000),
                y: [6623.91, 6623.91, 6615, 6615.67]
            },
            {
                x: new Date(1538805600000),
                y: [6618.69, 6618.74, 6610, 6610.4]
            },
            {
                x: new Date(1538807400000),
                y: [6611, 6622.78, 6610.4, 6614.9]
            },
            {
                x: new Date(1538809200000),
                y: [6614.9, 6626.2, 6613.33, 6623.45]
            },
            {
                x: new Date(1538811000000),
                y: [6623.48, 6627, 6618.38, 6620.35]
            },
            {
                x: new Date(1538812800000),
                y: [6619.43, 6620.35, 6610.05, 6615.53]
            },
            {
                x: new Date(1538814600000),
                y: [6615.53, 6617.93, 6610, 6615.19]
            },
            {
                x: new Date(1538816400000),
                y: [6615.19, 6621.6, 6608.2, 6620]
            },
            {
                x: new Date(1538818200000),
                y: [6619.54, 6625.17, 6614.15, 6620]
            },
            {
                x: new Date(1538820000000),
                y: [6620.33, 6634.15, 6617.24, 6624.61]
            },
            {
                x: new Date(1538821800000),
                y: [6625.95, 6626, 6611.66, 6617.58]
            },
            {
                x: new Date(1538823600000),
                y: [6619, 6625.97, 6595.27, 6598.86]
            },
            {
                x: new Date(1538825400000),
                y: [6598.86, 6598.88, 6570, 6587.16]
            },
            {
                x: new Date(1538827200000),
                y: [6588.86, 6600, 6580, 6593.4]
            },
            {
                x: new Date(1538829000000),
                y: [6593.99, 6598.89, 6585, 6587.81]
            },
            {
                x: new Date(1538830800000),
                y: [6587.81, 6592.73, 6567.14, 6578]
            },
            {
                x: new Date(1538832600000),
                y: [6578.35, 6581.72, 6567.39, 6579]
            },
            {
                x: new Date(1538834400000),
                y: [6579.38, 6580.92, 6566.77, 6575.96]
            },
            {
                x: new Date(1538836200000),
                y: [6575.96, 6589, 6571.77, 6588.92]
            },
            {
                x: new Date(1538838000000),
                y: [6588.92, 6594, 6577.55, 6589.22]
            },
            {
                x: new Date(1538839800000),
                y: [6589.3, 6598.89, 6589.1, 6596.08]
            },
            {
                x: new Date(1538841600000),
                y: [6597.5, 6600, 6588.39, 6596.25]
            },
            {
                x: new Date(1538843400000),
                y: [6598.03, 6600, 6588.73, 6595.97]
            },
            {
                x: new Date(1538845200000),
                y: [6595.97, 6602.01, 6588.17, 6602]
            },
            {
                x: new Date(1538847000000),
                y: [6602, 6607, 6596.51, 6599.95]
            },
            {
                x: new Date(1538848800000),
                y: [6600.63, 6601.21, 6590.39, 6591.02]
            },
            {
                x: new Date(1538850600000),
                y: [6591.02, 6603.08, 6591, 6591]
            },
            {
                x: new Date(1538852400000),
                y: [6591, 6601.32, 6585, 6592]
            },
            {
                x: new Date(1538854200000),
                y: [6593.13, 6596.01, 6590, 6593.34]
            },
            {
                x: new Date(1538856000000),
                y: [6593.34, 6604.76, 6582.63, 6593.86]
            },
            {
                x: new Date(1538857800000),
                y: [6593.86, 6604.28, 6586.57, 6600.01]
            },
            {
                x: new Date(1538859600000),
                y: [6601.81, 6603.21, 6592.78, 6596.25]
            },
            {
                x: new Date(1538861400000),
                y: [6596.25, 6604.2, 6590, 6602.99]
            },
            {
                x: new Date(1538863200000),
                y: [6602.99, 6606, 6584.99, 6587.81]
            },
            {
                x: new Date(1538865000000),
                y: [6587.81, 6595, 6583.27, 6591.96]
            },
            {
                x: new Date(1538866800000),
                y: [6591.97, 6596.07, 6585, 6588.39]
            },
            {
                x: new Date(1538868600000),
                y: [6587.6, 6598.21, 6587.6, 6594.27]
            },
            {
                x: new Date(1538870400000),
                y: [6596.44, 6601, 6590, 6596.55]
            },
            {
                x: new Date(1538872200000),
                y: [6598.91, 6605, 6596.61, 6600.02]
            },
            {
                x: new Date(1538874000000),
                y: [6600.55, 6605, 6589.14, 6593.01]
            },
            {
                x: new Date(1538875800000),
                y: [6593.15, 6605, 6592, 6603.06]
            },
            {
                x: new Date(1538877600000),
                y: [6603.07, 6604.5, 6599.09, 6603.89]
            },
            {
                x: new Date(1538879400000),
                y: [6604.44, 6604.44, 6600, 6603.5]
            },
            {
                x: new Date(1538881200000),
                y: [6603.5, 6603.99, 6597.5, 6603.86]
            },
            {
                x: new Date(1538883000000),
                y: [6603.85, 6605, 6600, 6604.07]
            },
            {
                x: new Date(1538884800000),
                y: [6604.98, 6606, 6604.07, 6606]
            },
        ]
    }],
    chart: {
        type: 'candlestick',
        height: 200,
        toolbar: {
            show: false
        },
    },
	plotOptions: {
		candlestick: {
			colors: {
			  upward: '#FF0000',
			  downward: '#00D67F'
			}
		}
	},
	xaxis: {
        type: 'datetime',
        labels: {
            show: false,
            maxWidth: 0,
        },
        axisTicks: {
            show: false
        },
        axisBorder: {
            show: false,
        },
    },
    yaxis: {
        labels: {
            show: false,
            maxWidth: 0,
        },
        axisTicks: {
            show: false
        },
        tooltip: {
            enabled: true
        }
    },
    grid: {
        borderColor: '#F4F5F6',
        padding: {
            top: 0,
            right: 0,
            bottom: 0,
            left: 0
        }
    },
    tooltip: {
        enabled: false,
    },
    legend: {
        show: false
    },
    plotOptions: {
        candlestick: {
            colors: {
                upward: '#ff0000',
                downward: '#008FFB'
            }
        }
    },
};
var chart6 = new ApexCharts(document.querySelector("#cs_chart_1"), options6);
chart6.render();

/*Pie Chart*/
var options7 = {
    series: [44, 55, 13, 43, 22],
    chart: {
        height: 200,
        type: 'pie',
    },
	stroke: {
	  width: 0
	},
	dataLabels: {
	  enabled: false,
		
	},
	colors: ['#ff0000', '#008FFB', '#e92990', '#c02ff3', '#7429f8'],
    labels: ['Team A', 'Team B', 'Team C', 'Team D', 'Team E'],
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

var chart7 = new ApexCharts(document.querySelector("#pie_chart_1"), options7);
chart7.render();

/*Sparkline Chart*/

var randomizeArray = function(arg) {
    var array = arg.slice();
    var currentIndex = array.length,
        temporaryValue, randomIndex;

    while (0 !== currentIndex) {

        randomIndex = Math.floor(Math.random() * currentIndex);
        currentIndex -= 1;

        temporaryValue = array[currentIndex];
        array[currentIndex] = array[randomIndex];
        array[randomIndex] = temporaryValue;
    }

    return array;
}

// data for the sparklines that appear below header area
var sparklineData = [47, 45, 54, 38, 56, 24, 65, 31, 37, 39, 62, 51, 35, 41, 35, 27, 93, 53, 61, 27, 54, 43, 19, 46];

var optionsSpark1 = {
    series: [{
        data: randomizeArray(sparklineData)
    }],
    chart: {
        type: 'area',
        height: 200,
        width: '100%',
        sparkline: {
            enabled: true
        },

    },
	colors: ['#298DFF'],
    stroke: {
        curve: 'straight',
		width:2
    },
    fill: {
        opacity: 0.3
    },
    xaxis: {
        crosshairs: {
            width: 1
        },
    },
    yaxis: {
        min: 0
    },
    tooltip: {
        enabled: false,
    },
};

var chartSpark1 = new ApexCharts(document.querySelector("#sparkline_chart_1"), optionsSpark1);
chartSpark1.render();

/*Gradient Chart*/
var options8 = {
    series: [75],
    chart: {
        height: 300,
        type: 'radialBar',
    },
	colors: ['#298DFF'],
    plotOptions: {
        radialBar: {
            startAngle: -135,
            endAngle: 225,
            hollow: {
                margin: 0,
				size:'40%',
				stroke:100,
				background: '#fff',
                image: undefined,
                imageOffsetX: 0,
                imageOffsetY: 0,
                position: 'front',
                dropShadow: {
                    enabled: false,
                }
            },
            track: {
                background: '#ADB5BD',
				margin: 0, // margin is in pixels
                dropShadow: {
                    enabled: false,
                }
            },

            dataLabels: {
                show: true,
                name: {
                    offsetY: -10,
                    show: true,
                    color: '#646A71',
                    fontSize: '16px'
                },
                value: {
                    formatter: function(val) {
                        return parseInt(val);
                    },
                    color: '#1F2327',
                    fontSize: '30px',
                    show: true,
                }
            }
        }
    },
    fill: {
        type: 'gradient',
		  gradient: {
			shade: 'dark',
			type: 'horizontal',
			shadeIntensity: 0.5,
			gradientToColors: ['#00D67F'],
			inverseColors: true,
			opacityFrom: 1,
			opacityTo: 1,
			stops: [0, 100]
		  }
    },
    labels: ['Percent'],
    tooltip: {
        enabled: false,
    },
    legend: {
        show: false
    }
};

var chart8 = new ApexCharts(document.querySelector("#radial_chart_1"), options8);
chart8.render();
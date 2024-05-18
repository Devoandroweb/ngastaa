/*Apex sparkline Chart*/
window.Apex = {
	stroke: {
		width: 2
	},
	markers: {
		size: 0
	},
	tooltip: {
		fixed: {
			enabled: true,
		}
	}
};

var randomizeArray = function (arg) {
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

/*Basic Chart*/
var optionsSpark1 = {
	series: [{
		data: randomizeArray(sparklineData)
	}],
	chart: {
		type: 'area',
		width: 100,
		height: 35,
		sparkline: {
			enabled: true
		},
	},
	stroke: {
		curve: 'straight'
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
		fixed: {
			enabled: false
		},
		x: {
			show: false
		},
		y: {
			title: {
				formatter: function (seriesName) {
					return ''
				}
			}
		},
		marker: {
			show: false
		}
	}
};

var chartSpark1 = new ApexCharts(document.querySelector("#sparkline_chart_1"), optionsSpark1);
chartSpark1.render();

/*Sparkline for table*/
var optionsSpark2 = {
	series: [{
		data: randomizeArray(sparklineData)
	}],
	chart: {
		type: 'area',
		height: 50,
		width: 100,
		sparkline: {
			enabled: true
		},
	},
	stroke: {
		curve: 'straight',
		width: 2,
	},
	fill: {
		type: 'gradient',
		gradient: {
			shadeIntensity: 1,
			inverseColors: false,
			opacityFrom: 0.7,
			opacityTo: 0,
			stops: [10, 90, 100]
		},
	},
	colors: ['#298DFF'],
	xaxis: {
		crosshairs: {
			width: 1
		},
	},
	yaxis: {
		min: 0
	},
	tooltip: {
		fixed: {
			enabled: false
		},
		x: {
			show: false
		},
		y: {
			title: {
				formatter: function (seriesName) {
					return ''
				}
			}
		},
		marker: {
			show: false
		}
	}
};
var chartSpark2 = new ApexCharts(document.querySelector("#sparkline_chart_t1"), optionsSpark2);
chartSpark2.render();

var optionsSpark3 = {
	series: [{
		data: randomizeArray(sparklineData)
	}],
	chart: {
		type: 'area',
		height: 50,
		width: 100,
		sparkline: {
			enabled: true
		},
	},
	stroke: {
		curve: 'straight',
		width: 2,
	},
	fill: {
		type: 'gradient',
		gradient: {
			shadeIntensity: 1,
			inverseColors: false,
			opacityFrom: 0.7,
			opacityTo: 0,
			stops: [10, 90, 100]
		},
	},
	colors: ['#298DFF'],
	xaxis: {
		crosshairs: {
			width: 1
		},
	},
	yaxis: {
		min: 0
	},
	tooltip: {
		fixed: {
			enabled: false
		},
		x: {
			show: false
		},
		y: {
			title: {
				formatter: function (seriesName) {
					return ''
				}
			}
		},
		marker: {
			show: false
		}
	}
};

var chartSpark3 = new ApexCharts(document.querySelector("#sparkline_chart_t2"), optionsSpark3);
chartSpark3.render();


var optionsSpark4 = {
	series: [{
		data: randomizeArray(sparklineData)
	}],
	chart: {
		type: 'area',
		height: 50,
		width: 100,
		sparkline: {
			enabled: true
		},
	},
	stroke: {
		curve: 'straight',
		width: 2,
	},
	fill: {
		type: 'gradient',
		gradient: {
			shadeIntensity: 1,
			inverseColors: false,
			opacityFrom: 0.7,
			opacityTo: 0,
			stops: [10, 90, 100]
		},
	},
	colors: ['#298DFF'],
	xaxis: {
		crosshairs: {
			width: 1
		},
	},
	yaxis: {
		min: 0
	},
	tooltip: {
		fixed: {
			enabled: false
		},
		x: {
			show: false
		},
		y: {
			title: {
				formatter: function (seriesName) {
					return ''
				}
			}
		},
		marker: {
			show: false
		}
	}
};

var chartSpark4 = new ApexCharts(document.querySelector("#sparkline_chart_t3"), optionsSpark4);
chartSpark4.render();

var optionsSpark5 = {
	series: [{
		data: randomizeArray(sparklineData)
	}],
	chart: {
		type: 'area',
		height: 50,
		width: 100,
		sparkline: {
			enabled: true
		},
	},
	stroke: {
		curve: 'straight',
		width: 2,
	},
	fill: {
		type: 'gradient',
		gradient: {
			shadeIntensity: 1,
			inverseColors: false,
			opacityFrom: 0.7,
			opacityTo: 0,
			stops: [10, 90, 100]
		},
	},
	colors: ['#298DFF'],
	xaxis: {
		crosshairs: {
			width: 1
		},
	},
	yaxis: {
		min: 0
	},
	tooltip: {
		fixed: {
			enabled: false
		},
		x: {
			show: false
		},
		y: {
			title: {
				formatter: function (seriesName) {
					return ''
				}
			}
		},
		marker: {
			show: false
		}
	}
};

var chartSpark5 = new ApexCharts(document.querySelector("#sparkline_chart_t4"), optionsSpark5);
chartSpark5.render();
/*Line*/
var options1 = {
	series: [{
		data: [25, 66, 41, 89, 63, 25, 44, 12, 36, 9, 54]
	}],
	chart: {
		type: 'line',
		width: 100,
		height: 35,
		sparkline: {
			enabled: true
		}
	},
	tooltip: {
		fixed: {
			enabled: false
		},
		x: {
			show: false
		},
		y: {
			title: {
				formatter: function (seriesName) {
					return ''
				}
			}
		},
		marker: {
			show: false
		}
	}
};

var chart1 = new ApexCharts(document.querySelector("#sparkline_chart_2"), options1);
chart1.render();

/*Bar*/
var options2 = {
	series: [{
		data: [25, 66, 41, 89, 63, 25, 44, 12, 36, 9, 54]
	}],
	chart: {
		type: 'bar',
		width: 100,
		height: 35,
		sparkline: {
			enabled: true
		}
	},
	plotOptions: {
		bar: {
			columnWidth: '80%'
		}
	},
	labels: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
	xaxis: {
		crosshairs: {
			width: 1
		},
	},
	tooltip: {
		fixed: {
			enabled: false
		},
		x: {
			show: false
		},
		y: {
			title: {
				formatter: function (seriesName) {
					return ''
				}
			}
		},
		marker: {
			show: false
		}
	}
};

var chart2 = new ApexCharts(document.querySelector("#sparkline_chart_3"), options2);
chart2.render();

/*pie*/
var options3 = {
	series: [43, 32, 12, 9],
	chart: {
		type: 'pie',
		width: 40,
		height: 40,
		sparkline: {
			enabled: true
		}
	},
	stroke: {
		width: 1
	},
	tooltip: {
		fixed: {
			enabled: false
		},
	}
};

var chart3 = new ApexCharts(document.querySelector("#sparkline_chart_4"), options3);
chart3.render();

/*Donut*/
var options4 = {
	series: [43, 32, 12, 9],
	chart: {
		type: 'donut',
		width: 40,
		height: 40,
		sparkline: {
			enabled: true
		}
	},
	stroke: {
		width: 1
	},
	tooltip: {
		fixed: {
			enabled: false
		},
	}
};

var chart4 = new ApexCharts(document.querySelector("#sparkline_chart_5"), options4);
chart4.render();

/*Radial*/
var options5 = {
	series: [45],
	chart: {
		type: 'radialBar',
		width: 50,
		height: 50,
		sparkline: {
			enabled: true
		}
	},
	dataLabels: {
		enabled: false
	},
	plotOptions: {
		radialBar: {
			hollow: {
				margin: 0,
				size: '50%'
			},
			track: {
				margin: 0
			},
			dataLabels: {
				show: false
			}
		}
	}
};

var chart5 = new ApexCharts(document.querySelector("#sparkline_chart_6"), options5);
chart5.render();


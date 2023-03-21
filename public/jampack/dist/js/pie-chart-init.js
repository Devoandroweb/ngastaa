/*Apex pie Chart*/
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

/*Basic Chart*/
 var options = {
  series: [44, 55, 13, 43, 22],
  chart: {
  width: 380,
  type: 'pie',
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

var chart = new ApexCharts(document.querySelector("#pie_chart_1"), options);
chart.render();

/*Donut Chart*/
var options1 = {
  series: [44, 55, 41, 17, 15],
  chart: {
  type: 'donut',
  width: 380,
},
colors: ['#ff0000', '#008FFB', '#e92990', '#c02ff3', '#7429f8'],
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

var chart1 = new ApexCharts(document.querySelector("#pie_chart_2"), options1);
chart1.render();


/*Donut Update*/
var options2 = {
	  series: [44, 55, 13, 33],
	  chart: {
	  width: 380,
	  type: 'donut',
	},
	dataLabels: {
	  enabled: false
	},
  colors: ['#ff0000', '#008FFB', '#e92990', '#c02ff3', '#7429f8'],
	responsive: [{
	  breakpoint: 480,
	  options: {
		chart: {
		  width: 200
		},
		legend: {
		  show: false
		}
	  }
	}],
	legend: {
	  position: 'right',
	  offsetY: 0,
	  height: 230,
	}
};

var chart2 = new ApexCharts(document.querySelector("#pie_chart_3"), options2);
chart2.render();


function appendData() {
var arr = chart2.w.globals.series.slice()
arr.push(Math.floor(Math.random() * (100 - 1 + 1)) + 1)
return arr;
}

function removeData() {
var arr = chart2.w.globals.series.slice()
arr.pop()
return arr;
}

function randomize() {
return chart2.w.globals.series.map(function() {
	return Math.floor(Math.random() * (100 - 1 + 1)) + 1
})
}

function reset() {
return options.series
}

document.querySelector("#randomize").addEventListener("click", function() {
chart2.updateSeries(randomize())
})

document.querySelector("#add").addEventListener("click", function() {
chart2.updateSeries(appendData())
})

document.querySelector("#remove").addEventListener("click", function() {
chart2.updateSeries(removeData())
})

document.querySelector("#reset").addEventListener("click", function() {
chart2.updateSeries(reset())
})

/*Monochrome Pie*/
var options3 = {
  series: [25, 15, 44, 55, 41, 17],
  chart: {
  width: 380,
  type: 'pie',
},
labels: ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
theme: {
  monochrome: {
	enabled: true,
  color: '#ff0000',
  },
 
},
plotOptions: {
  pie: {
	dataLabels: {
	  offset: -5
	}
  }
},
title: {
  text: "Number of leads"
},
dataLabels: {
  formatter(val, opts) {
	const name = opts.w.globals.labels[opts.seriesIndex]
	return [name, val.toFixed(1) + '%']
  }
},
legend: {
  show: false
}
};

var chart3 = new ApexCharts(document.querySelector("#pie_chart_4"), options3);
chart3.render();

/*Gradient Donut*/
var options4 = {
  series: [44, 55, 41, 17, 15],
  chart: {
  width: 380,
  type: 'donut',
},
dataLabels: {
  enabled: false
},
colors: ['#ff0000', '#008FFB', '#e92990', '#c02ff3', '#7429f8'],
fill: {
  type: 'gradient',
},
legend: {
  formatter: function(val, opts) {
	return val + " - " + opts.w.globals.series[opts.seriesIndex]
  }
},
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

var chart4 = new ApexCharts(document.querySelector("#pie_chart_5"), options4);
chart4.render();






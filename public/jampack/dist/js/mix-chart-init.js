/*Apex mix Chart*/
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
  height: 350,
  type: 'line',
},
stroke: {
  width: [0, 2]
},

dataLabels: {
  enabled: true,
  enabledOnSeries: [1]
},
labels: ['01 Jan 2001', '02 Jan 2001', '03 Jan 2001', '04 Jan 2001', '05 Jan 2001', '06 Jan 2001', '07 Jan 2001', '08 Jan 2001', '09 Jan 2001', '10 Jan 2001', '11 Jan 2001', '12 Jan 2001'],
xaxis: {
  type: 'datetime'
},
yaxis: [{
  title: {
	text: 'Website Blog',
  },

}, {
  opposite: true,
  title: {
	text: 'Social Media'
  }
}]
};

var chart = new ApexCharts(document.querySelector("#mix_chart_1"), options);
chart.render();

/*Multiple Y-Axis*/
var options1 = {
  series: [{
  name: 'Income',
  type: 'column',
  data: [1.4, 2, 2.5, 1.5, 2.5, 2.8, 3.8, 4.6]
}, {
  name: 'Cashflow',
  type: 'column',
  data: [1.1, 3, 3.1, 4, 4.1, 4.9, 6.5, 8.5]
}, {
  name: 'Revenue',
  type: 'line',
  data: [20, 29, 37, 36, 44, 45, 50, 58]
}],
  chart: {
  height: 350,
  type: 'line',
  stacked: false
},
dataLabels: {
  enabled: false
},
stroke: {
  width: [1, 1, 2]
},

xaxis: {
  categories: [2009, 2010, 2011, 2012, 2013, 2014, 2015, 2016],
},
yaxis: [
  {
	axisTicks: {
	  show: true,
	},
	axisBorder: {
	  show: true,
	  color: '#008FFB'
	},
	labels: {
	  style: {
		colors: '#008FFB',
	  }
	},
	title: {
	  text: "Income (thousand crores)",
	  style: {
		color: '#008FFB',
	  }
	},
	tooltip: {
	  enabled: true
	}
  },
  {
	seriesName: 'Income',
	opposite: true,
	axisTicks: {
	  show: true,
	},
	axisBorder: {
	  show: true,
	  color: '#00E396'
	},
	labels: {
	  style: {
		colors: '#00E396',
	  }
	},
	title: {
	  text: "Operating Cashflow (thousand crores)",
	  style: {
		color: '#00E396',
	  }
	},
  },
  {
	seriesName: 'Revenue',
	opposite: true,
	axisTicks: {
	  show: true,
	},
	axisBorder: {
	  show: true,
	  color: '#FEB019'
	},
	labels: {
	  style: {
		colors: '#FEB019',
	  },
	},
	title: {
	  text: "Revenue (thousand crores)",
	  style: {
		color: '#FEB019',
	  }
	}
  },
],
tooltip: {
  fixed: {
	enabled: true,
	position: 'topLeft', // topRight, topLeft, bottomRight, bottomLeft
	offsetY: 30,
	offsetX: 60
  },
},
legend: {
  horizontalAlign: 'left',
  offsetX: 40
}
};

var chart1 = new ApexCharts(document.querySelector("#mix_chart_2"), options1);
chart1.render();

/*Line and Area*/
var options2 = {
  series: [{
  name: 'TEAM A',
  type: 'area',
  data: [44, 55, 31, 47, 31, 43, 26, 41, 31, 47, 33]
}, {
  name: 'TEAM B',
  type: 'line',
  data: [55, 69, 45, 61, 43, 54, 37, 52, 44, 61, 43]
}],
  chart: {
  height: 350,
  type: 'line',
},
stroke: {
  curve: 'smooth',
  width:2
},
fill: {
  type:'solid',
  opacity: [0.35, 1],
},
labels: ['Dec 01', 'Dec 02','Dec 03','Dec 04','Dec 05','Dec 06','Dec 07','Dec 08','Dec 09 ','Dec 10','Dec 11'],
markers: {
  size: 0
},
yaxis: [
  {
	title: {
	  text: 'Series A',
	},
  },
  {
	opposite: true,
	title: {
	  text: 'Series B',
	},
  },
],
tooltip: {
  shared: true,
  intersect: false,
  y: {
	formatter: function (y) {
	  if(typeof y !== "undefined") {
		return  y.toFixed(0) + " points";
	  }
	  return y;
	}
  }
}
};

var chart2 = new ApexCharts(document.querySelector("#mix_chart_3"), options2);
chart2.render();

/*Line Scatter*/
var options3 = {
	series: [{
	name: 'Points',
	type: 'scatter',

	//2.14, 2.15, 3.61, 4.93, 2.4, 2.7, 4.2, 5.4, 6.1, 8.3
	data: [{
	x: 1,
	y: 2.14
	}, {
	x: 1.2,
	y: 2.19
	}, {
	x: 1.8,
	y: 2.43
	}, {
	x: 2.3,
	y: 3.8
	}, {
	x: 2.6,
	y: 4.14
	}, {
	x: 2.9,
	y: 5.4
	}, {
	x: 3.2,
	y: 5.8
	}, {
	x: 3.8,
	y: 6.04
	}, {
	x: 4.55,
	y: 6.77
	}, {
	x: 4.9,
	y: 8.1
	}, {
	x: 5.1,
	y: 9.4
	}, {
	x: 7.1,
	y: 7.14
	},{
	x: 9.18,
	y: 8.4
	}]
	}, {
	name: 'Line',
	type: 'line',
	data: [{
	x: 1,
	y: 2
	}, {
	x: 2,
	y: 3
	}, {
	x: 3,
	y: 4
	}, {
	x: 4,
	y: 5
	}, {
	x: 5,
	y: 6
	}, {
	x: 6,
	y: 7
	}, {
	x: 7,
	y: 8
	}, {
	x: 8,
	y: 9
	}, {
	x: 9,
	y: 10
	}, {
	x: 10,
	y: 11
	}]
	}],
	chart: {
	height: 350,
	type: 'line',
	},
	fill: {
	type:'solid',
	},
	markers: {
	size: [6, 0]
	},
	stroke: {
	  width:2
	},
	tooltip: {
	shared: false,
	intersect: true,
	},
	legend: {
	show: false
	},
	
	xaxis: {
	type: 'numeric',
	min: 0,
	max: 12,
	tickAmount: 12
	}
};

var chart3 = new ApexCharts(document.querySelector("#mix_chart_4"), options3);
chart3.render();



<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Highcharts Pie Chart</title>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>

<script type="text/javascript">


$(document).ready(function() {
var options = {
chart: {
		renderTo: 'container',
		plotBackgroundColor: null,
		plotBorderWidth: null,
		plotShadow: false
		},
exporting: {
        buttons: {
            contextButtons: {
                enabled: false,
                menuItems: null
            }
        },
        enabled: false
    }, 
title: {
	text: '2G',
	margin: 0,
    y: 5,
    x: 0,
	align: 'center',
	verticalAlign: 'middle',
	style: {
        fontFamily: 'monospace',
		fontSize: '20px',
        color: "#999396"
	},
    floating: true
},
tooltip: {
	formatter: function() {
	return '<b>'+ this.point.name +'</b>: '+ roundNumber(this.percentage,2) +' %';
}
},

plotOptions: {
pie: {
size: 90,
                    innerSize: 75,
                    depth: 45,

	allowPointSelect: true,
	cursor: 'pointer',
	dataLabels: {
	enabled: false,
	color: '#000000',
	connectorColor: '#000000',
	formatter: function() {
		return '<b>'+ this.point.name +'</b>: '+ roundNumber(this.percentage,2) +' %';
		}
	},
	showInLegend:false
	}
},

credits: {
      enabled: false
  },

series: [{
	type: 'pie',
	innerSize: '70%',
	name: 'Browser share',
	colors: ['#FA5858', '#0099FF'],
	data: []
	}]
}
 
$.getJSON("data.php", function(json) {
	options.series[0].data = json;
	chart = new Highcharts.Chart(options);
	});
 
 
});





$(document).ready(function() {
var options = {
	chart: {
		renderTo: 'container2',
		plotBackgroundColor: null,
		plotBorderWidth: null,
		plotShadow: false
		},
exporting: {
        buttons: {
            contextButtons: {
                enabled: false,
                menuItems: null
            }
        },
        enabled: false
    }, 
title: {
	text: '3G',
	margin: 0,
    y: 5,
    x: 0,
	align: 'center',
	verticalAlign: 'middle',
	style: {
        fontFamily: 'monospace',
		fontSize: '20px',
        color: "#999396"
	},
    floating: true
},
tooltip: {
	formatter: function() {
	return '<b>'+ this.point.name +'</b>: '+ roundNumber(this.percentage,2) +' %';
}
},

plotOptions: {
pie: {
size: 90,
                    innerSize: 75,
                    depth: 45,

	allowPointSelect: true,
	cursor: 'pointer',
	dataLabels: {
	enabled: false,
	color: '#000000',
	connectorColor: '#000000',
	formatter: function() {
		return '<b>'+ this.point.name +'</b>: '+ roundNumber(this.percentage,2) +' %';
		}
	},
	showInLegend:false
	}
},

credits: {
      enabled: false
  },

series: [{
	type: 'pie',
	innerSize: '70%',
	name: 'Browser share',
	colors: ['#FA5858', '#0099FF'],
	data: []
	}]
}
 
$.getJSON("data3g.php", function(json) {
	options.series[0].data = json;
	chart = new Highcharts.Chart(options);
	});
 
 
});




$(document).ready(function() {
var options = {
	chart: {
		renderTo: 'container3',
		plotBackgroundColor: null,
		plotBorderWidth: null,
		plotShadow: false
		},
exporting: {
        buttons: {
            contextButtons: {
                enabled: false,
                menuItems: null
            }
        },
        enabled: false
    }, 
title: {
	text: '4G',
	margin: 0,
    y: 5,
    x: 0,
	align: 'center',
	verticalAlign: 'middle',
	style: {
        fontFamily: 'monospace',
		fontSize: '20px',
        color: "#999396"
	},
    floating: true
},
tooltip: {
	formatter: function() {
	return '<b>'+ this.point.name +'</b>: '+ roundNumber(this.percentage,2) +' %';
}
},

plotOptions: {
pie: {
size: 90,
                    innerSize: 75,
                    depth: 45,
	allowPointSelect: true,
	cursor: 'pointer',
	dataLabels: {
	enabled: false,
	color: '#000000',
	connectorColor: '#000000',
	formatter: function() {
		return '<b>'+ this.point.name +'</b>: '+ roundNumber(this.percentage,2) +' %';
		}
	},
	showInLegend:false
	}
},

credits: {
      enabled: false
  },

series: [{
	type: 'pie',
	innerSize: '70%',
	name: 'Browser share',
	colors: ['#FA5858', '#0099FF'],
	data: []
	}]
}
 
$.getJSON("data4g.php", function(json) {
	options.series[0].data = json;
	chart = new Highcharts.Chart(options);
	});
 
 
});


$(document).ready(function() {
var options = {
	chart: {
		renderTo: 'containerpku1',
		plotBackgroundColor: null,
		plotBorderWidth: null,
		plotShadow: false
		},
title: {
	text: '2G',
	margin: 0,
    y: 5,
    x: 0,
	align: 'center',
	verticalAlign: 'middle',
	style: {
        fontFamily: 'monospace',
		fontSize: '20px',
        color: "#999396"
	},
    floating: true
},
tooltip: {
	formatter: function() {
	return '<b>'+ this.point.name +'</b>: '+ roundNumber(this.percentage,2) +' %';
}
},

plotOptions: {
pie: {
	allowPointSelect: true,
	cursor: 'pointer',
	dataLabels: {
	enabled: false,
	color: '#000000',
	//connectorColor: '#000000',
	formatter: function() {
		return '<b>'+ this.point.name +'</b>: '+ roundNumber(this.percentage,2) +' %';
		}
	},
	showInLegend:false
	}
},

credits: {
      enabled: false
  },

series: [{
	type: 'pie',
	innerSize: '70%',
	name: 'Browser share',
	colors: ['#FA5858', '#0099FF'],
	data: []
	}]
}
 
$.getJSON("data-pku.php", function(json) {
	options.series[0].data = json;
	chart = new Highcharts.Chart(options);
	});
 
 
});


$(document).ready(function() {
var options = {
	chart: {
		renderTo: 'containerpku2',
		plotBackgroundColor: null,
		plotBorderWidth: null,
		plotShadow: false
		},
title: {
	text: '3G',
	margin: 0,
    y: 5,
    x: 0,
	align: 'center',
	verticalAlign: 'middle',
	style: {
        fontFamily: 'monospace',
		fontSize: '20px',
        color: "#999396"
	},
    floating: true
},
tooltip: {
	formatter: function() {
	return '<b>'+ this.point.name +'</b>: '+ roundNumber(this.percentage,2) +' %';
}
},

plotOptions: {
pie: {
	allowPointSelect: true,
	cursor: 'pointer',
	dataLabels: {
	enabled: false,
	color: '#000000',
	//connectorColor: '#000000',
	formatter: function() {
		return '<b>'+ this.point.name +'</b>: '+ roundNumber(this.percentage,2) +' %';
		}
	},
	showInLegend:false
	}
},


credits: {
      enabled: false
  },

series: [{
	type: 'pie',
	innerSize: '70%',
	name: 'Browser share',
	colors: ['#FA5858', '#0099FF'],
	data: []
	}]
}
 
$.getJSON("data3g-pku.php", function(json) {
	options.series[0].data = json;
	chart = new Highcharts.Chart(options);
	});
 
 
});


$(document).ready(function() {
var options = {
	chart: {
		renderTo: 'containerpku3',
		plotBackgroundColor: null,
		plotBorderWidth: null,
		plotShadow: false
		},
title: {
	text: '4G',
	margin: 0,
    y: 5,
    x: 0,
	align: 'center',
	verticalAlign: 'middle',
	style: {
        fontFamily: 'monospace',
		fontSize: '20px',
        color: "#999396"
	},
    floating: true
},
tooltip: {
	formatter: function() {
	return '<b>'+ this.point.name +'</b>: '+ roundNumber(this.percentage,2) +' %';
}
},

plotOptions: {
pie: {
	allowPointSelect: true,
	cursor: 'pointer',
	dataLabels: {
	enabled: false,
	color: '#000000',
	//connectorColor: '#000000',
	formatter: function() {
		return '<b>'+ this.point.name +'</b>: '+ roundNumber(this.percentage,2) +' %';
		}
	},
	showInLegend:false
	}
},

credits: {
      enabled: false
  },

series: [{
	type: 'pie',
	innerSize: '70%',
	name: 'Browser share',
	colors: ['#FA5858', '#0099FF'],
	data: []
	}]
}
 
$.getJSON("data4g-pku.php", function(json) {
	options.series[0].data = json;
	chart = new Highcharts.Chart(options);
	});
 
 
});

	  function roundNumber(rnum, rlength) { 
		var newnumber = Math.round(rnum * Math.pow(10, rlength)) / Math.pow(10, rlength);
		return newnumber;	
		}	
</script>
</head>
<body>
</body>
</html>
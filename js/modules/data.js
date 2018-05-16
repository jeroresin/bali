$(function() {
	//Highcharts with mySQL and PHP - Ajax101.com

	var Dates = [];
	var Availability = [];
	var switch1 = true;
	$.get('values.php', function(data) {

		data = data.split('/');
		for (var i in data) {
			if (switch1 == true) {
				Dates.push(data[i]);
				switch1 = false;
			} else {
				Availability.push(parseFloat(data[i]));
				switch1 = true;
			}

		}
		Dates.pop();

		$('#chart').highcharts({
			chart : {
				type : 'spline'
			},
			title : {
				text : 'Nokia LTE RAN Availability'
			},
			subtitle : {
				text : 'Source: Nokia OSS'
			},
			xAxis : {
				title : {
					text : 'Dates'
				},
				categories : Dates
			},
			yAxis : {
				title : {
					text : 'Availability'
				},
				labels : {
					formatter : function() {
						return this.value + 'Availability'
					}
				}
			},
			tooltip : {
				crosshairs : true,
				shared : true,
				valueSuffix : ''
			},
			plotOptions : {
				spline : {
					marker : {
						radius : 4,
						lineColor : '#666666',
						lineWidth : 1
					}
				}
			},
			series : [{

				name : 'Availability',
				data : Availability
			}]
		});
	});
}); 
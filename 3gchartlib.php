

<?php 
function drawchart($targetdiv,$titlechart,$tanggal,$cluster,$kpi,$strlimit,$colorch) {
echo "<script>
	var colors = Highcharts.getOptions().colors;
	jQuery(function() {
	chart = new Highcharts.Chart({
		  chart: {
			 renderTo: '".$targetdiv."',
			 defaultSeriesType: 'line',
			 height: 300,
			 borderColor: \"#335cad\",
			 borderRadius: 3,
			 borderWidth: 1,
			 events: {
                load:function(){
                                this.renderer.image('./images/tselhuawei.png', '77.5%', 4, 95, 30).add();
                            } 
            }
		  },
		  credits: {
                enabled: false
            },
		  title: {
			text: '".$titlechart."',
			style: {
            color: '#B40404',
            fontWeight: 'bold',
						fontSize: '17px'
        }
		},
		  yAxis: {
			 
			title: {
				text: ''			}
		},

		plotOptions: {
			series: {
				marker: {
					enabled: false
				}
			}
		},


		 xAxis: {
			categories:[".join($tanggal, ',')."]
			},
			
		 series: [{
			 name:	'".$cluster."',
			 data: [".join($kpi, ',')."],
			 zoneAxis: 'x',
			 zones: [{
			 value: ".$strlimit.",
						color: colors[0]			
					}, {
			 color: ".$colorch."
					}]
		  }]
		});
	});
	</script>";
}


function drawchartwithbaseline($targetdiv,$titlechart,$tanggal,$cluster,$kpi,$strlimit,$colorch,$baseline) {
echo "<script>
	var colors = Highcharts.getOptions().colors;
	jQuery(function() {
	chart = new Highcharts.Chart({
		  chart: {
			 renderTo: '".$targetdiv."',
			 defaultSeriesType: 'line',
			 height: 300,
			 borderColor: \"#335cad\",
			 borderRadius: 3,
			 borderWidth: 1,
			 events: {
                load:function(){
                                this.renderer.image('./images/tselhuawei.png', '77.5%', 4, 95, 30).add();
                            } 
            }
		  },
		  credits: {
                enabled: false
            },
		  title: {
			text: '".$titlechart."',
			style: {
            color: '#B40404',
            fontWeight: 'bold',
						fontSize: '17px'
        }
		},
		  yAxis: {
			  
			plotLines: [{
                value: ".$baseline.",
                color: 'red',
                dashStyle: 'shortdash',
                width: 3,
				min : 0,
                label: {
                    text: ''
                }
			}],
			title: {
				text: ''
			}
		},

		plotOptions: {
			series: {
				marker: {
					enabled: false
				},
				connectNulls: true
			}
		},


		 xAxis: {
			categories:[".join($tanggal, ',')."]
			},
			
		 series: [{
			 name:	'".$cluster."',
			 data: [".join($kpi, ',')."],
			 zoneAxis: 'x',
			 zones: [{
				value: ".$strlimit.",
				color: colors[0]			
						}, {
				color: ".$colorch."
				}]
		 	 },
			  {
                name: 'Baseline',
                        type: 'scatter',
                        marker: {
                    enabled: false
                },
                data: [".$baseline."],
				color: colors[8]

            }]
		});
	});
	</script>";
}
?>

<script>
	  function roundNumber(rnum, rlength) { 
		var newnumber = Math.round(rnum * Math.pow(10, rlength)) / Math.pow(10, rlength);
		return newnumber;	
		}	
</script>
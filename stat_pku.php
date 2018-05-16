

 
    <!-- memasukan jquery sebagai plugin tambahan -->

 
    <!-- membuat fungsi untuk menampilkan diagram batang ke dalam <div id="suara"></div> -->
    <script type="text/javascript">


	
    $(document).ready(function() {
        $('#suara').highcharts({
            chart: {
				
                type: 'pie',
                options3d: {
                    enabled: false,
                    alpha: 45
                }
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
				text: "2G",
                margin: 0,
                y: 5,
                x: 0,
                align: 'center',
                verticalAlign: 'middle',
				style: {
        fontFamily: 'monospace',
		fontSize: '20px',
        color: "#999396"
    }
            },
            subtitle: {
                text: null
            },
            plotOptions: {
			series: {
                dataLabels: {
                    enabled: false,
				
                    formatter: function() {
                        return '<span style="color:' + this.point.color + '"; "fontsize:25px">' + Math.round(this.percentage*100)/100 + ' %' + '</span>';
                    },
                    distance: -80
					
                }
            },
                pie: {
				size: 90,
                    innerSize: 70,
                    depth: 45
                }
            },
            series: [{  
                name: 'Sites ',
					colors: ['#FA5858', '#7d9bdd'],
                data: <?php include('data.php'); ?>  
            }]
			            
        });
		
		
    });
	
	
    </script>
	 <script type="text/javascript">


	
    $(document).ready(function() {
        $('#3gdat').highcharts({
            chart: {
				
                type: 'pie',
                options3d: {
                    enabled: false,
                    alpha: 45
                }
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
				text: "3G",
                margin: 0,
                y: 5,
                x: 0,
                align: 'center',
                verticalAlign: 'middle',
				style: {
        fontFamily: 'monospace',
		fontSize: '20px',
        color: "#999396"
    }
            },
            subtitle: {
                text: null
            },
            plotOptions: {
			series: {
                dataLabels: {
                    enabled: false,
				
                    formatter: function() {
                        return '<span style="color:' + this.point.color + '"; "fontsize:25px">' + Math.round(this.percentage*100)/100 + ' %' + '</span>';
                    },
                    distance: -80
					
                }
            },
                pie: {
				size: 90,
                    innerSize: 70,
                    depth: 45
                }
            },
            series: [{  
                name: 'Sites ',
					colors: ['#FA5858', '#7d9bdd'],
                data: <?php include('data3g.php'); ?>  
            }]
			            
        });
		
		
    });
	
	
    </script>

 <script type="text/javascript">


	
    $(document).ready(function() {
        $('#4gdat').highcharts({
            chart: {
				
                type: 'pie',
                options3d: {
                    enabled: false,
                    alpha: 45
                }
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
				text: "4G",
                margin: 0,
                y: 5,
                x: 0,
                align: 'center',
                verticalAlign: 'middle',
				style: {
        fontFamily: 'monospace',
		fontSize: '20px',
        color: "#999396"
    }
            },
            subtitle: {
                text: null
            },
            plotOptions: {
			series: {
                dataLabels: {
                    enabled: false,
				
                    
                }
            },
                pie: {
				size: 90,
                    innerSize: 70,
                    depth: 45
                }
            },
            series: [{  
                name: 'Sites ',
					colors: ['#FA5858', '#7d9bdd'],
                data: <?php include('data4g.php'); ?>  
            }]
			            
        });
		
		
    });
	
	
    </script>
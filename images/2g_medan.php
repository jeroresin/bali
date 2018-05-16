<!DOCTYPE html >
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <title>.:OSS Center Huawei 2017:.</title>
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
    </style>
	
	<style>
		body {
			font-family: "Lato", sans-serif;
			transition: background-color .5s;
		}

		.sidenav {
			height: 100%;
			width: 0;
			position: fixed;
			z-index: 1;
			top: 0;
			left: 0;
			background-color: #111;
			overflow-x: hidden;
			transition: 0.5s;
			padding-top: 60px;
		}

		.sidenav a {
			padding: 8px 8px 8px 32px;
			text-decoration: none;
			font-size: 20px;
			color: #818181;
			display: block;
			transition: 0.3s
		}

		.sidenav a:hover, .offcanvas a:focus{
			color: #f1f1f1;
		}

		.sidenav .closebtn {
			position: absolute;
			top: 0;
			right: 25px;
			font-size: 36px;
			margin-left: 50px;
		}

		#main {
			transition: margin-left .5s;
			padding: 16px;
		}

		@media screen and (max-height: 250px) {
		  .sidenav {padding-top: 15px;}
		  .sidenav a {font-size: 18px;}
		}
		
		table {
			float:right;
		}
		
		table.roundedCorners { 
		  border: 1px solid Grey;
		  border-radius: 8px; 
		  border-spacing: 0;
		}
		table.roundedCorners td, 
		table.roundedCorners th {
		  padding: 4px; 
		}
		table.roundedCorners tr:last-child > td {
		  border-bottom: none;
		}
	</style>
	<script type="text/javascript" src="plugins/js/jquery.min.js"></script>
    <script type="text/javascript" src="plugins/js/jquery.min.js"></script>
    <script type="text/javascript" src="plugins/highcharts/highcharts.js"></script>
	<script type="text/javascript" src="plugins/highcharts/themes/grid-light.js"></script>
	<script type="text/javascript" src="plugins/highcharts/modules/no-data-to-display.js"></script>
	
	
  </head>
	
  <body>
  <?
	#Include the connect.php file
	include('connect.php');
	#Connect to the database
	//connection String
	$connect = mysql_connect($hostname, $username, $password)
	or die('Could not connect: ' . mysql_error());
	//Select The database
	$bool = mysql_select_db($database, $connect);
	if ($bool === False){
	   print "can't find $database";
	}
	
	// panggil fungsi untuk swap status
	require_once('swapstatus.php');
	
	// define variables and set to empty values
		$aggr = $sd = $ed = $objname = $aggrselect = "";

	
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
	  $aggr = test_input($_POST["optaggr"]);
	  $sd = test_input($_POST["sd"]);
	  $ed = test_input($_POST["ed"]);
	  $objname = test_input($_POST["optobjname"]);
	}

	function test_input($data) {
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  return $data;
	}

	
	
	$c1 = mysql_query("SELECT * FROM 2g_siteID_ceklist  WHERE status = 'swapped'", $connect);
	$num_rows_c1 = mysql_num_rows($c1);
	
	$c2 = mysql_query("SELECT * FROM 2g_siteID_ceklist WHERE status = 'not_swap'", $connect);
	$num_rows_c2 = mysql_num_rows($c2);
	
		if ($aggr == "Site") {
		$aggrselect = "SITEID";
		$colorch = "colors[8]";
		$limitbefore = mysql_query("SELECT Date, ".$aggrselect.", `TCH_BLOCK_(%)`, `SD_BLOCK_(%)`, SDSR, `TBF_DL_Est_(%)`, `TCH_DROP_CALL_(%)`, `TBF_COMP_(%)`, HOSR, `DL_QUAL_050_(%)`, `Traffic (TCH) erl`, `SDCCH_TRAFFIC`,  `PAYLOAD_GPRS_Mbyte`, `PAYLOAD_EDGE_Mbyte` FROM ".$aggr."2GDay WHERE ".$aggrselect."='".$objname."' And Remarks='Ericsson' And Date >=".$sd." AND Date <=".$ed." And Region = 'SUMBAGUT' ORDER BY Date",$connect);
	} Else {
		$aggrselect = $aggr;
		$colorch = "colors[0]";
		$limitbefore = mysql_query("SELECT Date, ".$aggrselect.", `TCH_BLOCK_(%)`, `SD_BLOCK_(%)`, SDSR, `TBF_DL_Est_(%)`, `TCH_DROP_CALL_(%)`, `TBF_COMP_(%)`, HOSR, `DL_QUAL_050_(%)`, `Traffic (TCH) erl`, `SDCCH_TRAFFIC`,  `PAYLOAD_GPRS_Mbyte`, `PAYLOAD_EDGE_Mbyte` FROM ".$aggr."2GDay WHERE ".$aggrselect."='".$objname."' And Date >=".$sd." AND Date <=".$ed." And Region = 'SUMBAGUT' ORDER BY Date",$connect);
	}
	

	$result = mysql_query("SELECT Date, ".$aggrselect.", `TCH_BLOCK_(%)`, `SD_BLOCK_(%)`, SDSR, `TBF_DL_Est_(%)`, `TCH_DROP_CALL_(%)`, `TBF_COMP_(%)`, HOSR, `DL_QUAL_050_(%)`, `Traffic (TCH) erl`, `SDCCH_TRAFFIC`,  `PAYLOAD_GPRS_Mbyte`, `PAYLOAD_EDGE_Mbyte` FROM ".$aggr."2GDay WHERE ".$aggrselect."='".$objname."' AND Date >=".$sd." AND Date <=".$ed." And Region = 'SUMBAGUT' ORDER BY Date",$connect);
	while ($row = mysql_fetch_array($result)) {
		$tchblockrate[] = $row['TCH_BLOCK_(%)'];
		$sdblockrate[] = $row['SD_BLOCK_(%)'];
		$sdsr[] = $row['SDSR'];
		$tbfdlest[] = $row['TBF_DL_Est_(%)'];
		$tdr[] = $row['TCH_DROP_CALL_(%)'];
		$tbfcomp[] = $row['TBF_COMP_(%)'];
		$dlqual[] = $row['DL_QUAL_050_(%)'];
		$hosr[] = $row['HOSR'];
		$traffictch[] = $row['Traffic (TCH) erl'];
		$trafficsd[] = $row['SDCCH_TRAFFIC'];
		$payloadgprs[] = $row['PAYLOAD_GPRS_Mbyte'];
		$payloadedge[] = $row['PAYLOAD_EDGE_Mbyte'];
		$tanggal[] = date("Ymd",strtotime($row['Date']));
		$cluster = $row[1];
	}

	
	//untuk nilai pembatas before-after
	$strlimit = mysql_num_rows($limitbefore);


	
  ?>

  <script>
	var colors = Highcharts.getOptions().colors;
	jQuery(function() {
	chart = new Highcharts.Chart({
		  chart: {
			 renderTo: 'charthosr',
			 defaultSeriesType: 'line',
			 height: 300,
			 borderColor: "#335cad",
			 borderRadius: 3,
			 borderWidth: 1,
			 events: {
                load:function(){
                                this.renderer.image('./images/tselhuawei.png', '78%', 5, 100, 30).add();
                            } 
            }
		  },
		  credits: {
                enabled: false
            },
		  title: {
			text: 'HOSR (%)',
			style: {
            color: '#B40404',
            fontWeight: 'bold',
						fontSize: '18px'
        }
		},
		  yAxis: {
			title: {
				text: '(%)'
			}
		},
		plotOptions: {
			series: {
				marker: {
					enabled: false
				}
			}
		},
		 xAxis: {
			categories:[<?php echo join($tanggal, ',') ?>],
			fontSize: '5px'
			},
			
		 series: [{
			 name:	'<?php echo ($cluster); ?>',
			 data: [<?php echo join($hosr, ',') ?>],
			 zoneAxis: 'x',
			 zones: [{
						value: <?php echo ($strlimit); ?>,	
								color: colors[0]			
					}, {
			 color: <?php echo ($colorch); ?>
					}]
		  }]
		});
	});
	</script>
	
	<script>
	jQuery(function() {
	chart = new Highcharts.Chart({
		  chart: {
			 renderTo: 'chartsdsr',
			 defaultSeriesType: 'line',
			 height: 300,
			 borderColor: "#335cad",
			 borderRadius: 3,
			 borderWidth: 1,
			 events: {
                load:function(){
                                this.renderer.image('./images/tselhuawei.png', '78%', 5, 100, 30).add();
                            } 
            }
		  },
		  credits: {
                enabled: false
            },
		  title: {
			text: 'SDSR (%)',
			style: {
            color: '#B40404',
            fontWeight: 'bold',
						fontSize: '18px'
        }
		},
		  yAxis: {
			title: {
				text: '(%)'
			}
		},
		plotOptions: {
			series: {
				marker: {
					enabled: false
				}
			}
		},
		 xAxis: {
			categories:[<?php echo join($tanggal, ',') ?>],
			fontSize: '5px'
			},
			
		 series: [{
			 name:	'<?php echo ($cluster); ?>',
			 data: [<?php echo join($sdsr, ',') ?>],
			 zoneAxis: 'x',
			 zones: [{
						value: <?php echo ($strlimit); ?>,
								color: colors[0]			
					}, {
			 color: <?php echo ($colorch); ?>
					}]
		  }]
		});
	});
	</script>
	


<script>
	jQuery(function() {
	chart = new Highcharts.Chart({
		  chart: {
			 renderTo: 'charttdr',
			 defaultSeriesType: 'line',
			 height: 300,
			 borderColor: "#335cad",
			 borderRadius: 3,
			 borderWidth: 1,
			 events: {
                load:function(){
                                this.renderer.image('./images/tselhuawei.png', '78%', 5, 100, 30).add();
                            } 
            }
		  },
		  credits: {
                enabled: false
            },
		  title: {
			text: 'TCH DROP CALL (%)',
			style: {
            color: '#B40404',
            fontWeight: 'bold',
						fontSize: '18px'
        }
		},
		  yAxis: {
			title: {
				text: '(%)'
			}
		},
		plotOptions: {
			series: {
				marker: {
					enabled: false
				}
			}
		},
		 xAxis: {
			categories:[<?php echo join($tanggal, ',') ?>]
			},
			
		 series: [{
			 name:	'<?php echo ($cluster); ?>',
			 data: [<?php echo join($tdr, ',') ?>],
			 zoneAxis: 'x',
			 zones: [{
			 value: <?php echo ($strlimit); ?>,
						color: colors[0]			
					}, {
			 color: <?php echo ($colorch); ?>
					}]
		  }]
		});
	});
	</script>


	<script>
	jQuery(function() {
	chart = new Highcharts.Chart({
		  chart: {
			 renderTo: 'charttbfdlest',
			 defaultSeriesType: 'line',
			 height: 300,
			 borderColor: "#335cad",
			 borderRadius: 3,
			 borderWidth: 1,
			 events: {
                load:function(){
                                this.renderer.image('./images/tselhuawei.png', '78%', 5, 100, 30).add();
                            } 
            }
		  },
		  credits: {
                enabled: false
      },
		  title: {
			text: 'TBF DL EST SR (%)',
			style: {
            color: '#B40404',
            fontWeight: 'bold',
						fontSize: '18px'
        }
		},
		  yAxis: {
			title: {
				text: '(%)'
			}
		},
		plotOptions: {
			series: {
				marker: {
					enabled: false
				}
			}
		},
		 xAxis: {
			categories:[<?php echo join($tanggal, ',') ?>]
			},
			
		 series: [{
			 name:	'<?php echo ($cluster); ?>',
			 data: [<?php echo join($tbfdlest, ',') ?>],
			 zoneAxis: 'x',
			 zones: [{
			 value: <?php echo ($strlimit); ?>,
						color: colors[0]			
					}, {
			 color: <?php echo ($colorch); ?>
					}]
		  }]
		});
	});
	</script>
	
	<script>
	jQuery(function() {
	chart = new Highcharts.Chart({
		  chart: {
			 renderTo: 'charttbfcomp',
			 defaultSeriesType: 'line',
			 height: 300,
			 borderColor: "#335cad",
			 borderRadius: 3,
			 borderWidth: 1,
			 events: {
                load:function(){
                                this.renderer.image('./images/tselhuawei.png', '78%', 5, 100, 30).add();
                            } 
            }
		  },
		  credits: {
                enabled: false
       },
		  title: {
			text: 'TBF COMPLETION SR (%)',
			style: {
            color: '#B40404',
            fontWeight: 'bold',
						fontSize: '18px'
        }
		},
		  yAxis: {
			title: {
				text: '(%)'
			}
		},
		plotOptions: {
			series: {
				marker: {
					enabled: false
				}
			}
		},
		 xAxis: {
			categories:[<?php echo join($tanggal, ',') ?>]
			},
			
		 series: [{
			 name:	'<?php echo ($cluster); ?>',
			 data: [<?php echo join($tbfcomp, ',') ?>],
			 zoneAxis: 'x',
			 zones: [{
						value: <?php echo ($strlimit); ?>,
								color: colors[0]			
					}, {
			 color: <?php echo ($colorch); ?>
					}]
		  }]
		});
	});
	</script>
	
	<script>
	jQuery(function() {
	chart = new Highcharts.Chart({
		  chart: {
			 renderTo: 'charttchblock',
			 Type: 'column',
			 height: 300,
			 borderColor: "#335cad",
			 borderRadius: 3,
			 borderWidth: 1,
			 events: {
                load:function(){
                                this.renderer.image('./images/tselhuawei.png', '78%', 5, 100, 30).add();
                            } 
            }
		  },
		  credits: {
                enabled: false
            },
		  title: {
			text: 'TCH BLOCKING RATE (%)',
			style: {
            color: '#B40404',
            fontWeight: 'bold',
						fontSize: '18px'
        }
		},
		  yAxis: {
			title: {
				text: '(%)'
			}
		},
		plotOptions: {
			series: {
				marker: {
					enabled: false
				}
			}
		},
		 xAxis: {
			categories:[<?php echo join($tanggal, ',') ?>]
			},
			
		 series: [{
			 name:	'<?php echo ($cluster); ?>',
			 data: [<?php echo join($tchblockrate, ',') ?>],
			 zoneAxis: 'x',
			 zones: [{
						value: <?php echo ($strlimit); ?>,	
								color: colors[0]			
					}, {
			 color: <?php echo ($colorch); ?>
					}]
		  }]
		});
	});
	</script>
	
	<script>
	jQuery(function() {
	chart = new Highcharts.Chart({
		  chart: {
			 renderTo: 'chartsdblock',
			 Type: 'column',
			 height: 300,
			 borderColor: "#335cad",
			 borderRadius: 3,
			 borderWidth: 1,
			 events: {
                load:function(){
                                this.renderer.image('./images/tselhuawei.png', '78%', 5, 100, 30).add();
                            } 
            }
		  },
		 credits: {
                enabled: false
            },
		  title: {
			text: 'SDCCH BLOCKING RATE (%)',
			style: {
            color: '#B40404',
            fontWeight: 'bold',
						fontSize: '18px'
        }
		},
		  yAxis: {
			title: {
				text: '(%)'
			}
		},
		plotOptions: {
			series: {
				marker: {
					enabled: false
				}
			}
		},
		 xAxis: {
			categories:[<?php echo join($tanggal, ',') ?>]
			},
			
		 series: [{
			 name:	'<?php echo ($cluster); ?>',
			 data: [<?php echo join($sdblockrate, ',') ?>],
			 zoneAxis: 'x',
			 zones: [{
			 value: <?php echo ($strlimit); ?>,	
								color: colors[0]			
					}, {
			 color: <?php echo ($colorch); ?>
					}]
		  }]
		});
	});
	</script>
	
<script>
	jQuery(function() {
	chart = new Highcharts.Chart({
		  chart: {
			 renderTo: 'chartdlqual',
			 Type: 'column',
			 height: 300,
			 borderColor: "#335cad",
			 borderRadius: 3,
			 borderWidth: 1,
			 events: {
                load:function(){
                                this.renderer.image('./images/tselhuawei.png', '78%', 5, 100, 30).add();
                            } 
            }
		  },
		  credits: {
                enabled: false
      },
		  title: {
			text: 'DL QUAL 0-5 (%)',
			style: {
            color: '#B40404',
            fontWeight: 'bold',
						fontSize: '18px'
        }
		},
		  yAxis: {
			title: {
				text: '(%)'
			}
		},
		plotOptions: {
			series: {
				marker: {
					enabled: false
				}
			}
		},
		 xAxis: {
			categories:[<?php echo join($tanggal, ',') ?>]
			},
			
		 series: [{
			 name:	'<?php echo ($cluster); ?>',
			 data: [<?php echo join($dlqual, ',') ?>],
			 zoneAxis: 'x',
			 zones: [{
			 value: <?php echo ($strlimit); ?>,	
								color: colors[0]			
					}, {
			 color: <?php echo ($colorch); ?>
					}]
		  }]
		});
	});
	</script>


	<script>
	var colors = Highcharts.getOptions().colors;
	jQuery(function() {
	chart = new Highcharts.Chart({
		  chart: {
			 renderTo: 'charttchtraf',
			 Type: 'column',
			 height: 300,
			 borderColor: "#335cad",
			 borderRadius: 3,
			 borderWidth: 1,
			 events: {
                load:function(){
                                this.renderer.image('./images/tselhuawei.png', '78%', 5, 100, 30).add();
                            } 
            }
		  },
		  credits: {
                enabled: false
      },
		  title: {
			text: 'TRAFFIC TCH (Erl)',
			style: {
            color: '#B40404',
            fontWeight: 'bold',
						fontSize: '18px'
        }
		},
		  yAxis: {
			title: {
				text: '(Erl)'
			}
		},
		plotOptions: {
			series: {
				marker: {
					enabled: false
				}
			}
		},
		 xAxis: {
			categories:[<?php echo join($tanggal, ',') ?>]
			},
			
		 series: [{
			 name:	'<?php echo ($cluster); ?>',
			 data: [<?php echo join($traffictch, ',') ?>],
			 zoneAxis: 'x',
			 zones: [{
			 value: <?php echo ($strlimit); ?>,	
								color: colors[0]			
					}, {
			 color: <?php echo ($colorch); ?>
					}]
		  }]
		});
	});
	</script>


	<script>
	var colors = Highcharts.getOptions().colors;
	jQuery(function() {
	chart = new Highcharts.Chart({
		  chart: {
			 renderTo: 'chartsdtraf',
			 Type: 'column',
			 height: 300,
			 borderColor: "#335cad",
			 borderRadius: 3,
			 borderWidth: 1,
			 events: {
                load:function(){
                                this.renderer.image('./images/tselhuawei.png', '78%', 5, 100, 30).add();
                            } 
            }
		  },
		  credits: {
                enabled: false
      },
		  title: {
			text: 'TRAFFIC SDCCH (Erl)',
			style: {
            color: '#B40404',
            fontWeight: 'bold',
						fontSize: '18px'
        }
		},
		  yAxis: {
			title: {
				text: '(Erl)'
			}
		},
		plotOptions: {
			series: {
				marker: {
					enabled: false
				}
			}
		},
		 xAxis: {
			categories:[<?php echo join($tanggal, ',') ?>]
			},
			
		 series: [{
			 name:	'<?php echo ($cluster); ?>',
			 data: [<?php echo join($trafficsd, ',') ?>],
			 zoneAxis: 'x',
			 zones: [{
			 value: <?php echo ($strlimit); ?>,	
								color: colors[0]			
					}, {
			 color: <?php echo ($colorch); ?>
					}]
		  }]
		});
	});
	</script>


	<script>
	var colors = Highcharts.getOptions().colors;
	jQuery(function() {
	chart = new Highcharts.Chart({
		  chart: {
			 renderTo: 'chartgprs',
			 Type: 'column',
			 height: 300,
			 borderColor: "#335cad",
			 borderRadius: 3,
			 borderWidth: 1,
			 events: {
                load:function(){
                                this.renderer.image('./images/tselhuawei.png', '78%', 5, 100, 30).add();
                            } 
            }
		  },
		  credits: {
                enabled: false
      },
		  title: {
			text: 'PAYLOAD GPRS (MB)',
			style: {
            color: '#B40404',
            fontWeight: 'bold',
						fontSize: '18px'
        }
		},
		  yAxis: {
			title: {
				text: '(MB)'
			}
		},
		plotOptions: {
			series: {
				marker: {
					enabled: false
				}
			}
		},
		 xAxis: {
			categories:[<?php echo join($tanggal, ',') ?>]
			},
			
		 series: [{
			 name:	'<?php echo ($cluster); ?>',
			 data: [<?php echo join($payloadgprs, ',') ?>],
			 zoneAxis: 'x',
			 zones: [{
			 value: <?php echo ($strlimit); ?>,	
								color: colors[0]			
					}, {
			 color: <?php echo ($colorch); ?>
					}]
		  }]
		});
	});
	</script>


	<script>
	var colors = Highcharts.getOptions().colors;
	jQuery(function() {
	chart = new Highcharts.Chart({
		  chart: {
			 renderTo: 'chartedge',
			 Type: 'column',
			 height: 300,
			 borderColor: "#335cad",
			 borderRadius: 3,
			 borderWidth: 1,
			 events: {
                load:function(){
                                this.renderer.image('./images/tselhuawei.png', '78%', 5, 100, 30).add();
                            } 
            }
		  },
		  credits: {
                enabled: false
      },
		  title: {
			text: 'PAYLOAD EDGE (MB)',
			style: {
            color: '#B40404',
            fontWeight: 'bold',
						fontSize: '18px'
        }
		},
		  yAxis: {
			title: {
				text: '(MB)'
			}
		},
		plotOptions: {
			series: {
				marker: {
					enabled: false
				}
			}
		},
		 xAxis: {
			categories:[<?php echo join($tanggal, ',') ?>]
			},
			
		 series: [{
			 name:	'<?php echo ($cluster); ?>',
			 data: [<?php echo join($payloadedge, ',') ?>],
			 zoneAxis: 'x',
			 zones: [{
			 value: <?php echo ($strlimit); ?>,	
								color: colors[0]			
					}, {
			 color: <?php echo ($colorch); ?>
					}]
		  }]
		});
	});
	</script>
		
    <div id="mySidenav" class="sidenav">
	  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
	  <a href="#">***Daily***</a>
	  <a href="http://31.220.57.21/swap_sumatera/2g_medan.php">2G Medan</a>
	  <a href="http://31.220.57.21/swap_sumatera/3g_medan.php">3G Medan</a>
	  <a href="http://31.220.57.21/swap_sumatera/4g_medan.php">4G Medan</a>
	  <a href="http://31.220.57.21/swap_sumatera/2g_pku.php">2G Pekanbaru</a>
	  <a href="http://31.220.57.21/swap_sumatera/3g_pku.php">3G Pekanbaru</a>
	  <a href="http://31.220.57.21/swap_sumatera/4g_pku.php">4G Pekanbaru</a>
	  <a href="#">***Hourly***</a>
	  <a href="http://31.220.57.21/swap_sumatera/2g_medan_h.php">2G Medan</a>
	  <a href="http://31.220.57.21/swap_sumatera/3g_medan_h.php">3G Medan</a>
	  <a href="http://31.220.57.21/swap_sumatera/4g_medan_h.php">4G Medan</a>
	  <a href="http://31.220.57.21/swap_sumatera/2g_pku_h.php">2G Pekanbaru</a>
	  <a href="http://31.220.57.21/swap_sumatera/3g_pku_h.php">3G Pekanbaru</a>
	  <a href="http://31.220.57.21/swap_sumatera/4g_pku_h.php">4G Pekanbaru</a>
	</div>
	
	<div id="main">
	  
	  <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776; Menu</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="./images/Telkomsel_Logo.svg.png" alt="tsel logo" height="42" width="100"><img src="./images/huawei.gif" alt="huawei logo" height="42" width="45">
	  <table class="roundedCorners">
		  <tr>
			  <th><img src="http://www.googlemapsmarkers.com/v1/H/FA5858/"> Done (<?=$num_rows_c1?>)</th>
			  <th><img src="http://www.googlemapsmarkers.com/v1/E/0099FF/"> Not Yet(<?=$num_rows_c2?>)</th>
		  </tr>
	  </table>
	</div>
	
	<table class="roundedCorners" width=100% height=350px>
		<tr>
			<td colspan="2" width=80%><div id="map"></div></td>
			<td width=20%>
				<h4 align="center" style="background-color:#B40404;color:#FFFFFF;">Swap Progress NS</h4>
				<div id="container" style="min-width: 150px; height: 150px; margin: 0 auto"></div>
				<div id="container2" style="min-width: 150px; height: 150px; margin: 0 auto"></div>
				<div id="container3" style="min-width: 150px; height: 150px; margin: 0 auto"></div>
			</td>
		</tr>
			
	</table>
	
	<table width=100% Align="center" bgcolor="#A4A4A4">
		<tr>
			<td width=20%><form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
				<select  name="optaggr" id="ddl1" onchange="configureDropDownLists(this,document.getElementById('ddl2','ddl3','ddl4'))" >
						<option selected="selected">-Select Level--</option>
						<?php
						$res = mysql_query("SELECT Distinct aggr FROM aggregation ORDER BY aggr",$connect);
						while($row=mysql_fetch_array($res)){
						echo "<option value='".$row['aggr']."'>".$row['aggr']."</option>";
						}?>
				</select>	
			</td>
			<td width=20%><b>Start Date :</b>
					<select name="sd" id="ddl3">
						<option selected="selected"><?=$sd?></option>
					</select>
			</td>
			<td width=20%><b>End Date :</b>
					<select name="ed" id="ddl4">
						<option selected="selected"><?=$ed?></option>
					</select>
			
			</td>
			<td width=20%><b>Object Name :</b>
					<select name="optobjname" id="ddl2">
						<option selected="selected"><?=$objname?></option>
					</select>
			</td>
			<td width=20%><input type="submit" name="submit" value="Submit"></td>
			</form>
		</tr>
	</table>
	
	<table class="roundedCorners" width=100%>	
		<tr>
			<th colspan="3" bgcolor="000000"><font color="FFFFFF">PS SERVICE</font></th>
		</tr>
		<tr>
			<td width="33%" height="310px"><div id="charttbfdlest"></div></td>
			<td width="33%" height="310px"><div id="charttbfcomp"></div></td>
			<td width="33%" height="310px"></td>
		</tr>
			<tr>
				<th colspan="3" bgcolor="000000"><font color="FFFFFF">DROP AND BLOCKING</font></th>
			</tr>
			<tr>
				<td width="33%" height="310px"><div id="charttdr"></div></td>
				<td width="33%" height="310px"><div id="charttchblock"></div></td>
				<td width="33%" height="310px"><div id="chartsdblock"></div></td>
			</tr>
			<tr>
				<th colspan="3" bgcolor="000000"><font color="FFFFFF">PRODUCTIVITY</font></th>
			</tr>
			<tr>
				<td width="33%" height="310px"><div id="charttchtraf"></div></td>
				<td width="33%" height="310px"><div id="chartsdtraf"></div></td>
				<td width="33%" height="310px"><div id="chartdlqual"></div></td>
			</tr>
			<tr>
				<td width="33%" height="310px"><div id="chartgprs"></div></td>
				<td width="33%" height="310px"><div id="chartedge"></div></td>
				<td width="33%" height="310px"></td>
			</tr>
			<tr>
				<th colspan="3" bgcolor="000000"><font color="FFFFFF">END CHART</font></th>
			</tr>
		</table>
	
	
	<script>
		function openNav() {
			document.getElementById("mySidenav").style.width = "250px";
			document.getElementById("main").style.marginLeft = "250px";
			document.body.style.backgroundColor = "white";
		}

		function closeNav() {
			document.getElementById("mySidenav").style.width = "0";
			document.getElementById("main").style.marginLeft= "0";
			document.body.style.backgroundColor = "white";
		}
	</script>
	
    <script>
      var customLabel = {
        swapped: {
		  icon: 'http://www.googlemapsmarkers.com/v1/H/FA5858/',
		  warna: '#4dff88'
        },
        not_swap: {
		  icon: 'http://www.googlemapsmarkers.com/v1/E/0099FF/',
		  warna: '#e60000'
        }
      };
	  		
        function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          center: new google.maps.LatLng(3.6195757, 98.6883881),
          zoom: 12,
		  mapTypeId: 'satellite'
        });

		//var ctaLayer = new google.maps.KmlLayer({
		//url: 'http://31.220.57.21/swap_sumatera/kml/My_Maps_v2_voro_Cluster_.kml',
		//map: map
		//});

        var infoWindow = new google.maps.InfoWindow;

          // Change this depending on the name of your PHP or XML file
          downloadUrl('2g_markers.php', function(data) {
            var xml = data.responseXML;
            var markers = xml.documentElement.getElementsByTagName('marker');
            Array.prototype.forEach.call(markers, function(markerElem) {
				
			  //define variable yang mau di show
              var name = markerElem.getAttribute('name');
              var region = markerElem.getAttribute('region');
			  var cat = markerElem.getAttribute('status');
			  var ava = markerElem.getAttribute('siteid');
			  var ava2 = markerElem.getAttribute('status');
			  var ava3 = markerElem.getAttribute('sys');
			  var ava4 = markerElem.getAttribute('colo3g');
			  var ava5 = markerElem.getAttribute('colo4g');
              var point = new google.maps.LatLng(
                  parseFloat(markerElem.getAttribute('lat')),
                  parseFloat(markerElem.getAttribute('lng')));
			
			  // event untuk show pas di klik
              var infowincontent = document.createElement('div');
              var strong = document.createElement('strong');
              strong.textContent = name
              infowincontent.appendChild(strong);
              infowincontent.appendChild(document.createElement('br'));
			  
              var text = document.createElement('text');
              text.textContent = 'REGION :'+ convert_case(region)
              infowincontent.appendChild(text);
			  infowincontent.appendChild(document.createElement('br'));
			  
			  
			  var indexname =  ["SITEID :","STATUS :","SYSTEM :","COLO 3G :","COLO 4G :"];
			  var indexval =  [ava, ava2, ava3, ava4, ava5];
			  
			  var i = 0;
			  var len = indexname.length;
			  
			  for (;i<len;) {
			  
				  var text = document.createElement('text');
				  var isi = indexval[i];
				  text.textContent = indexname[i] + isi.toUpperCase()
				  infowincontent.appendChild(text)
				  infowincontent.appendChild(document.createElement('br'));
				  
				  i++;
			  }	  
			  
			  
			  
			  var icon = customLabel[cat] || {};
			  var sitename = markerElem.getAttribute('name');
              var marker = new google.maps.Marker({
                map: map,
                position: point,
				icon: icon.icon
              });
			  

			  //panggil masin2 var yang didef diatas
              marker.addListener('click', function() {
              infoWindow.setContent(infowincontent);
              infoWindow.open(map, marker);
              });
			  
            });
          });
        }

		//function round up
	  function roundNumber(rnum, rlength) { 
		var newnumber = Math.round(rnum * Math.pow(10, rlength)) / Math.pow(10, rlength);
		return newnumber;	
		}	


     function configureDropDownLists(ddl1,ddl2) {
		 <?php
		 
			#query untuk object cluster/region/site
		 	$result = mysql_query("SELECT Distinct Cluster FROM Cluster2GDay WHERE Region='Sumbagut' ORDER BY Cluster",$connect);
			while ($row = mysql_fetch_array($result)) {
				$clustername[] = "'".$row['Cluster']."'";
			}
			
			$result2 = mysql_query("SELECT Distinct Region FROM Region2GDay WHERE Region='Sumbagut' ORDER BY Region",$connect);
			while ($row2 = mysql_fetch_array($result2)) {
				$Region[] = "'".$row2['Region']."'";
			}
			
			$result3 = mysql_query("SELECT Distinct SITEID FROM Site2GDay WHERE Region='Sumbagut' ORDER BY SITEID",$connect);
			while ($row3 = mysql_fetch_array($result3)) {
				$siteid[] = "'".$row3['SITEID']."'";
			}
			
			#query untuk date
			
			$tgl = mysql_query("SELECT Distinct Date FROM Cluster2GDay WHERE Region='Sumbagut' ORDER BY Date",$connect);
			while ($row = mysql_fetch_array($tgl)) {
				$tgl_cluster[] = "'".date('Ymd',strtotime($row['Date']))."'";
			}
			
			$tgl = mysql_query("SELECT Distinct Date FROM Region2GDay WHERE Region='Sumbagut' ORDER BY Date",$connect);
			while ($row = mysql_fetch_array($tgl)) {
				$tgl_region[] = "'".date('Ymd',strtotime($row['Date']))."'";
			}
			
			$tgl = mysql_query("SELECT Distinct Date FROM Site2GDay WHERE Region='Sumbagut' ORDER BY Date",$connect);
			while ($row = mysql_fetch_array($tgl)) {
				$tgl_site[] = "'".date('Ymd',strtotime($row['Date']))."'";
			}
			
			
			
			
		?>
		
		
		var cluster = [<?php echo join($clustername, ',') ?>];
		var reg = [<?php echo join($Region, ',') ?>];
		var site = [<?php echo join($siteid, ',') ?>];
		var tglcluster = [<?php echo join($tgl_cluster, ',') ?>];
		var tglreg = [<?php echo join($tgl_region, ',') ?>];
		var tglsite = [<?php echo join($tgl_site, ',') ?>];

		switch (ddl1.value) {
			case 'Cluster':
				ddl2.options.length = 0;
				for (i = 0; i < cluster.length; i++) {
					createOption(ddl2, cluster[i], cluster[i]);
				}
				break;
			case 'Region':
				ddl2.options.length = 0; 
				for (i = 0; i < reg.length; i++) {
					createOption(ddl2, reg[i], reg[i]);
				}
				break;
			case 'Site':
				ddl2.options.length = 0;
				for (i = 0; i < site.length; i++) {
					createOption(ddl2, site[i], site[i]);
				}
				break;
			default:
					ddl2.options.length = 0;
				break;
		}
		
		
		switch (ddl1.value) {
			case 'Cluster':
				ddl3.options.length = 0;
				ddl4.options.length = 0;
				for (i = 0; i < tglcluster.length; i++) {
					createOption(ddl3, tglcluster[i], tglcluster[i]);
					createOption(ddl4, tglcluster[i], tglcluster[i]);
				}
				break;
			case 'Region':
				ddl3.options.length = 0;
				ddl4.options.length = 0;
				for (i = 0; i < tglreg.length; i++) {
					createOption(ddl3, tglreg[i], tglreg[i]);
					createOption(ddl4, tglreg[i], tglreg[i]);
				}
				break;
			case 'Site':
				ddl3.options.length = 0;
				ddl4.options.length = 0;
				for (i = 0; i < tglsite.length; i++) {
					createOption(ddl3, tglsite[i], tglsite[i]);
					createOption(ddl4, tglsite[i], tglsite[i]);
				}
				break;
			default:
					ddl3.options.length = 0;
					ddl4.options.length = 0;
				break;
		}

	}

    function createOption(ddl, text, value) {
        var opt = document.createElement('option');
        opt.value = value;
        opt.text = text;
        ddl.options.add(opt);
    }

		
		
		//fungsi uppercase title case
		function convert_case(str) {
		  var lower = str.toLowerCase();
		  return lower.replace(/(^| )(\w)/g, function(x) {
			return x.toUpperCase();
		  });
		}
		  
	  
      function downloadUrl(url, callback) {
        var request = window.ActiveXObject ?
            new ActiveXObject('Microsoft.XMLHTTP') :
            new XMLHttpRequest;

        request.onreadystatechange = function() {
          if (request.readyState == 4) {
            request.onreadystatechange = doNothing;
            callback(request, request.status);
          }
        };

        request.open('GET', url, true);
        request.send(null);
      }

      function doNothing() {}
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCkMCqjd6Tc8cH3Qr4b6Pl1Y6KjZKZWM_4&callback=initMap"
    async defer></script>
  </body>
</html>
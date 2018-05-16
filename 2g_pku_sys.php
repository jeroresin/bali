<?php
  session_start();
  if(empty($_SESSION['sess_user_id'])){
  header("location:index.php");
}
?>
<!DOCTYPE html >
  <head>
  <!--//==================== ibnurc@gmail.com @Huawei 2017===============//-->
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <title>.:OSS Center Huawei 2017:.</title>
    <link type="text/css" rel="stylesheet" href="css/ini.css"/>


	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script>
		$(document).ready(function () {

			$('#datepicker').datepicker({
				changeMonth: true,
				changeYear: true,
				showButtonPanel: true,
				yearRange: "-20:+0",
				dateFormat: 'yymmdd'
			});

			$('#datepicker2').datepicker({
				changeMonth: true,
				changeYear: true,
				showButtonPanel: true,
				yearRange: "-20:+0",
				dateFormat: 'yymmdd'
			});
		});
	</script>


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
		//	$aggr = $sd = $ed = $objname = $aggrselect = "";

		$qsd = mysql_query("Select DATE_SUB(Max(Date), INTERVAL 1 MONTH) from Region2GDay where Region='Sumbagteng'",$connect);
		while ($row = mysql_fetch_array($qsd)) {
			$datemin = date('Ymd',strtotime($row[0]));
		}

		$qed = mysql_query("Select max(Date) from Region2GDay where Region='Sumbagteng'",$connect);
		while ($row = mysql_fetch_array($qed)) {
			$datemax = date('Ymd',strtotime($row[0]));
		}

		$aggr = "Region";
		$sd = $datemin;
		$ed = $datemax;
		$objname = "SUMBAGTENG";
		$optaggr = $aggr;

	
	function test_input($data) {
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  return $data;
	}

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
	  $aggr = test_input($_POST["optaggr"]);
	  $sd = test_input($_POST["sd"]);
	  $ed = test_input($_POST["ed"]);
	  $objname = test_input($_POST["optobjname"]);
	}
	
	
	$c1 = mysql_query("SELECT * FROM 2g_siteID_PKU_ceklist  WHERE status = 'swapped'", $connect);
	$num_rows_c1 = mysql_num_rows($c1);
	
	$c2 = mysql_query("SELECT * FROM 2g_siteID_PKU_ceklist WHERE status = 'not_swap'", $connect);
	$num_rows_c2 = mysql_num_rows($c2);
	

	  if ($aggr == "Site"){
		$aggrselect = "SITEID";
		$colorch = "colors[8]";
		$limitbefore = mysql_query("SELECT Date AS TGL, 
		AVG(CASE WHEN System='DCS' THEN `TCH_BLOCK_(%)` END) AS 'TCHBLOCKDCS',
		AVG(CASE WHEN System='GSM' THEN `TCH_BLOCK_(%)` END) AS 'TCHBLOCKGSM',
		AVG(CASE WHEN System='DCS' THEN `SD_BLOCK_(%)` END) AS 'SDBLOCKDCS',
		AVG(CASE WHEN System='GSM' THEN `SD_BLOCK_(%)` END) AS 'SDBLOCKGSM',
		AVG(CASE WHEN System='DCS' THEN `SDSR` END) AS 'SDSRDCS',
		AVG(CASE WHEN System='GSM' THEN `SDSR` END) AS 'SDSRGSM',
		AVG(CASE WHEN System='DCS' THEN `TBF_DL_Est_(%)` END) AS 'TBF_DL_EstDCS',
		AVG(CASE WHEN System='GSM' THEN `TBF_DL_Est_(%)` END) AS 'TBF_DL_EstGSM',
		AVG(CASE WHEN System='DCS' THEN `TCH_DROP_CALL_(%)` END) AS 'TCH_DROP_CALL_DCS',
		AVG(CASE WHEN System='GSM' THEN `TCH_DROP_CALL_(%)` END) AS 'TCH_DROP_CALL_GSM',
		AVG(CASE WHEN System='DCS' THEN `TBF_COMP_(%)` END) AS 'TBF_COMP_DCS',
		AVG(CASE WHEN System='GSM' THEN `TBF_COMP_(%)` END) AS 'TBF_COMP_GSM',
		AVG(CASE WHEN System='DCS' THEN `HOSR` END) AS 'HOSRDCS',
		AVG(CASE WHEN System='GSM' THEN `HOSR` END) AS 'HOSRGSM',
		AVG(CASE WHEN System='DCS' THEN `DL_QUAL_050_(%)` END) AS 'DL_QUAL_050_DCS',
		AVG(CASE WHEN System='GSM' THEN `DL_QUAL_050_(%)` END) AS 'DL_QUAL_050_GSM',
		SUM(CASE WHEN System='DCS' THEN `Traffic (TCH) erl` END) AS 'TRAFFICDCS',
		SUM(CASE WHEN System='GSM' THEN `Traffic (TCH) erl` END) AS 'TRAFFICGSM',
		SUM(CASE WHEN System='DCS' THEN `PAYLOAD_GPRS_Mbyte` END) AS 'PAYLOAD_GPRS_MbyteDCS',
		SUM(CASE WHEN System='GSM' THEN `PAYLOAD_GPRS_Mbyte` END) AS 'PAYLOAD_GPRS_MbyteGSM',
		SUM(CASE WHEN System='DCS' THEN `PAYLOAD_EDGE_Mbyte` END) AS 'PAYLOAD_EDGE_MbyteDCS',
		SUM(CASE WHEN System='GSM' THEN `PAYLOAD_EDGE_Mbyte` END) AS 'PAYLOAD_EDGE_MbyteGSM',
		SUM(CASE WHEN System='DCS' THEN `SDCCH_TRAFFIC` END) AS 'SDCCH_TRAFFICDCS',
		SUM(CASE WHEN System='GSM' THEN `SDCCH_TRAFFIC` END) AS 'SDCCH_TRAFFICGSM'
		FROM swap_sumatera.Site2GDay_System
		WHERE SiteID='$objname' AND Region = 'SUMBAGTENG' AND Date >='".$sd."' AND Date <='".$ed."' 
		GROUP BY Date
		ORDER BY Date",$connect);
					
		while ($row = mysql_fetch_array($limitbefore)) {
		$SDCCH_TRAFFICDCS[] = $row['SDCCH_TRAFFICDCS'];
		$SDCCH_TRAFFICGSM[] = $row['SDCCH_TRAFFICGSM'];
		$TCHBLOCKDCS[] = $row['TCHBLOCKDCS'];
		$TCHBLOCKGSM[] = $row['TCHBLOCKGSM'];
		$SDBLOCKDCS[] = $row['SDBLOCKDCS'];
		$SDBLOCKGSM[] = $row['SDBLOCKGSM'];
		$SDSRDCS[] = $row['SDSRDCS'];
		$SDSRGSM[] = $row['SDSRGSM'];
		$TBF_DL_EstDCS[] = $row['TBF_DL_EstDCS'];
		$TBF_DL_EstGSM[] = $row['TBF_DL_EstGSM'];
		$TCH_DROP_CALL_DCS[] = $row['TCH_DROP_CALL_DCS'];
		$TCH_DROP_CALL_GSM[] = $row['TCH_DROP_CALL_GSM'];
		$TBF_COMP_DCS[] = $row['TBF_COMP_DCS'];
		$TBF_COMP_GSM[] = $row['TBF_COMP_GSM'];
		$HOSRDCS[] = $row['HOSRDCS'];
		$HOSRGSM[] = $row['HOSRGSM'];
		$DL_QUAL_050_DCS[] = $row['DL_QUAL_050_DCS'];
		$DL_QUAL_050_GSM[] = $row['DL_QUAL_050_GSM'];
		$TRAFFICDCS[] = $row['TRAFFICDCS'];
		$TRAFFICGSM[] = $row['TRAFFICGSM'];
		$PAYLOAD_GPRS_MbyteDCS[] = $row['PAYLOAD_GPRS_MbyteDCS'];
		$PAYLOAD_GPRS_MbyteGSM[] = $row['PAYLOAD_GPRS_MbyteGSM'];
		$PAYLOAD_EDGE_MbyteDCS[] = $row['PAYLOAD_EDGE_MbyteDCS'];
		$PAYLOAD_EDGE_MbyteGSM[] = $row['PAYLOAD_EDGE_MbyteGSM'];
		$tanggal[] = date("Ymd",strtotime($row['TGL']));
		$cluster = $row[1];
		$cluster1 = $row[2];

		}

		//untuk nilai pembatas before-after
		$strlimit = mysql_num_rows($limitbefore);

	?>

		<!--//drawchart($targetdiv,$titlechart,$tanggal,$cluster,$kpi,$strlimit,$colorch);-->
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
					name:	'<? echo $objname ?>DCS',
					data: [<?php echo join($HOSRDCS, ',') ?>]
					},{
					name:	'<? echo $objname ?>GSM',
					data: [<?php echo join($HOSRGSM, ',') ?>]
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
					name:	'<? echo $objname ?>DCS',
					data: [<?php echo join($SDSRDCS, ',') ?>]
					},{
					name:	'<? echo $objname ?>GSM',
					data: [<?php echo join($SDSRGSM, ',') ?>]
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
					name:	'<? echo $objname ?>DCS',
					data: [<?php echo join($TCH_DROP_CALL_DCS, ',') ?>]
					},{
					name:	'<? echo $objname ?>GSM',
					data: [<?php echo join($TCH_DROP_CALL_GSM, ',') ?>]
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
					name:	'<? echo $objname ?>DCS',
					data: [<?php echo join($TBF_DL_EstDCS, ',') ?>]
					},{
					name:	'<? echo $objname ?>GSM',
					data: [<?php echo join($TBF_DL_EstGSM, ',') ?>]
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
					name:	'<? echo $objname ?>DCS',
					data: [<?php echo join($TBF_COMP_DCS, ',') ?>]
					},{
					name:	'<? echo $objname ?>GSM',
					data: [<?php echo join($TBF_COMP_GSM, ',') ?>]
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
					name:	'<? echo $objname ?>DCS',
					data: [<?php echo join($TCHBLOCKDCS, ',') ?>]
					},{
					name:	'<? echo $objname ?>GSM',
					data: [<?php echo join($TCHBLOCKGSM, ',') ?>]
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
					name:	'<? echo $objname ?>DCS',
					data: [<?php echo join($SDBLOCKDCS, ',') ?>]
					},{
					name:	'<? echo $objname ?>GSM',
					data: [<?php echo join($SDBLOCKGSM, ',') ?>]
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
					name:	'<? echo $objname ?>DCS',
					data: [<?php echo join($DL_QUAL_050_DCS, ',') ?>]
					},{
					name:	'<? echo $objname ?>GSM',
					data: [<?php echo join($DL_QUAL_050_GSM, ',') ?>]
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
					name:	'<? echo $objname ?>DCS',
					data: [<?php echo join($TRAFFICDCS, ',') ?>]
					},{
					name:	'<? echo $objname ?>GSM',
					data: [<?php echo join($TRAFFICGSM, ',') ?>]
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
					name:	'<? echo $objname ?>DCS',
					data: [<?php echo join($SDCCH_TRAFFICDCS, ',') ?>]
					},{
					name:	'<? echo $objname ?>GSM',
					data: [<?php echo join($SDCCH_TRAFFICGSM, ',') ?>]
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
					name:	'<? echo $objname ?>DCS',
					data: [<?php echo join($PAYLOAD_GPRS_MbyteDCS, ',') ?>]
					},{
					name:	'<? echo $objname ?>GSM',
					data: [<?php echo join($PAYLOAD_GPRS_MbyteGSM, ',') ?>]
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
					name:	'<? echo $objname ?>DCS',
					data: [<?php echo join($PAYLOAD_EDGE_MbyteDCS, ',') ?>]
					},{
					name:	'<? echo $objname ?>GSM',
					data: [<?php echo join($PAYLOAD_EDGE_MbyteGSM, ',') ?>]
					}]
					});
			});
	</script>

	<?php
	} 
	
	IF ($aggr == "Cluster"){

		$aggrselect = "Cluster";
		$colorch = "colors[8]";
		$limitbefore = mysql_query("SELECT Date AS TGL, 
		`TCH_BLOCK_(%)`, `SD_BLOCK_(%)`, SDSR, `TBF_DL_Est_(%)`, `TCH_DROP_CALL_(%)`, `TBF_COMP_(%)`, HOSR, `DL_QUAL_050_(%)`, `Traffic (TCH) erl`, `SDCCH_TRAFFIC`,  `PAYLOAD_GPRS_Mbyte`, `PAYLOAD_EDGE_Mbyte`
		FROM swap_sumatera.Cluster2GDay
		WHERE Date >='".$sd."' AND Date <='".$ed."' AND Cluster ='".$objname."' And Region='Sumbagut' ORDER BY Date",$connect);
					
		while ($row = mysql_fetch_array($limitbefore)) {
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
			$tanggal[] = date("Ymd",strtotime($row['TGL']));
			$cluster = $row[1];
			$cluster1 = $row[2];
			}
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
					name:	'<? echo $objname ?>',
					data: [<?php echo join($hosr, ',') ?>]
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
					name:	'<? echo $objname ?>',
					data: [<?php echo join($sdsr, ',') ?>]
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
					name:	'<? echo $objname ?>',
					data: [<?php echo join($tdr, ',') ?>]
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
					name:	'<? echo $objname ?>',
					data: [<?php echo join($tbfdlest, ',') ?>]
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
					name:	'<? echo $objname ?>',
					data: [<?php echo join($tbfcomp, ',') ?>]
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
					name:	'<? echo $objname ?>',
					data: [<?php echo join($tdr, ',') ?>]
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
					name:	'<? echo $objname ?>',
					data: [<?php echo join($sdblockrate, ',') ?>]
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
					name:	'<? echo $objname ?>',
					data: [<?php echo join($dlqual, ',') ?>]
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
					name:	'<? echo $objname ?>',
					data: [<?php echo join($traffictch, ',') ?>]
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
					name:	'<? echo $objname ?>',
					data: [<?php echo join($trafficsd, ',') ?>]
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
					name:	'<? echo $objname ?>',
					data: [<?php echo join($payloadgprs, ',') ?>]
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
					name:	'<? echo $objname ?>',
					data: [<?php echo join($payloadedge, ',') ?>]
					}]
					});
			});
	</script>

	<?php
	}
	
	IF ($aggr == "Region"){

		$aggr = "Region";
		$aggrselect = "Region";
		$colorch = "colors[8]";
		$limitbefore = mysql_query("SELECT Date AS TGL, 
		`TCH_BLOCK_(%)`, `SD_BLOCK_(%)`, SDSR, `TBF_DL_Est_(%)`, `TCH_DROP_CALL_(%)`, `TBF_COMP_(%)`, HOSR, `DL_QUAL_050_(%)`, `Traffic (TCH) erl`, `SDCCH_TRAFFIC`,  `PAYLOAD_GPRS_Mbyte`, `PAYLOAD_EDGE_Mbyte`
		FROM swap_sumatera.Region2GDay
		WHERE Date >='".$sd."' AND Date <='".$ed."' AND Region='Sumbagut' ORDER BY Date",$connect);
					
		while ($row = mysql_fetch_array($limitbefore)) {
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
		$tanggal[] = date("Ymd",strtotime($row['TGL']));
		$cluster = $row[1];
		$cluster1 = $row[2];
		}
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
					name:	'<? echo $objname ?>',
					data: [<?php echo join($hosr, ',') ?>]
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
					name:	'<? echo $objname ?>',
					data: [<?php echo join($sdsr, ',') ?>]
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
					name:	'<? echo $objname ?>',
					data: [<?php echo join($tdr, ',') ?>]
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
					name:	'<? echo $objname ?>',
					data: [<?php echo join($tbfdlest, ',') ?>]
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
					name:	'<? echo $objname ?>',
					data: [<?php echo join($tbfcomp, ',') ?>]
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
					name:	'<? echo $objname ?>',
					data: [<?php echo join($tdr, ',') ?>]
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
					name:	'<? echo $objname ?>',
					data: [<?php echo join($sdblockrate, ',') ?>]
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
					name:	'<? echo $objname ?>',
					data: [<?php echo join($dlqual, ',') ?>]
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
					name:	'<? echo $objname ?>',
					data: [<?php echo join($traffictch, ',') ?>]
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
					name:	'<? echo $objname ?>',
					data: [<?php echo join($trafficsd, ',') ?>]
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
					name:	'<? echo $objname ?>',
					data: [<?php echo join($payloadgprs, ',') ?>]
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
					name:	'<? echo $objname ?>',
					data: [<?php echo join($payloadedge, ',') ?>]
					}]
					});
			});
		</script>

	<?php
	}
	?>



    <div id="mySidenav" class="sidenav">
	  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
	  <?php include("sidemenu.html"); ?>
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
	
	
	<table class="roundedCorners" width="100%" height="350px">
		<tr>
			<td colspan="2" width="80%"><div id="map"></div></td>
			<td width="20%">
				<h4 align="center" style="background-color:#B40404;color:#FFFFFF;">Swap Progress CS</h4>
				<div id="containerpku1" style="min-width: 150px; height: 150px; margin: 0 auto"></div>
				<div id="containerpku2" style="min-width: 150px; height: 150px; margin: 0 auto"></div>
				<div id="containerpku3" style="min-width: 150px; height: 150px; margin: 0 auto"></div>
			</td>
		</tr>
	</table>
	
	<table width="100%" Align="center" bgcolor="#A4A4A4">
		<tr>
			<td width="20%"><form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
				<b>Level :</b>
				<select  name="optaggr" id="ddl1" onchange="configureDropDownLists(this,document.getElementById('ddl2','ddl3','ddl4'))" >
						<option selected="selected"><?=$aggr?></option>
						<?php
						$res = mysql_query("SELECT Distinct aggr FROM aggregation ORDER BY aggr",$connect);
						while($row=mysql_fetch_array($res)){
						echo "<option value='".$row['aggr']."'>".$row['aggr']."</option>";
						}?>
				</select>	
			</td>
			<td width="20%"><b>Start Date :</b>
					  <?php 
						//sidemenu
						include("sd.html"); 
						
						?>					
			</td>
			<td width="20%"><b>End Date :</b>
						<?php 
						//sidemenu
						include("ed.html"); 
						
						?>
			
			</td>
			<td width=25%><b>Object:</b>
			<input type="text" name="optobjname" list="ddl2" autocomplete="off"/>
			<datalist id="ddl2">
						<?php

						if ($aggrselect =="SITEID") {

							$res = mysql_query("SELECT Distinct ".$aggrselect." FROM ".$aggr."2GDay_System WHERE Region='Sumbagteng' ORDER BY ".$aggrselect,$connect);
							while($row=mysql_fetch_array($res)){
							echo "<option value='".$row['0']."'>".$row['0']."</option>";
							}
						} else {
							$res = mysql_query("SELECT Distinct ".$aggrselect." FROM ".$aggr."2GDay WHERE Region='Sumbagteng' ORDER BY ".$aggrselect,$connect);
							while($row=mysql_fetch_array($res)){
							echo "<option value='".$row['0']."'>".$row['0']."</option>";
							}
						}

						
					?>
			</datalist>
			</td>
			<td width="20%"><input type="submit" name="submit" value="Submit"></td>
			</form>
		</tr>
	</table>
	
	
	<table class="roundedCorners" width="100%">	
		<tr>
			<th colspan="3" bgcolor="000000"><font color="FFFFFF">CS SERVICE</font></th>
		</tr>
		<tr>
			<td width="33%" height="310px"><div id="charthosr"></div></td>
			<td width="33%" height="310px"><div id="chartsdsr"></div></td>
			<td width="33%" height="310px"></td>
		</tr>
	</table>

	<table class="roundedCorners" width="100%">	
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
          center: new google.maps.LatLng(0.5243218, 101.4540147),
          zoom: 12,
		  mapTypeId: 'satellite'
        });
        var infoWindow = new google.maps.InfoWindow;

          // Change this depending on the name of your PHP or XML file
          downloadUrl('2g_markers_pku.php', function(data) {
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
		 	$result = mysql_query("SELECT Distinct Cluster FROM Cluster2GHour WHERE Region='Sumbagteng' ORDER BY Cluster",$connect);
			while ($row = mysql_fetch_array($result)) {
				$clustername[] = "'".$row['Cluster']."'";
			}
			
			$result2 = mysql_query("SELECT Distinct Region FROM Region2GHour WHERE Region='Sumbagteng' ORDER BY Region",$connect);
			while ($row2 = mysql_fetch_array($result2)) {
				$Region[] = "'".$row2['Region']."'";
			}
			
			$result3 = mysql_query("SELECT Distinct SiteID FROM Site2GDay_System WHERE Region='Sumbagteng' ORDER BY SiteID",$connect);
			while ($row3 = mysql_fetch_array($result3)) {
				$siteid[] = "'".$row3['SiteID']."'";
			}
			
			#query untuk date
			
			$tgl = mysql_query("SELECT Distinct Date FROM Cluster2GDay WHERE Region='Sumbagteng' ORDER BY Date",$connect);
			while ($row = mysql_fetch_array($tgl)) {
				$tgl_cluster[] = "'".date('Ymd',strtotime($row['Date']))."'";
			}
			
			$tgl = mysql_query("SELECT Distinct Date FROM Region2GDay WHERE Region='Sumbagteng' ORDER BY Date",$connect);
			while ($row = mysql_fetch_array($tgl)) {
				$tgl_region[] = "'".date('Ymd',strtotime($row['Date']))."'";
			}
			
			$tgl = mysql_query("SELECT Distinct Date FROM Site2GDay_System WHERE Region='Sumbagteng' ORDER BY Date",$connect);
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
		var str='';
		
				switch (ddl1.value) {
					case 'Cluster':
						ddl2.options.length = 0;
						for (i = 0; i < cluster.length; i++) {
							str += '<option value="'+cluster[i]+'" />';
						}
						break;
					case 'Region':
						ddl2.options.length = 0; 
						for (i = 0; i < reg.length; i++) {
							str += '<option value="'+reg[i]+'" />';
		
						}
						break;
					case 'Site':
						ddl2.options.length = 0;
						for (i = 0; i < site.length; i++) {
							str += '<option value="'+site[i]+'" />';
						}
						break;
					default:
							ddl2.options.length = 0;
						break;
				}
				
				
				var my_list=document.getElementById("ddl2");
				my_list.innerHTML = str;
		
		
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
<?php
  session_start();
  if(empty($_SESSION['sess_user_id'])){
  header("location:index.php");
}
?>
<!DOCTYPE html >
<head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <title>.:OSS Center Huawei 2017:.</title>
    <link type="text/css" rel="stylesheet" href="css/ini.css"/>
	<script type="text/javascript" src="plugins/js/jquery.min.js"></script>
    <script type="text/javascript" src="plugins/highcharts/highcharts.js"></script>
	<script type="text/javascript" src="plugins/highcharts/themes/grid-light.js"></script>
	<script type="text/javascript" src="plugins/highcharts/modules/no-data-to-display.js"></script>
	
</head>
	
<body>
<?php
	include('connect.php');
	$con = mysql_connect($hostname, $username, $password)
	or die('Could not connect: ' . mysql_error());
	//Select The database
	$bool = mysql_select_db($database, $con);
	if ($bool === False){
	   print "can't find $database";
	}

	$result = mysql_query("SELECT Date,
    IFNULL(Sum(CASE WHEN System='2G' THEN `Total Payload` END),0) AS 'Payload 2G',
    IFNULL(Sum(CASE WHEN System='3G' THEN `Total Payload` END),0) AS 'Payload 3G',
    IFNULL(Sum(CASE WHEN System='4G' THEN `Total Payload` END),0) AS 'Payload 4G',
    IFNULL(Sum(CASE WHEN System='2G' THEN `Total Traffic` END),0) AS 'Traffic 2G',
    IFNULL(Sum(CASE WHEN System='3G' THEN `Total Traffic` END),0) AS 'Traffic 3G',
    IFNULL(Sum(CASE WHEN System='4G' THEN `Total Traffic` END),0) AS 'Traffic 4G'
    from Sum_allPayload Where Region='Sumbagteng' and Date <= DATE_FORMAT(Now()-INTERVAL 1 DAY,'%Y-%m-%d')Group by date", $con);

	while($r = mysql_fetch_array($result)) {
		$payload2g[] = $r['Payload 2G'];
		$payload3g[] = $r['Payload 3G'];
        $payload4g[] = $r['Payload 4G'];
        $traffic2g[] = $r['Traffic 2G'];
		$traffic3g[] = $r['Traffic 3G'];
        $traffic4g[] = $r['Traffic 4G'];
        $tanggal[] = date("Ymd",strtotime($r['Date']));
	}

    $result = mysql_query("SELECT Date,
    IFNULL(Sum(CASE WHEN System='2G' THEN `Total Payload` END),0) AS 'Payload 2G',
    IFNULL(Sum(CASE WHEN System='3G' THEN `Total Payload` END),0) AS 'Payload 3G',
    IFNULL(Sum(CASE WHEN System='4G' THEN `Total Payload` END),0) AS 'Payload 4G',
    IFNULL(Sum(CASE WHEN System='2G' THEN `Total Traffic` END),0) AS 'Traffic 2G',
    IFNULL(Sum(CASE WHEN System='3G' THEN `Total Traffic` END),0) AS 'Traffic 3G',
    IFNULL(Sum(CASE WHEN System='4G' THEN `Total Traffic` END),0) AS 'Traffic 4G'
    from Sum_allPayload Where Region='Sumbagut' and Date <= DATE_FORMAT(Now()-INTERVAL 1 DAY,'%Y-%m-%d') Group by date", $con);

	while($r = mysql_fetch_array($result)) {
		$payload2g_ns[] = $r['Payload 2G'];
		$payload3g_ns[] = $r['Payload 3G'];
        $payload4g_ns[] = $r['Payload 4G'];
        $traffic2g_ns[] = $r['Traffic 2G'];
		$traffic3g_ns[] = $r['Traffic 3G'];
        $traffic4g_ns[] = $r['Traffic 4G'];
        $tanggal_ns[] = date("Ymd",strtotime($r['Date']));
	}
 
mysql_close($con);

?>

        <script>
                    var colors = Highcharts.getOptions().colors;
                    jQuery(function() {
                    chart = new Highcharts.Chart({
                        chart: {
                            renderTo: 'payloadcs',
                            defaultSeriesType: 'column',
                            height: 300,
                            borderColor: "#335cad",
                            borderRadius: 3,
                            borderWidth: 1,
                            backgroundColor: {
                                linearGradient: [0, 0, 500, 500],
                                stops: [
                                    [0, 'rgb(255, 255, 255)'],
                                    [1, 'rgb(200, 200, 255)']
                                ]
                            },
                            events: {
                                load:function(){
                                                this.renderer.image('./images/tselhuawei.png', '2%', 5, 100, 30).add();
                                            } 
                            }
                        },
                        credits: {
                                enabled: false
                            },
                        title: {
                            text: 'Total Payload Central Sumatera(MB)',
                            style: {
                            color: '#B40404',
                            fontWeight: 'bold',
                                        fontSize: '18px'
                        }
                        },
                        yAxis: {
                            title: {
                                text: 'MB'
                            }
                        },
                        plotOptions: {
                            column: {
                                stacking: 'normal'
                            },
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
                            connectNulls: true,
                            name:	'Payload 2G',
                            data: [<?php echo join($payload2g, ',') ?>]
                            },{
                            connectNulls: true,
                            name:	'Payload 3G',
                            data: [<?php echo join($payload3g, ',') ?>]
                            },{
                            connectNulls: true,
                            name:	'Payload 4G',
                            data: [<?php echo join($payload4g, ',') ?>]
                            }]
                            });
                    });
        </script>


        <script>
                    var colors = Highcharts.getOptions().colors;
                    jQuery(function() {
                    chart = new Highcharts.Chart({
                        chart: {
                            renderTo: 'trafficcs',
                            defaultSeriesType: 'column',
                            height: 300,
                            borderColor: "#335cad",
                            borderRadius: 3,
                            borderWidth: 1,
                            backgroundColor: {
                                linearGradient: [0, 0, 500, 500],
                                stops: [
                                    [0, 'rgb(255, 255, 255)'],
                                    [1, 'rgb(200, 200, 255)']
                                ]
                            },
                            events: {
                                load:function(){
                                                this.renderer.image('./images/tselhuawei.png', '2%', 5, 100, 30).add();
                                            } 
                            }
                        },
                        credits: {
                                enabled: false
                            },
                        title: {
                            text: 'Total Traffic Central Sumatera(Erl)',
                            style: {
                            color: '#B40404',
                            fontWeight: 'bold',
                                        fontSize: '18px'
                        }
                        },
                        yAxis: {
                            title: {
                                text: 'Erl'
                            }
                        },
                        plotOptions: {
                            column: {
                                stacking: 'normal'
                            },
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
                            connectNulls: true,
                            name:	'Traffic 2G',
                            data: [<?php echo join($traffic2g, ',') ?>]
                            },{
                            connectNulls: true,
                            name:	'Traffic 3G',
                            data: [<?php echo join($traffic3g, ',') ?>]
                            },{
                            connectNulls: true,
                            name:	'Traffic 4G',
                            data: [<?php echo join($traffic4g, ',') ?>]
                            }]
                            });
                    });
        </script>

         <script>
                    var colors = Highcharts.getOptions().colors;
                    jQuery(function() {
                    chart = new Highcharts.Chart({
                        chart: {
                            renderTo: 'payloadns',
                            defaultSeriesType: 'column',
                            height: 300,
                            borderColor: "#335cad",
                            borderRadius: 3,
                            borderWidth: 1,
                            backgroundColor: {
                                linearGradient: [0, 0, 500, 500],
                                stops: [
                                    [0, 'rgb(255, 255, 255)'],
                                    [1, 'rgb(200, 200, 255)']
                                ]
                            },
                            events: {
                                load:function(){
                                                this.renderer.image('./images/tselhuawei.png', '2%', 5, 100, 30).add();
                                            } 
                            }
                        },
                        credits: {
                                enabled: false
                            },
                        title: {
                            text: 'Total Payload North Sumatera(MB)',
                            style: {
                            color: '#B40404',
                            fontWeight: 'bold',
                                        fontSize: '18px'
                        }
                        },
                        yAxis: {
                            title: {
                                text: 'MB'
                            }
                        },
                        plotOptions: {
                            column: {
                                stacking: 'normal'
                            },
                            series: {
                                marker: {
                                    enabled: false
                                }
                            }
                        },

                        
                        xAxis: {
                            categories:[<?php echo join($tanggal_ns, ',') ?>],
                            fontSize: '5px'
                            },
                            
                        series: [{
                            connectNulls: true,
                            name:	'Payload 2G',
                            data: [<?php echo join($payload2g_ns, ',') ?>]
                            },{
                            connectNulls: true,
                            name:	'Payload 3G',
                            data: [<?php echo join($payload3g_ns, ',') ?>]
                            },{
                            connectNulls: true,
                            name:	'Payload 4G',
                            data: [<?php echo join($payload4g_ns, ',') ?>]
                            }]
                            });
                    });
        </script>

        <script>
                    var colors = Highcharts.getOptions().colors;
                    jQuery(function() {
                    chart = new Highcharts.Chart({
                        chart: {
                            renderTo: 'trafficns',
                            defaultSeriesType: 'column',
                            height: 300,
                            borderColor: "#335cad",
                            borderRadius: 3,
                            borderWidth: 1,
                            backgroundColor: {
                                linearGradient: [0, 0, 500, 500],
                                stops: [
                                    [0, 'rgb(255, 255, 255)'],
                                    [1, 'rgb(200, 200, 255)']
                                ]
                            },
                            events: {
                                load:function(){
                                                this.renderer.image('./images/tselhuawei.png', '2%', 5, 100, 30).add();
                                            } 
                            }
                        },
                        credits: {
                                enabled: false
                            },
                        title: {
                            text: 'Total Traffic North Sumatera(Erl)',
                            style: {
                            color: '#B40404',
                            fontWeight: 'bold',
                                        fontSize: '18px'
                        }
                        },
                        yAxis: {
                            title: {
                                text: 'Erl'
                            }
                        },
                        plotOptions: {
                            column: {
                                stacking: 'normal'
                            },
                            series: {
                                marker: {
                                    enabled: false
                                }
                            }
                        },

                        
                        xAxis: {
                            categories:[<?php echo join($tanggal_ns, ',') ?>],
                            fontSize: '5px'
                            },
                            
                        series: [{
                            connectNulls: true,
                            name:	'Traffic 2G',
                            data: [<?php echo join($traffic2g_ns, ',') ?>]
                            },{
                            connectNulls: true,
                            name:	'Traffic 3G',
                            data: [<?php echo join($traffic3g_ns, ',') ?>]
                            },{
                            connectNulls: true,
                            name:	'Traffic 4G',
                            data: [<?php echo join($traffic4g_ns, ',') ?>]
                            }]
                            });
                    });
        </script>

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

        <div id="mySidenav" class="sidenav">
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
            <?php include("sidemenu.html"); ?>
	    </div>
	
	    <div id="main">
            <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776; Menu</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="./images/Telkomsel_Logo.svg.png" alt="tsel logo" height="42" width="100"><img src="./images/huawei.gif" alt="huawei logo" height="42" width="45">
            <h2 align="center" style="background-color:#FFFFFF;color:#B40404;">Summary Traffic And Payload Trend</h2>
            
            <table class="roundedCorners" width=100% bgcolor="#244249">	
            <tr>
                <th colspan="2" bgcolor="000000"><font color="FFFFFF">Central Sumatera</font></th>
            </tr>
                <tr>
                    <td width="50%" height="310px"><div id="payloadcs"></div></td>
                    <td width="50%" height="310px"><div id="trafficcs"></div></td>
                </tr>
            <tr>
                <th colspan="2" bgcolor="000000"><font color="FFFFFF">North Sumatera</font></th>
            </tr>
                <tr>
                    <td width="50%" height="310px"><div id="payloadns"></div></td>
                    <td width="50%" height="310px"><div id="trafficns"></div></td>
                </tr>
            </table>
        </div>
        

   </body>
</html>
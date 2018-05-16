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
	require_once('swapstatus.php');
	$c1 = mysql_query("SELECT * FROM 3g_siteID_PKU_ceklist  WHERE status = 'swapped'", $connect);
	$num_rows_c1 = mysql_num_rows($c1);
	
	$c2 = mysql_query("SELECT * FROM 3g_siteID_PKU_ceklist WHERE status = 'not_swap'", $connect);
	$num_rows_c2 = mysql_num_rows($c2);
	
	
	if ($aggr == "Site") {
		$aggrselect = "SITEID";
		$colorch = "colors[8]";
		$limitbefore = mysql_query("SELECT Date, ".$aggrselect.", `CSSR_CS`,`CSSR_PS`,`CSSR_HSDPA`,`CSSR_HSUPA`,`CCSR CS`,`CCSR PS`,`CCSR HSDPA`,`CCSR HSUPA`,`ISHO SR`,`IFHO Success Ratio`,`SHO SR`,`HSDPA_cell_average_throughput_Kbps`,`HSUPA_cell_average_throughput_Kbps`,`PS_cell_average_throughput_Kbps`,`Traffic_Voice_Erlang`,`Traffic_Video_Erlang`,`Payload PS (MByte)`,`Payload HSDPA (MByte)`,`Payload HSUPA (MByte)`,`CSSR_CS`,`CSSR_PS`,`CSSR_HSDPA`,`CSSR_HSUPA`,`CCSR CS`,`CCSR PS`,`CCSR HSDPA`,`CCSR HSUPA`,`ISHO SR`,`IFHO Success Ratio`,`SHO SR` FROM ".$aggr."3GDay WHERE ".$aggrselect."='".$objname."' And Remarks='Ericsson' And Date >=".$sd." AND Date <=".$ed." And Region = 'SUMBAGTENG' ORDER BY Date",$connect);
	} Else {
		$aggrselect = $aggr;
		$colorch = "colors[0]";
		$limitbefore = mysql_query("SELECT Date, ".$aggrselect.", `CSSR_CS`,`CSSR_PS`,`CSSR_HSDPA`,`CSSR_HSUPA`,`CCSR CS`,`CCSR PS`,`CCSR HSDPA`,`CCSR HSUPA`,`ISHO SR`,`IFHO Success Ratio`,`SHO SR`,`HSDPA_cell_average_throughput_Kbps`,`HSUPA_cell_average_throughput_Kbps`,`PS_cell_average_throughput_Kbps`,`Traffic_Voice_Erlang`,`Traffic_Video_Erlang`,`Payload PS (MByte)`,`Payload HSDPA (MByte)`,`Payload HSUPA (MByte)`,`CSSR_CS`,`CSSR_PS`,`CSSR_HSDPA`,`CSSR_HSUPA`,`CCSR CS`,`CCSR PS`,`CCSR HSDPA`,`CCSR HSUPA`,`ISHO SR`,`IFHO Success Ratio`,`SHO SR` FROM ".$aggr."3GDay WHERE ".$aggrselect."='".$objname."' And Date >=".$sd." AND Date <=".$ed." And Region = 'SUMBAGTENG' ORDER BY Date",$connect);
	}
	
   
	$result = mysql_query("SELECT Date, ".$aggrselect.", `CSSR_CS`,`CSSR_PS`,`CSSR_HSDPA`,`CSSR_HSUPA`,`CCSR CS`,`CCSR PS`,`CCSR HSDPA`,`CCSR HSUPA`,`ISHO SR`,`IFHO Success Ratio`,`SHO SR`,`HSDPA_cell_average_throughput_Kbps`,`HSUPA_cell_average_throughput_Kbps`,`PS_cell_average_throughput_Kbps`,`Traffic_Voice_Erlang`,`Traffic_Video_Erlang`,`Payload PS (MByte)`,`Payload HSDPA (MByte)`,`Payload HSUPA (MByte)`,`CSSR_CS`,`CSSR_PS`,`CSSR_HSDPA`,`CSSR_HSUPA`,`CCSR CS`,`CCSR PS`,`CCSR HSDPA`,`CCSR HSUPA`,`ISHO SR`,`IFHO Success Ratio`,`SHO SR` FROM ".$aggr."3GDay WHERE ".$aggrselect."='".$objname."' AND Date >=".$sd." AND Date <=".$ed." And Region = 'SUMBAGTENG' ORDER BY Date",$connect);
	while ($row = mysql_fetch_array($result)) {
		$CSSRCS=$row[`CSSR_CS`];
		$CSSRPS=$row[`CSSR_PS`];
		$CSSRHSDPA=$row[`CSSR_HSDPA`];
		$CSSRHSUPA=$row[`CSSR_HSUPA`];
		$CCSRCS=$row[`CCSR CS`];
		$CCSRPS=$row[`CCSR PS`];
		$CCSRHSDPA=$row[`CCSR HSDPA`];
		$CCSRHSUPA=$row[`CCSR HSUPA`];
		$ISHOSR=$row[`ISHO SR`];
		$IFHOSR=$row[`IFHO Success Ratio`];
		$SHOSR=$row[`SHO SR`];
		$HSDPAcellthp=$row[`HSDPA_cell_average_throughput_Kbps`];
		$HSUPAcellthp=$row[`HSUPA_cell_average_throughput_Kbps`];
		$PScellaveragethroughputKbps=$row[`PS_cell_average_throughput_Kbps`];
		$TrafficVoiceErlang=$row[`Traffic_Voice_Erlang`];
		$TrafficVideoErlang=$row[`Traffic_Video_Erlang`];
		$PayloadPSMByte=$row[`Payload PS (MByte)`];
		$PayloadHSDPAMByte=$row[`Payload HSDPA (MByte)`];
		$PayloadHSUPAMByte=$row[`Payload HSUPA (MByte)`];
		$tanggal[] = date("Ymd",strtotime($row['Date']));
		$cluster = $row[1];
	}
	//untuk nilai pembatas before-after
	$strlimit = mysql_num_rows($limitbefore);
  include_once ("3gchartlib.php");
  
  drawchart("ISHOSR","ISHO SR %",$tanggal,$cluster,$ISHOSR,$strlimit,$colorch);
  drawchart("IFHOSR","IFHO SR %",$tanggal,$cluster,$IFHOSR,$strlimit,$colorch);
  drawchart("SHOSR","SHO SR %",$tanggal,$cluster,$SHOSR,$strlimit,$colorch);
  
  drawchart("HSDPAcellthp","HSDPA Cell Avg Throughput(kbps)",$tanggal,$cluster,$HSDPAcellthp,$strlimit,$colorch);
  drawchart("HSUPAcellthp","HSUPA Cell Avg Throughput(kbps)",$tanggal,$cluster,$HSUPAcellthp,$strlimit,$colorch);
  
  drawchart("TrafficVoiceErlang","Traffic Voice Erlang",$tanggal,$cluster,$TrafficVoiceErlang,$strlimit,$colorch);
  drawchart("PayloadPSMByte","PayloadPSMByte",$tanggal,$cluster,$PayloadPSMByte,$strlimit,$colorch);
  drawchart("PayloadHSDPAMByte","PayloadHSDPA(MByte)",$tanggal,$cluster,$PayloadHSDPAMByte,$strlimit,$colorch);
  drawchart("PayloadHSUPAMByte","PayloadHSUPAMByte",$tanggal,$cluster,$PayloadHSUPAMByte,$strlimit,$colorch);
  
  //drawchart($targetdiv,$titlechart,$tanggal,$cluster,$kpi,$strlimit,$colorch);
  drawchart("CSSRCS","CSSR CS %",$tanggal,$cluster,$CSSRCS,$strlimit,$colorch);
  drawchart("CSSRPS","CSSR PS %",$tanggal,$cluster,$CSSRPS,$strlimit,$colorch);
  drawchart("CSSRHSDPA","CSSR HSDPA %",$tanggal,$cluster,$CSSRHSDPA,$strlimit,$colorch);
  drawchart("CSSRHSUPA","CSSR HSPUA %",$tanggal,$cluster,$CSSRHSUPA,$strlimit,$colorch);
  
  drawchart("CCSRCS","CCSR CS %",$tanggal,$cluster,$CCSRCS,$strlimit,$colorch);
  drawchart("CCSRPS","CCSR PS %",$tanggal,$cluster,$CCSRPS,$strlimit,$colorch);
  drawchart("CCSRHSDPA","CCSR HSDPA %",$tanggal,$cluster,$CCSRHSDPA,$strlimit,$colorch);
  drawchart("CCSRHSUPA","CCSR HSPUA %",$tanggal,$cluster,$CCSRHSUPA,$strlimit,$colorch);
  
  ?>
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
	  <h2><img src="./images/huawei.gif" alt="huawei logo" height="42" width="45"><img src="./images/Telkomsel_Logo.svg.png" alt="tsel logo" height="42" width="100"></h2>
	  <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776; Menu</span>
	  <table class="roundedCorners">
		  <tr>
			  <th><img src="http://www.googlemapsmarkers.com/v1/H/FA5858/"> Swapped (<?=$num_rows_c1?>)</th>
			  <th><img src="http://www.googlemapsmarkers.com/v1/E/0099FF/"> Not Swapped(<?=$num_rows_c2?>)</th>
		  </tr>
	  </table>
	</div>
	
	<table class="roundedCorners" width=100% height=350px>
		<tr>
			<td colspan="2" width=80%><div id="map"></div></td>
			<td width=20%>
				<h4 align="center" style="background-color:#B40404;color:#FFFFFF;">Swap Progress CS</h4>
				<div id="containerpku1" style="min-width: 150px; height: 150px; margin: 0 auto"></div>
				<div id="containerpku2" style="min-width: 150px; height: 150px; margin: 0 auto"></div>
				<div id="containerpku3" style="min-width: 150px; height: 150px; margin: 0 auto"></div>
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
			<th colspan="4" bgcolor="000000"><font color="FFFFFF">Accesibility</font></th>
		</tr>
		<tr>
			<td width="25%" height="310px"><div id="CSSRCS"></div></td>
			<td width="25%" height="310px"><div id="CSSRPS"></div></td>
			<td width="25%" height="310px"><div id="CSSRHSDPA"></div></td>
			<td width="25%" height="310px"><div id="CSSRHUPA"></div></td>
		</tr>
	</table>

	<table class="roundedCorners" width=100%>	
		<tr>
			<th colspan="4" bgcolor="000000"><font color="FFFFFF">Retainability</font></th>
		</tr>
		<tr>
			<td width="25%" height="310px"><div id="CCSRCS"></div></td>
			<td width="25%" height="310px"><div id="CCSRPS"></div></td>
			<td width="25%" height="310px"><div id="CCSRHSDPA"></div></td>
			<td width="25%" height="310px"><div id="CCSRHSUPA"></div></td>
			
		</tr>
			<tr>
				<th colspan="3" bgcolor="000000"><font color="FFFFFF">Mobility</font></th>
			</tr>
			<tr>
				<td width="33%" height="310px"><div id="SHOSR"></div></td>
				<td width="33%" height="310px"><div id="IFHOSR"></div></td>
				<td width="33%" height="310px"><div id="ISHOSR"></div></td>
			</tr>
			<tr>
				<th colspan="3" bgcolor="000000"><font color="FFFFFF">Productivity</font></th>
			</tr>
			<tr>
				<td width="25%" height="310px"><div id="TrafficVoiceErlang"></div></td>
				<td width="25%" height="310px"><div id="PayloadPSMByte"></div></td>
				<td width="25%" height="310px"><div id="PayloadHSDPAMByte"></div></td>
				<td width="25%" height="310px"><div id="PayloadHSUPAMByte"></div></td>
			</tr>
			
			<tr>
				<th colspan="3" bgcolor="000000"><font color="FFFFFF">Throughput</font></th>
			</tr>
			<tr>
				<td width="33%" height="310px"><div id="HSDPAcellthp"></div></td>
				<td width="33%" height="310px"><div id="HSUPAcellthp"></div></td>
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
          downloadUrl('3g_markers_pku.php', function(data) {
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
			  
			  
			  var indexname =  ["SITEID :","STATUS :","SYSTEM :"];
			  var indexval =  [ava, ava2, ava3];
			  
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
		 	$result = mysql_query("SELECT Distinct Cluster FROM Cluster3GDay WHERE Region='Sumbagteng' ORDER BY Cluster",$connect);
			while ($row = mysql_fetch_array($result)) {
				$clustername[] = "'".$row['Cluster']."'";
			}
			
			$result2 = mysql_query("SELECT Distinct Region FROM Region3GDay WHERE Region='Sumbagteng' ORDER BY Region",$connect);
			while ($row2 = mysql_fetch_array($result2)) {
				$Region[] = "'".$row2['Region']."'";
			}
			
			$result3 = mysql_query("SELECT Distinct SITEID FROM Site3GDay WHERE Region='Sumbagteng' ORDER BY SITEID",$connect);
			while ($row3 = mysql_fetch_array($result3)) {
				$siteid[] = "'".$row3['SITEID']."'";
			}
			
			#query untuk date
			
			$tgl = mysql_query("SELECT Distinct Date FROM Cluster3GDay WHERE Region='Sumbagteng' ORDER BY Date",$connect);
			while ($row = mysql_fetch_array($tgl)) {
				$tgl_cluster[] = "'".date('Ymd',strtotime($row['Date']))."'";
			}
			
			$tgl = mysql_query("SELECT Distinct Date FROM Region3GDay WHERE Region='Sumbagteng' ORDER BY Date",$connect);
			while ($row = mysql_fetch_array($tgl)) {
				$tgl_region[] = "'".date('Ymd',strtotime($row['Date']))."'";
			}
			
			$tgl = mysql_query("SELECT Distinct Date FROM Site3GDay WHERE Region='Sumbagteng' ORDER BY Date",$connect);
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
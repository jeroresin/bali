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
  <?php
	#Include the connect.php file
	include('connect2.php');
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

		$qsd = mysql_query("Select DATE_SUB(Max(Date), INTERVAL 1 MONTH) from 4g_clusterdaily",$connect);
		while ($row = mysql_fetch_array($qsd)) {
			$datemin = date('Ymd',strtotime($row[0]));
		}

		$qed = mysql_query("Select max(Date) from 4g_clusterdaily ",$connect);
		while ($row = mysql_fetch_array($qed)) {
			$datemax = date('Ymd',strtotime($row[0]));
		}
		$aggr2 = "Region";
		$aggr3 = "Cluster";
		$aggr = "Cluster";
		$sd = $datemin;
		$ed = $datemax;
		$objname = "Cluster_1";
		$optaggr = $aggr;



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

	
	/*
	$c1 = mysql_query("SELECT * FROM 3g_siteID_ceklist  WHERE status = 'swapped'", $connect);
	$num_rows_c1 = mysql_num_rows($c1);
	
	$c2 = mysql_query("SELECT * FROM 3g_siteID_ceklist WHERE status = 'not_swap'", $connect);
	$num_rows_c2 = mysql_num_rows($c2);
	*/
	
	if ($aggr == "Site") {
		$aggrselect = "SITEID";
		$colorch = "colors[8]";
		$limitbefore = mysql_query("SELECT Date, Siteid, `RRC_Setup_SR_Service_%`, `ERAB_Setup_SR_All_%`, `Service_Drop_Rate_%`, `Call_Setup_SR_%`,`IntraFreq_HO_Out_SR_%`, `SumOfDL_Traffic_Volume_MB`, `SumOfUL_Traffic_Volume_MB`, `LTE_to_WCDMA_Redirection_SR_%`, `LTE_to_GERAN_Redirection_SR_%`, `Cell_DL_Avg_Throughput`, `Cell_UL_Avg_Throughput`, `AvgOfAvg_Active_User`, `MaxOfMax_Active_User` FROM 4g_sitedaily WHERE SiteID='".$objname."' AND Date >=".$sd." AND Date <=".$ed."  ORDER BY Date",$connect);

		$result = mysql_query("SELECT Date, Siteid, `RRC_Setup_SR_Service_%`, `ERAB_Setup_SR_All_%`, `Service_Drop_Rate_%`, `Call_Setup_SR_%`,`IntraFreq_HO_Out_SR_%`, `SumOfDL_Traffic_Volume_MB`, `SumOfUL_Traffic_Volume_MB`, `LTE_to_WCDMA_Redirection_SR_%`, `LTE_to_GERAN_Redirection_SR_%`, `Cell_DL_Avg_Throughput`, `Cell_UL_Avg_Throughput`, `AvgOfAvg_Active_User`, `MaxOfMax_Active_User` FROM 4g_sitedaily WHERE SiteID='".$objname."'  ",$connect);
		while ($row = mysql_fetch_array($result)) {
			$cssr[] = $row['Call_Setup_SR_%'];
			$sdr[] = $row['Service_Drop_Rate_%'];
			$ifho[] = $row['IntraFreq_HO_Out_SR_%'];
			$payloaddl[] = $row['SumOfDL_Traffic_Volume_MB'];
			$payloadul[] = $row['SumOfUL_Traffic_Volume_MB'];
			$payloadtot[] = $row['SumOfDL_Traffic_Volume_MB'] + $row['SumOfUL_Traffic_Volume_MB'];

			$rrcsr[] = $row['RRC_Setup_SR_Service_%']; 
			$erabsr[] = $row['ERAB_Setup_SR_All_%'];
			$ltetowcdmared[] = $row['LTE_to_WCDMA_Redirection_SR_%'];
			$ltetogeranred[] = $row['LTE_to_GERAN_Redirection_SR_%']; 
			$celldlthr[] = $row['Cell_DL_Avg_Throughput'];
			$cellulthr[] = $row['Cell_UL_Avg_Throughput'];
			$avguser[] = $row['AvgOfAvg_Active_User'];
			$maxuser[] = $row['MaxOfMax_Active_User'];

			$tanggal[] = date("Ymd",strtotime($row['Date']));
			$cluster = $row[1];
		}

		//untuk nilai pembatas before-after
		$strlimit = mysql_num_rows($limitbefore);
		include_once("3gchartlib.php");

			//drawchart($targetdiv,$titlechart,$tanggal,$cluster,$kpi,$strlimit,$colorch);
			drawchart("chartrrcsr","LTE RRC SR (%)",$tanggal,$cluster,$rrcsr,$strlimit,$colorch);
			drawchart("charterabsr","LTE eRAB SR (%)",$tanggal,$cluster,$erabsr,$strlimit,$colorch);
			drawchart("chartcssr","LTE CSSR SR (%)",$tanggal,$cluster,$cssr,$strlimit,$colorch);
			drawchart("chartsdr","LTE Service Drop Rate (%)",$tanggal,$cluster,$sdr,$strlimit,$colorch);
			drawchart("chartifho","LTE IFHO SR (%)",$tanggal,$cluster,$ifho,$strlimit,$colorch);
			drawchart("chartltegeranred","LTE-GERAN Redirection SR (%)",$tanggal,$cluster,$ltetogeranred,$strlimit,$colorch);
			drawchart("chartltewcdmared","LTE-WCDMA Redirection SR (%)",$tanggal,$cluster,$ltetowcdmared,$strlimit,$colorch);
			drawchart("chartcelldlthr","LTE-Cell DL Throughput (Kbps)",$tanggal,$cluster,$celldlthr,$strlimit,$colorch);
			drawchart("chartcellulthr","LTE-Cell UL Throughput (Kbps)",$tanggal,$cluster,$cellulthr,$strlimit,$colorch);
			drawchart("chartpayloaddl","LTE-DL Traffic Volume (MB)",$tanggal,$cluster,$payloaddl,$strlimit,$colorch);
			drawchart("chartpayloadul","LTE-UL Traffic Volume (MB)",$tanggal,$cluster,$payloadul,$strlimit,$colorch);
			drawchart("chartpayloadtot","LTE-TOTAL Traffic Volume (MB)",$tanggal,$cluster,$payloadtot,$strlimit,$colorch);
			drawchart("chartavguser","LTE-Average User Number",$tanggal,$cluster,$avguser,$strlimit,$colorch);
			drawchart("chartmaxuser","LTE-Max User Number",$tanggal,$cluster,$maxuser,$strlimit,$colorch);

			
			
			
		
			
			
			
			//drawchart("TrafficVoiceErlang","Traffic Voice Erlang",$tanggal,$cluster,$TrafficVoiceErlang,$strlimit,$colorch);
			//drawchart("PayloadPSMByte","PayloadPSMByte",$tanggal,$cluster,$PayloadPSMByte,$strlimit,$colorch);
			
			
		
	
	} Elseif ($aggr=="Region") {

		$aggrselect = $aggr;
		$colorch = "colors[0]";
		$limitbefore = mysql_query("SELECT Date, ".$aggrselect.", `CSSR_CS`,`CSSR_PS`,`CSSR_HSDPA`,`CSSR_HSUPA`,`CCSR CS`,`CCSR PS`,`CCSR HSDPA`,`CCSR HSUPA`,`ISHO SR`,`IFHO Success Ratio`,`SHO SR`,`HSDPA_cell_average_throughput_Kbps`,`HSUPA_cell_average_throughput_Kbps`,`PS_cell_average_throughput_Kbps`,`Traffic_Voice_Erlang`,`Traffic_Video_Erlang`,`Payload PS (MByte)`,`Payload HSDPA (MByte)`,`Payload HSUPA (MByte)`,`CSSR_CS`,`CSSR_PS`,`CSSR_HSDPA`,`CSSR_HSUPA`,`CCSR CS`,`CCSR PS`,`CCSR HSDPA`,`CCSR HSUPA`,`ISHO SR`,`IFHO Success Ratio`,`SHO SR` FROM 3g_regiondaily WHERE ".$aggrselect."='".$objname."' And Date >=".$sd." AND Date <=".$ed." And Region = 'SUMBAGUT' ORDER BY Date",$connect);

		$result = mysql_query("SELECT Date, ".$aggrselect.", `CSSR_CS`,`CSSR_PS`,`CSSR_HSDPA`,`CSSR_HSUPA`,`CCSR CS`,`CCSR PS`,`CCSR HSDPA`,`CCSR HSUPA`,`ISHO SR`,`IFHO Success Ratio`,`SHO SR`,`HSDPA_cell_average_throughput_Kbps`,`HSUPA_cell_average_throughput_Kbps`,`PS_cell_average_throughput_Kbps`,`Traffic_Voice_Erlang`,`Traffic_Video_Erlang`,`Payload PS (MByte)`,`Payload HSDPA (MByte)`,`Payload HSUPA (MByte)`,`CSSR_CS`,`CSSR_PS`,`CSSR_HSDPA`,`CSSR_HSUPA`,`CCSR CS`,`CCSR PS`,`CCSR HSDPA`,`CCSR HSUPA`,`ISHO SR`,`IFHO Success Ratio`,`SHO SR` FROM 3g_regiondaily WHERE ".$aggrselect."='".$objname."' AND Date >=".$sd." AND Date <=".$ed." And Region = 'SUMBAGUT' And Vendor='Huawei' ORDER BY Date",$connect);
		
			while ($row = mysql_fetch_array($result)) {
				
				/*
				$cssrcs[]=$row['CSSR_CS'];
				$CSSRPS[]=$row['CSSR_PS'];
				$CSSRHSDPA[]=$row['CSSR_HSDPA'];
				$CSSRHSUPA[]=$row['CSSR_HSUPA'];
				$CCSRCS[]=$row['CCSR CS'];
				$CCSRPS[]=$row['CCSR PS'];
				$CCSRHSDPA[]=$row['CCSR HSDPA'];
				$CCSRHSUPA[]=$row['CCSR HSUPA'];
				$ISHOSR[]=$row['ISHO SR'];
				$IFHOSR[]=$row['IFHO Success Ratio'];
				$SHOSR[]=$row['SHO SR'];
				$HSDPAcellthp[]=$row['HSDPA_cell_average_throughput_Kbps'];
				$HSUPAcellthp[]=$row['HSUPA_cell_average_throughput_Kbps'];
				$PScellaveragethroughputKbps[]=$row['PS_cell_average_throughput_Kbps'];
				$TrafficVoiceErlang[]=$row['Traffic_Voice_Erlang'];
				$TrafficVideoErlang[]=$row['Traffic_Video_Erlang'];
				$PayloadPSMByte[]=$row['Payload PS (MByte)'];
				$PayloadHSDPAMByte[]=$row['Payload HSDPA (MByte)'];
				$PayloadHSUPAMByte[]=$row['Payload HSUPA (MByte)'];
				*/
				$tanggal[] = date("Ymd",strtotime($row['Date']));
				$cluster = $row[1];
			}
				//untuk nilai pembatas before-after
  
  
				$strlimit = mysql_num_rows($limitbefore);
				include_once ("3gchartlib.php");
				
				
				drawchart("cssrcs","CSSR CS %",$tanggal,$cluster,$cssrcs,$strlimit,$colorch);
				
				
				/*
				//drawchart($targetdiv,$titlechart,$tanggal,$cluster,$kpi,$strlimit,$colorch);
				drawchart("cssrcs","CSSR CS %",$tanggal,$cluster,$cssrcs,$strlimit,$colorch);
				drawchart("CSSRPS","CSSR PS %",$tanggal,$cluster,$CSSRPS,$strlimit,$colorch);
				drawchart("CSSRHSDPA","CSSR HSDPA %",$tanggal,$cluster,$CSSRHSDPA,$strlimit,$colorch);
				drawchart("CSSRHSUPA","CSSR HSPUA %",$tanggal,$cluster,$CSSRHSUPA,$strlimit,$colorch);
				
				drawchart("CCSRCS","CCSR CS %",$tanggal,$cluster,$CCSRCS,$strlimit,$colorch);
				drawchart("CCSRPS","CCSR PS %",$tanggal,$cluster,$CCSRPS,$strlimit,$colorch);
				drawchart("CCSRHSDPA","CCSR HSDPA %",$tanggal,$cluster,$CCSRHSDPA,$strlimit,$colorch);
				drawchart("CCSRHSUPA","CCSR HSPUA %",$tanggal,$cluster,$CCSRHSUPA,$strlimit,$colorch);
				
				drawchart("IFHOSR","IFHO SR %",$tanggal,$cluster,$IFHOSR,$strlimit,$colorch);
				drawchart("SHOSR","SHO SR %",$tanggal,$cluster,$SHOSR,$strlimit,$colorch);
				drawchart("ISHOSR","ISHO SR %",$tanggal,$cluster,$ISHOSR,$strlimit,$colorch);
				
				drawchart("HSDPAcellthp","HSDPA Cell Avg Throughput(kbps)",$tanggal,$cluster,$HSDPAcellthp,$strlimit,$colorch);
				drawchart("HSUPAcellthp","HSUPA Cell Avg Throughput(kbps)",$tanggal,$cluster,$HSUPAcellthp,$strlimit,$colorch);
				
				drawchart("TrafficVoiceErlang","Traffic Voice Erlang",$tanggal,$cluster,$TrafficVoiceErlang,$strlimit,$colorch);
				drawchart("PayloadPSMByte","PayloadPSMByte",$tanggal,$cluster,$PayloadPSMByte,$strlimit,$colorch);
				drawchart("PayloadHSDPAMByte","PayloadHSDPA(MByte)",$tanggal,$cluster,$PayloadHSDPAMByte,$strlimit,$colorch);
				drawchart("PayloadHSUPAMByte","PayloadHSUPAMByte",$tanggal,$cluster,$PayloadHSUPAMByte,$strlimit,$colorch);
				*/

			} Else {

				
		$aggrselect = $aggr;
		$colorch = "colors[0]";
		$limitbefore = mysql_query("SELECT Date, Cluster, `RRC_Setup_SR_Service_%`, `ERAB_Setup_SR_All_%`,  `Call_Setup_SR_%`, `Service_Drop_Rate_%`, `IntraFreq_HO_Out_SR_%`, `SumOfDL_Traffic_Volume_MB`, `SumOfUL_Traffic_Volume_MB`, `LTE_to_WCDMA_Redirection_SR_Nom`, `LTE_to_GERAN_Redirection_SR_Nom`, `Cell_DL_Avg_Throughput`, `Cell_UL_Avg_Throughput`, `AvgOfAverage_User_Number`, `MaxOfAverage_User_Number` FROM 4g_clusterdaily WHERE ".$aggrselect."='".$objname."' AND Date >=".$sd." AND Date <=".$ed."  ORDER BY Date",$connect);
	
		$qbaseline = mysql_query("SELECT `Cluster`,`Total E-UTRAN RRC conn stp SR`, `E-RAB Setup Success Rate`, `Call Setup Success Rate`, `Service Drop Rate`, `Intra-Frequency Handover Out Success Rate`, `Cell Downlink Average Throughput`, `Cell Uplink Average Throughput`, `Avg active users per cell`, `New Max active users per cell Maximum number of active users per`, `Number of RRC redirections from E-UTRANs to WCDMA network trigge`, `Number of RRC redirections from E-UTRANs to GERANs` From `4g_baseline` where  Cluster='".$objname."'",$connect);
			
			while ($row = mysql_fetch_array($qbaseline)) {
				$b_rrcsr=$row['Total E-UTRAN RRC conn stp SR'];
				$b_cssr=$row['Call Setup Success Rate'];
				$b_sdr=$row['Service Drop Rate'];
				$b_ifho=$row['Intra-Frequency Handover Out Success Rate'];
				//$b_payloaddl=$row['Donlink Traffic Volume (MB)'];
				//$b_payloadul=$row['Uplink Traffic Volume (MB)'];
				$b_erabsr=$row['E-RAB Setup Success Rate'];
				$b_celldlthr=$row['Cell Downlink Average Throughput'];
				$b_cellulthr=$row['Cell Uplink Average Throughput'];
				$b_avguser=$row['Avg active users per cell'];
				$b_maxuser=$row['New Max active users per cell Maximum number of active users per'];
			}

		$result = mysql_query("SELECT Date, Cluster, `RRC_Setup_SR_Service_%`, `ERAB_Setup_SR_All_%`,  `Call_Setup_SR_%`, `Service_Drop_Rate_%`, `IntraFreq_HO_Out_SR_%`, `SumOfDL_Traffic_Volume_MB`, `SumOfUL_Traffic_Volume_MB`, `LTE_to_WCDMA_Redirection_SR_%`, `LTE_to_GERAN_Redirection_SR_%`, `Cell_DL_Avg_Throughput`, `Cell_UL_Avg_Throughput`, `AvgOfAverage_User_Number`, `MaxOfAverage_User_Number` FROM 4g_clusterdaily WHERE ".$aggrselect."='".$objname."' ORDER BY Date",$connect);
		while ($row = mysql_fetch_array($result)) {
			$cssr[] = $row['Call_Setup_SR_%'];
			$sdr[] = $row['Service_Drop_Rate_%'];
			$ifho[] = $row['IntraFreq_HO_Out_SR_%'];
			$payloaddl[] = $row['SumOfDL_Traffic_Volume_MB'];
			$payloadul[] = $row['SumOfUL_Traffic_Volume_MB'];
			$payloadtot[] = $row['SumOfDL_Traffic_Volume_MB'] + $row['SumOfUL_Traffic_Volume_MB'];

			$rrcsr[] = $row['RRC_Setup_SR_Service_%']; 
			$erabsr[] = $row['ERAB_Setup_SR_All_%'];
			$ltetowcdmared[] = $row['LTE_to_WCDMA_Redirection_SR_%'];
			$ltetogeranred[] = $row['LTE_to_GERAN_Redirection_SR_%']; 
			$celldlthr[] = $row['Cell_DL_Avg_Throughput'];
			$cellulthr[] = $row['Cell_UL_Avg_Throughput'];
			$avguser[] = $row['AvgOfAverage_User_Number'];
			$maxuser[] = $row['MaxOfAverage_User_Number'];

			$tanggal[] = date("Ymd",strtotime($row['Date']));
			$cluster = $row[1];
		}

		//untuk nilai pembatas before-after
		$strlimit = mysql_num_rows($limitbefore);
		include_once("4gchartlib.php");

		//drawchart($targetdiv,$titlechart,$tanggal,$cluster,$kpi,$strlimit,$colorch);
			drawchartwithbaseline("chartrrcsr","LTE RRC SR (%)",$tanggal,$cluster,$rrcsr,$strlimit,$colorch,$b_rrcsr);
			drawchartwithbaseline("charterabsr","LTE eRAB SR (%)",$tanggal,$cluster,$erabsr,$strlimit,$colorch,$b_erabsr);
			drawchartwithbaseline("chartcssr","LTE CSSR SR (%)",$tanggal,$cluster,$cssr,$strlimit,$colorch,$b_cssr);
			drawchartwithbaseline("chartsdr","LTE Service Drop Rate (%)",$tanggal,$cluster,$sdr,$strlimit,$colorch,$b_sdr);
			drawchartwithbaseline("chartifho","LTE IFHO SR (%)",$tanggal,$cluster,$ifho,$strlimit,$colorch,$b_ifho);
			drawchart("chartltegeranred","LTE-GERAN Redirection SR (%)",$tanggal,$cluster,$ltetogeranred,$strlimit,$colorch);
			drawchart("chartltewcdmared","LTE-WCDMA Redirection SR (%)",$tanggal,$cluster,$ltetowcdmared,$strlimit,$colorch);
			drawchartwithbaseline("chartcelldlthr","LTE-Cell DL Throughput (Kbps)",$tanggal,$cluster,$celldlthr,$strlimit,$colorch,$b_celldlthr);
			drawchartwithbaseline("chartcellulthr","LTE-Cell UL Throughput (Kbps)",$tanggal,$cluster,$cellulthr,$strlimit,$colorch,$b_cellulthr);
			drawchart("chartpayloaddl","LTE-DL Traffic Volume (MB)",$tanggal,$cluster,$payloaddl,$strlimit,$colorch);
			drawchart("chartpayloadul","LTE-UL Traffic Volume (MB)",$tanggal,$cluster,$payloadul,$strlimit,$colorch);
			drawchart("chartpayloadtot","LTE-TOTAL Traffic Volume (MB)",$tanggal,$cluster,$payloadtot,$strlimit,$colorch);
			drawchart("chartavguser","LTE-Average User Number",$tanggal,$cluster,$avguser,$strlimit,$colorch);
			drawchart("chartmaxuser","LTE-Max User Number",$tanggal,$cluster,$maxuser,$strlimit,$colorch);

}

  ?>
  


    <div id="mySidenav" class="sidenav">
	  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
	  <?php 
	  	//sidemenu
	  	include("sidemenu.html"); 
		  
	   ?>
	</div>
	
	
	<div id="main">
	  
	  <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776; 4G KPI</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="./images/Telkomsel_Logo.svg.png" alt="tsel logo" height="42" width="100"><img src="./images/huawei.gif" alt="huawei logo" height="42" width="45">
	  <table class="roundedCorners">
		  <tr>
			  <th><img src="http://www.googlemapsmarkers.com/v1/H/FA5858/"> Done (<?//=$num_rows_c1?>)</th>
			  <th><img src="http://www.googlemapsmarkers.com/v1/E/0099FF/"> Not Yet(<?//=$num_rows_c2?>)</th>
		  </tr>
	  </table>
	</div>
	
	<table class="roundedCorners" width=100% height=350px>
		<tr>
			<td colspan="2" width=80%><iframe src="https://www.google.com/maps/d/u/3/embed?mid=1mnQjfTTMWB_p07iKmysF7BAspOIu7seY" width="99%" height="480"></iframe></td>
			<!--
				<td width=20%>
				<h4 align="center" style="background-color:#B40404;color:#FFFFFF;">Swap Progress Bali</h4>
				<div id="container" style="min-width: 150px; height: 150px; margin: 0 auto"></div>
				<div id="container2" style="min-width: 150px; height: 150px; margin: 0 auto"></div>
				<div id="container3" style="min-width: 150px; height: 150px; margin: 0 auto"></div>
			</td>-->
		</tr>

	</table>
	
	<table width=100% Align="center" bgcolor="#A4A4A4">
		<tr>
			<td width=20%><form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
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
			<td width=20%><b>Start Date :</b>
					  <?php 
						//sidemenu
						include("sd.html"); 
						
						?>					
			</td>
			<td width=20%><b>End Date :</b>
						<?php 
						//sidemenu
						include("ed.html"); 
						
						?>
			
			</td>
			<td width=25%><b>Object:</b>
			<input type="text" name="optobjname" list="ddl2" autocomplete="off"/>
			<datalist id="ddl2">
						<?php
						$res = mysql_query("SELECT Distinct ".$aggrselect." FROM 4G_".$aggr."daily ORDER BY ".$aggrselect,$connect);
						while($row=mysql_fetch_array($res)){
						echo "<option value='".$row['0']."'>".$row['0']."</option>";
					}?>
			</datalist>
			</td>
			</td>
			
			<td width=20%><input type="submit" name="submit" value="Submit"></td>
			</form>
		</tr>
	</table>
	
	
	

<table class="roundedCorners" width=100%>
		<tr>
			<th colspan="3" bgcolor="000000"><font color="FFFFFF">ACCESSIBILITY</font></th>
		</tr>	
		<tr>
			<td width="33%" height="310px"><div id="chartrrcsr"></div></td>
			<td width="33%" height="310px"><div id="charterabsr"></div></td>
			<td width="33%" height="310px"><div id="chartcssr"></div></td>
		</tr>
		<tr>
			<th colspan="3" bgcolor="000000"><font color="FFFFFF">RETAINABILITY</font></th>
		</tr>
		<tr>
			<td width="33%" height="310px"><div id="chartsdr"></div></td>
			<td width="33%" height="310px"></td>
			<td width="33%" height="310px"></td>
			
		</tr>
		<tr>
			<th colspan="3" bgcolor="000000"><font color="FFFFFF">MOBILITY</font></th>
		</tr>
		<tr>
			<td width="33%" height="310px"><div id="chartifho"></div></td>
			<td width="33%" height="310px"><div id="chartltegeranred"></div></td>
			<td width="33%" height="310px"><div id="chartltewcdmared"></div></td>
		</tr>
		<tr>
			<th colspan="3" bgcolor="000000"><font color="FFFFFF">THROUGHPUT</font></th>
		</tr>
		<tr>
			<td width="33%" height="310px"><div id="chartcelldlthr"></div></td>
			<td width="33%" height="310px"><div id="chartcellulthr"></div></td>
			<td width="33%" height="310px"></td>
		</tr>
		<tr>
			<th colspan="3" bgcolor="000000"><font color="FFFFFF">PAYLOAD</font></th>
		</tr>
		<tr>
			<td width="33%" height="310px"><div id="chartpayloaddl"></div></td>
			<td width="33%" height="310px"><div id="chartpayloadul"></div></td>
			<td width="33%" height="310px"><div id="chartpayloadtot"></div></td>
		</tr>
		<tr>
			<th colspan="3" bgcolor="000000"><font color="FFFFFF">USER NUMBER</font></th>
		</tr>
		<tr>
			<td width="33%" height="310px"><div id="chartavguser"></div></td>
			<td width="33%" height="310px"><div id="chartmaxuser"></div></td>
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
          center: new google.maps.LatLng(-8.4299748, 114.7290626),
          zoom: 12,
		  mapTypeId: 'satellite'
        });
        var infoWindow = new google.maps.InfoWindow;

		var ctaLayer = new google.maps.KmlLayer({
          url: 'http://31.220.57.21/swap_bali/swap_bali_online.kmz',
          map: map
        });

          // Change this depending on the name of your PHP or XML file
          downloadUrl('cobaxm.php', function(data) {
            var xml = data.responseXML;
            var markers = xml.documentElement.getElementsByTagName('marker');
            Array.prototype.forEach.call(markers, function(markerElem) {
              var name = markerElem.getAttribute('name');
			  var region= markerElem.getAttribute('region');
			  var status= markerElem.getAttribute('status');
			  var name = markerElem.getAttribute('name');
              var region = markerElem.getAttribute('region');
			  var cat = markerElem.getAttribute('status');
			  var ava = markerElem.getAttribute('siteid');
			  var ava2 = markerElem.getAttribute('status');
			  var ava3 = markerElem.getAttribute('sys');
			  var ava4 = markerElem.getAttribute('colo2g');
			  var ava5 = markerElem.getAttribute('colo4g');
              var address = markerElem.getAttribute('address');
			  
              var type = markerElem.getAttribute('type');
              var point = new google.maps.LatLng(
                  parseFloat(markerElem.getAttribute('lat')),
                  parseFloat(markerElem.getAttribute('lng')));

              var infowincontent = document.createElement('div');
              var strong = document.createElement('strong');
              strong.textContent = name
              infowincontent.appendChild(strong);
              infowincontent.appendChild(document.createElement('br'));

              var text = document.createElement('text');
              text.textContent = name
			  infowincontent.appendChild(text);
			  infowincontent.appendChild(document.createElement('br'));
			  
			  var indexname =  ["SITEID :","STATUS :","SYSTEM :","COLO 2G :","COLO 4G :"];
			  var indexval =  [ava, ava2, ava3,ava4, ava5];
			  
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
			  
			  
              
              marker.addListener('click', function() {
                infoWindow.setContent(infowincontent);
                infoWindow.open(map, marker);
              });
            });
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
	  

		//function round up
	  function roundNumber(rnum, rlength) { 
		var newnumber = Math.round(rnum * Math.pow(10, rlength)) / Math.pow(10, rlength);
		return newnumber;	
		}	
		/*
		function configureDropDownListsdong(ddl1,ddl2) {
		<?php 
		$result3 = mysql_query("SELECT Distinct SITEID FROM 3g_nodebhourly ORDER BY SITEID",$connect);
			while ($row3 = mysql_fetch_array($result3)) {
				$siteid[] = "'".$row3['SITEID']."'";
				
		$tgl = mysql_query("SELECT Distinct Date FROM 3g_nodebhourly ORDER BY Date",$connect);
			while ($row = mysql_fetch_array($tgl)) {
				$tgl_site[] = "'".date('Ymd',strtotime($row['Date']))."'";
			}
			}?>
			var site = [<?php echo join($siteid, ',') ?>];	
			var tglsite = [<?php echo join($tgl_site, ',') ?>];
			var str='';
			
		switch (ddl1.value) {
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
		switch (ddl1.value) {
			case 'Site':
				ddl3.options.length = 0;
				ddl4.options.length = 0;
				for (i = 0; i < tglcluster.length; i++) {
					createOption(ddl3, tglsite[i], tglsite[i]);
					createOption(ddl4, tglsite[i], tglsite[i]);
				}
				break;
				default:
					ddl3.options.length = 0;
					ddl4.options.length = 0;
				break;
		}
		
		 function createOption(ddl, text, value) {
        var opt = document.createElement('option');
        opt.value = value;
        opt.text = text;
        ddl.options.add(opt);
    }
		}
		
		*/	
		
/*
     function configureDropDownLists(ddl1,ddl2) {
		 <?php
		 
			#query untuk object cluster/region/site
		 	$result = mysql_query("SELECT Distinct Cluster FROM Cluster3GDay WHERE Region='SUMBAGUT' ORDER BY Cluster",$connect);
			while ($row = mysql_fetch_array($result)) {
				$clustername[] = "'".$row['Cluster']."'";
			}
			
			$result2 = mysql_query("SELECT Distinct Region FROM Region3GDay WHERE Region='SUMBAGUT' ORDER BY Region",$connect);
			while ($row2 = mysql_fetch_array($result2)) {
				$Region[] = "'".$row2['Region']."'";
			}
			
			$result3 = mysql_query("SELECT Distinct SITEID FROM Site3GDay WHERE Region='SUMBAGUT' ORDER BY SITEID",$connect);
			while ($row3 = mysql_fetch_array($result3)) {
				$siteid[] = "'".$row3['SITEID']."'";
			}
			
			#query untuk date
			
			$tgl = mysql_query("SELECT Distinct Date FROM Cluster3GDay WHERE Region='SUMBAGUT' ORDER BY Date",$connect);
			while ($row = mysql_fetch_array($tgl)) {
				$tgl_cluster[] = "'".date('Ymd',strtotime($row['Date']))."'";
			}
			
			$tgl = mysql_query("SELECT Distinct Date FROM Region3GDay WHERE Region='SUMBAGUT' ORDER BY Date",$connect);
			while ($row = mysql_fetch_array($tgl)) {
				$tgl_region[] = "'".date('Ymd',strtotime($row['Date']))."'";
			}
			
			$tgl = mysql_query("SELECT Distinct Date FROM Site3GDay WHERE Region='SUMBAGUT' ORDER BY Date",$connect);
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
*/
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
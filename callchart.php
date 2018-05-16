<?php

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

$result = mysql_query("SELECT Date, CellID, `CSSR_CS(%)`,`CSSR_PS(%)`,`CSSR_HSDPA(%)` FROM 3g_celldaily",$connect);
		
			while ($row = mysql_fetch_array($result)) {
				$cssrcs[]=$row['CSSR_CS(%)'];
				$CSSRPS[]=$row['CSSR_PS(%)'];
				$CSSRHSDPA[]=$row['CSSR_HSDPA(%)'];
				
				/*
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
  
  
				
				include_once ("3gchartlib2.php");
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
?>
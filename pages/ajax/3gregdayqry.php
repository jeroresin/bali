<?php
include('../../connect.php');
$connect = mysql_connect($hostname, $username, $password) or die('Could not connect: ' . mysql_error());
$bool = mysql_select_db($database, $connect);
if ($bool === False){
   print "can't find $database";
}
$where = "where 1=1";
$cluster_name = "";
$cl_name = "";

if(isset($_POST['filter_by_date']) || ($_POST['region'])):
	if(isset($_POST['daterange']) && !empty($_POST['daterange']) && intval($_POST['filter_by_date']) == 1):
		$dates = explode("-",$_POST['daterange']);
		$where .= " and date(Date) between '".date("Y-m-d",strtotime($dates[0]))."' and '".date("Y-m-d",strtotime($dates[1]))."'";

	endif;
	endif;
	
	if(isset($_POST['region']) && !empty($_POST['region'])):
		$where .= " and Cluster ='".$_POST['region']."'";
		$cl_name = " - ".$_POST['region'];	
		$SQL_DAY = "select distinct Date,Cluster, `CSSR CS` as cssrcs,`CSSR PS` as cssrps,`CSSR HSDPA` as cssrhsdpa,`CSSR HSUPA` as cssrhsupa,`CCSR CS` as ccsrcs,`CCSR PS` as ccsrps,`CCSR HSDPA` as ccsrhsdpa,`CCSR HSUPA` as ccsrhsupa,`ISHO` as isho,`SHO` as sho,`IFHO` as ifho from Cluster3GDay ".$where;		
	elseif(isset($_POST['rnc']) && !empty($_POST['rnc'])):
	$where .= " and left(Site_ID,6) ='".$_POST['rnc']."'";	
	$cluster_name = " - ".$_POST['rnc'];
	$SQL_DAY = "select distinct Date,Site_ID, `CSSR CS` as cssrcs,`CSSR PS` as cssrps,`CSSR HSDPA` as cssrhsdpa,`CSSR HSUPA` as cssrhsupa,`CCSR CS` as ccsrcs,`CCSR PS` as ccsrps,`CCSR HSDPA` as ccsrhsdpa,`CCSR HSUPA` as ccsrhsupa,`ISHO` as isho,`SHO` as sho,`IFHO` as ifho from Site3GDayClust ".$where;
else:
	$SQL_DAY = "select date(Date) as Date, `CSSR CS` as cssrcs,`CSSR PS` as cssrps,`CSSR HSDPA` as cssrhsdpa,`CSSR HSUPA` as cssrhsupa,`CCSR CS` as ccsrcs,`CCSR PS` as ccsrps,`CCSR HSDPA` as ccsrhsdpa,`CCSR HSUPA` as ccsrhsupa,`ISHO` as isho,`SHO` as sho,`IFHO` as ifho from Region3GDay ".$where;
endif;

$fetch = array();
$qry = mysql_query($SQL_DAY, $connect); 
while($row=mysql_fetch_assoc($qry)){
$chart_date[]= date("d M",strtotime($row['Date']));
$region[] = $row['Region'];
$cluster[] = $row['Cluster'];
$cssr_cs[] = floatval($row['cssrcs']);
$cssr_ps[] = floatval($row['cssrps']);
$cssr_hsdpa[] = floatval($row['cssrhsdpa']);
$cssr_hsupa[] = floatval($row['ccsrhsupa']);
$ccsr_cs[] = floatval($row['ccsrcs']);
$ccsr_ps[] = floatval($row['ccsrps']);
$ccsr_hsdpa[] = floatval($row['ccsrhsdpa']);
$ccsr_hsupa[] = floatval($row['ccsrhsupa']);
$isho_[] = floatval($row['isho']);
$sho_[] = floatval($row['sho']);
$ifho_[] = floatval($row['ifho']);
}

$return = array(
	"chart_title" => "Sumbagteng 3G KPI".$cluster_name,
	"date" => $chart_date,
	"region" => $region,
	"data" =>array(array(
		"container" => "cssr",
		"name" => "CSSR CS",
		"color" => "#04B4AE",
		"data" => $cssr_cs
	),array(
		"container" => "cssrps",
		"name" => "CSSR PS",
		"color" => "#BF00FF",
		"data" => $cssr_ps
	),array(
		"container" => "cssrhsdpa",
		"name" => "CSSR HSDPA",
		"color" => "#FE642E",
		"data" => $cssr_hsdpa
	),array(
		"container" => "cssrhsupa",
		"name" => "CSSR HSDPA",
		"color" => "#FE642E",
		"data" => $cssr_hsdpa
	),array(
		"container" => "ccsrcs",
		"name" => "CCSR CS",
		"color" => "#04B4AE",
		"data" => $ccsr_cs
	),array(
		"container" => "ccsrps",
		"name" => "CCSR PS",
		"color" => "#BF00FF",
		"data" => $ccsr_ps
	),array(
		"container" => "ccsrhsdpa",
		"name" => "CCSR HSDPA",
		"color" => "#FE642E",
		"data" => $ccsr_hsdpa
	},array(
		"container" => "ccsrhsupa",
		"name" => "CCSR HSUPA",
		"color" => "#FE642E",
		"data" => $ccsr_hsupa
	),array(
		"container" => "isho",
		"name" => "ISHO",
		"color" => "#BF00FF",
		"data" => $isho_
	),array(
		"container" => "sho",
		"name" => "SHO",
		"color" => "#FE642E",
		"data" => $sho_
	},array(
		"container" => "ifho",
		"name" => "IFHO",
		"color" => "#FE642E",
		"data" => $ifho_
	))
);
header('Content-type: application/json');
echo json_encode($return);die;
?>
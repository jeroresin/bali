<?php
include('../../connect.php');
$connect = mysql_connect($hostname, $username, $password) or die('Could not connect: ' . mysql_error());
$bool = mysql_select_db($database, $connect);
if ($bool === False){
   print "can't find $database";
}

$where = "where 1=1";

if(isset($_REQUEST['region']) && !empty($_REQUEST['region'])):
	$where .= " and Cluster ='".$_REQUEST['region']."'";
else:
	$where .= " and Region ='Sumbagteng'";
endif;
//
$SQL_DAY = "select SITEID from Site3GDayClust ".$where." group by 1";

$fetch = array();
$qry = mysql_query($SQL_DAY, $connect); 
	echo '<option value="">SITE_ID</option>';
while($row=mysql_fetch_assoc($qry)){
	echo '<option value="'.$row['SITEID'].'">'.$row['SITEID'].'</option>';
}
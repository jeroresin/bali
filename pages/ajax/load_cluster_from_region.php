<?php
include('../../connect.php');
$connect = mysql_connect($hostname, $username, $password) or die('Could not connect: ' . mysql_error());
$bool = mysql_select_db($database, $connect);
if ($bool === False){
   print "can't find $database";
}

$where = "where 1=1";

if(isset($_REQUEST['region']) && !empty($_REQUEST['region'])):
	$where .= " and Region ='".$_REQUEST['region']."'";
else:
	$where .= " and Region ='Sumbagteng'";
endif;
//
$SQL_DAY = "select Cluster from Cluster3GDay ".$where." group by 1";

$fetch = array();
$qry = mysql_query($SQL_DAY, $connect); 
	echo '<option value="">CLUSTER</option>';
while($row=mysql_fetch_assoc($qry)){
	echo '<option value="'.$row['Cluster'].'">'.$row['Cluster'].'</option>';
}
<?php
	include('connect.php');
	$con = mysql_connect($hostname, $username, $password)
	or die('Could not connect: ' . mysql_error());
	//Select The database
	$bool = mysql_select_db($database, $con);
	if ($bool === False){
	   print "can't find $database";
	}
 
	

	$result = mysql_query("SELECT status,total FROM swap_status_global", $con);
	$rows=array();
	while($r = mysql_fetch_array($result)) {
		$row[0] = $r[0];
		$row[1] = $r[1];
		array_push($rows,$row);
	}
 
print json_encode($rows, JSON_NUMERIC_CHECK);
mysql_close($con);
?>
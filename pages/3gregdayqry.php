<?php

$SQL_DAY = "select date(Date) as Date, `CSSR CS` as cssrcs,`CSSR PS` as cssrps,`CSSR HSDPA` as cssrhsdpa from Region3GDay where Region ='Sumbagteng'";
$fetch = array();
$qry = mysql_query($SQL_DAY, $connect); 
$chart_date = [];
while($row=mysql_fetch_assoc($qry)){
$date = "'".date("d M",strtotime($row['Date']))."',";
$region = "".$row['Region'].",";
$cssr_cs = "".$row['cssrcs'].",";
$cssr_ps .= "".$row['cssrps'].",";
$cssr_hsdpa .= "".$row['cssrhsdpa'].",";
}

?>
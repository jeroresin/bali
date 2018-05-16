<?php
require("phpsqlajax_dbinfo.php");

function parseToXML($htmlStr)
{
$xmlStr=str_replace('<','&lt;',$htmlStr);
$xmlStr=str_replace('>','&gt;',$xmlStr);
$xmlStr=str_replace('"','&quot;',$xmlStr);
$xmlStr=str_replace("'",'&#39;',$xmlStr);
$xmlStr=str_replace("&",'&amp;',$xmlStr);
return $xmlStr;
}

// Opens a connection to a MySQL server
$connection=mysql_connect ('localhost',$username, $password);
if (!$connection) {
  die('Not connected : ' . mysql_error());
}

// Set the active MySQL database
$db_selected = mysql_select_db($database, $connection);
if (!$db_selected) {
  die ('Can\'t use db : ' . mysql_error());
}

// Select all the rows in the markers table
$query = "SELECT a.*, b.* FROM 3g_siteID_PKU_ceklist a LEFT JOIN v3gcoloinfo_pku b ON b.3gsiteid = a.siteid";
$result = mysql_query($query);
if (!$result) {
  die('Invalid query: ' . mysql_error());
}
header("Content-type: text/xml");

// Start XML file, echo parent node
echo '<markers>';

while ($row = @mysql_fetch_assoc($result)){
  // Add to XML document node
  echo '<marker ';
  echo 'name="' . parseToXML($row['sitename']) . '" ';
  echo 'lat="' . $row['lat'] . '" ';
  echo 'lng="' . $row['lng'] . '" ';
  echo 'region="' . $row['regional'] . '" ';
  echo 'status="' . $row['status'] . '" ';
  echo 'siteid="' . $row['siteid'] . '" ';
  echo 'sys="' . $row['system'] . '" ';
  echo 'colo2g="' . $row['2gcolo'] . '" ';
  echo 'colo4g="' . $row['4gcolo'] . '" ';
  echo '/>';
}
// End XML file
echo '</markers>';

?>
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

$c1 = mysql_query("SELECT count(*) as countc1 FROM qoe_convert WHERE dl_rtt < 200 and RAT='1'", $connect);
$num_rows_c1 = mysql_fetch_array($c1);
$numc1 = $num_rows_c1['countc1'];

$c2 = mysql_query("SELECT count(*) as countc2 FROM qoe_convert WHERE dl_rtt between 200 and 300 and RAT='1'", $connect);
$num_rows_c2 = mysql_fetch_array($c2);
$numc2 = $num_rows_c2['countc2'];


$c3 = mysql_query("SELECT count(*) as countc3 FROM qoe_convert WHERE dl_rtt > 300 and RAT='1'", $connect);
$num_rows_c3 = mysql_fetch_array($c3);
$numc3 = $num_rows_c3['countc3'];

?>
<style type="text/css">
<!--
.style1 {
	font-family: Geneva, Arial, Helvetica, sans-serif;
	color: #FFFFFF;
}
-->
</style>


	<table class="roundedCorners" width="100%">
		<tr>
		  <th colspan="3" bgcolor="#FF8000"><div align="center" class="style1">4G QOE Latency </div></th>
	  </tr>
		<tr>
			<th height="26"><span class="style5"><img src="http://labs.google.com/ridefinder/images/mm_20_green.png">Below 200(<?php echo $numc1; ?>)</span></th>
			<th><span class="style5"><img src="http://labs.google.com/ridefinder/images/mm_20_yellow.png">200-300(<?php echo $numc2; ?>)</span></th>
			<th><span class="style5"><img src="http://labs.google.com/ridefinder/images/mm_20_red.png">Above 300(<?php echo $numc3; ?>)</span></th>
		</tr>
	</table>
	<div class="map_canvas" style="height:95%;margin-top:10px;width:100%"></div>
</div>
<script>
var customLabel = {
	Green: {
		icon: 'http://labs.google.com/ridefinder/images/mm_20_green.png',
		warna: '#4dff88'
	},
	Red: {
		icon: 'http://labs.google.com/ridefinder/images/mm_20_red.png',
		warna: '#e60000'
	},
	Yellow: {
		icon: 'http://labs.google.com/ridefinder/images/mm_20_yellow.png',
		warna: '#ffff66'
	}
};

function initMap() {
	mapClass = $('.map_canvas');
	map = new google.maps.Map(mapClass[0],
	{
		center: new google.maps.LatLng(-6.2085919, 106.8295673),
		zoom: 11,
		mapTypeId: 'satellite'
	});
	var infoWindow = new google.maps.InfoWindow;

// Change this depending on the name of your PHP or XML file
downloadUrl('markers_lat.php', function(data) {
var xml = data.responseXML;
var markers = xml.documentElement.getElementsByTagName('marker');
Array.prototype.forEach.call(markers, function(markerElem) {
  var name = markerElem.getAttribute('name');
  var cate = markerElem.getAttribute('cat');
  var region = markerElem.getAttribute('region');
  var dllatency = markerElem.getAttribute('dl_latency');

  var rad = markerElem.getAttribute('rad');
  var point = new google.maps.LatLng(
	  parseFloat(markerElem.getAttribute('lat')),
	  parseFloat(markerElem.getAttribute('lng')));

  var infowincontent = document.createElement('div');
  var strong = document.createElement('strong');
  strong.textContent = name
  infowincontent.appendChild(strong);
  infowincontent.appendChild(document.createElement('br'));

  var text = document.createElement('text');
  text.textContent = 'DL Latency :'+roundNumber(dllatency,2)
  infowincontent.appendChild(text);
  infowincontent.appendChild(document.createElement('br'));


	var indexname =  ["POI Name : ", "Region :", "DL RTT:"];
  var indexval =  [name, region, dllatency];

  var i = 0;
  var len = indexname.length;

  for (;i<len;) {

	  var text = document.createElement('text');
	  text.textContent = indexname[i] + roundNumber(indexval[i],3)
	  infowincontent.appendChild(text)
	  infowincontent.appendChild(document.createElement('br'));

	  i++;
  }



  var icon = customLabel[cate] || {};
  var sitename = markerElem.getAttribute('name');
  var marker = new google.maps.Marker({
	map: map,
	position: point,
	icon: icon.icon
  });

  //untuk draw lingkaran
  var cityCircle = new google.maps.Circle({
  map: map,
  radius: rad*1,
  center: point,
  strokeColor: icon.warna,
  strokeOpacity: 0.8,
  strokeWeight: 2,
  fillColor: icon.warna,
  fillOpacity: 0.35
  });


  marker.addListener('click', function() {
  infoWindow.setContent(infowincontent);
  infoWindow.open(map, marker, cityCircle);
  });

});
});
}

//function round up
function roundNumber(rnum, rlength) {
var newnumber = Math.round(rnum * Math.pow(10, rlength)) / Math.pow(10, rlength);
return newnumber;
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
initMap();
</script>
    
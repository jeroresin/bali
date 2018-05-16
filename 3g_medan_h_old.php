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
	
	$c1 = mysql_query("SELECT * FROM 3g_siteID_ceklist  WHERE status = 'swapped'", $connect);
	$num_rows_c1 = mysql_num_rows($c1);
	
	$c2 = mysql_query("SELECT * FROM 3g_siteID_ceklist WHERE status = 'not_swap'", $connect);
	$num_rows_c2 = mysql_num_rows($c2);
	
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
	<div id="map"></div>
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
          center: new google.maps.LatLng(3.6195757, 98.6883881),
          zoom: 12,
		  mapTypeId: 'satellite'
        });
        var infoWindow = new google.maps.InfoWindow;

          // Change this depending on the name of your PHP or XML file
          downloadUrl('3g_markers.php', function(data) {
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
				var ava4 = markerElem.getAttribute('colo2g');
			  var ava5 = markerElem.getAttribute('colo4g');
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
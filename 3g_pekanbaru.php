<!DOCTYPE html>
<html>
<?php 
include('session.php');
?>

<?php
include('connect.php');

if (isset($_POST['region'])) {
$id = ($_POST['region']);
}

$connect = mysql_connect($hostname, $username, $password)
	or die('Could not connect: ' . mysql_error());
	//Select The database
	$bool = mysql_select_db($database, $connect);
	if ($bool === False){
	   print "can't find $database";
	}

?>
  
    <style>
    .cssr{width:100% !important; height:100% !important;}
	.stage-240 {height:240px}
		.stage-260 {height:275px}
	.stage-130 {height:112px}
	 /* nanti heightnya bisa diganti disini */
  .style1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-weight: bold;
}
</style>


<head>
  <title>Swap Sumatera 3G Pekanbaru</title>
    <meta name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no' />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
	
	
	<link rel="stylesheet" href="assets/css/detail.css">
	<link rel="stylesheet" href="assets/slick/slick.css">
	<link rel="stylesheet" href="assets/slick/slick-theme.css">
	<script type="text/javascript" src="js/jquery.min.js"></script>
	 <script type="text/javascript" src="js/highcharts.js"></script> 
	 <script type="text/javascript" src="js/highcharts-3d.js"></script>  
	 <script type="text/javascript" src="js/modules/no-data-to-display.js"></script>
  <script type="text/javascript" src="js/modules/exporting.js"></script>


  <link rel="stylesheet" type="text/css" href="assets/lib/bootstrap/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" type="text/css" href="assets/css/keen-dashboards.css" />
  <link rel="stylesheet" href="css/style.css"></head>
<body class="application">
<div id="mySidenav" class="sidenav">
	<a href="javascript:void(0)" class="closebtn" onClick="closeNav()">&times;</a>
	<a href="#">2G Pekanbaru</a>
	<a href="logout.php">Sign Out</a>
</div>

	<div class="header" id="main">
	<?php
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
	

	
	
	$c1 = mysql_query("SELECT * FROM 3g_siteID_PKU_ceklist  WHERE status = 'swapped'", $connect);
	$num_rows_c1 = mysql_num_rows($c1);
	
	$c2 = mysql_query("SELECT * FROM 3g_siteID_PKU_ceklist WHERE status = 'not_swap'", $connect);
	$num_rows_c2 = mysql_num_rows($c2);
	
  ?>
  
		<div class="roundedCorners">
			<table>
				<tr>
					<th>Done (<?=$num_rows_c1?>)<img src="http://www.googlemapsmarkers.com/v1/H/FA5858/"> </th>
					<th>NotYet (<?=$num_rows_c2?>)<img src="http://www.googlemapsmarkers.com/v1/E/0099FF/"> </th>
				</tr>
			</table>
		</div>
		<div style="font-size:25px;cursor:pointer;padding-top:10px" onClick="openNav()"><i class="glyphicon glyphicon-menu-hamburger"></i> Menu</div>  	
		<img src="images/Huawei.jpeg"/>
		<img src="images/Telkomsel.png"/>  
	</div>
    <div class="container-fluid">

  <div class="row">
      <div class="col-sm-10">
        <div class="chart-wrapper">
          <div class="chart-title"><strong>
        </span></div>
          <div class="chart-stage style1">
            

              <?php include('pages/3gmap.php'); ?> 
          </div>
          <div class="chart-notes style1"></div>
        </div>
      </div>
    <div class="col-sm-2">
<div class="chart-wrapper">
          <div class="chart-title">
              <div align="center"><strong>Swap Progress CS              </strong></div>
        </div>
          <div class="chart-stage">
		  <?php include('swapstatus2.php'); ?> 
			<div class="chart-stage stage-130">
		
			<div id="container" style="height:100%;width:100%"></div> 
			</div>  
			<div class="chart-stage stage-130">
			<div id="container2" style="height:100%;width:100%"></div> 
			</div> 
			<div class="chart-stage stage-130">
			<div id="container3" style="height:100%;width:100%"></div> 
			</div> 
		  </div>  
			
      </div>
          <div class="chart-notes"></div>
        </div>
      </div>
    </div>
      <div class="col-sm-12">
        <div class="chart-wrapper">
          <div class="chart-title"><strong> </strong></div>
          <div class="chart-stage">
			 <?php include('pages/form3gpku.php'); ?>
            <div class="chart-notes"></div>
        </div>
      </div>
    </div>

    <div class="row">
	      <div class="col-sm-12">
        <div class="chart-wrapper">
    
          <div class="chart-stage  >
            <div align="center" style="background:#EEEAEA">
            <div align="center" class="style1">ACCESSIBILITY</div>
          </div>
        </div>
        </div>
    
      <div class="col-sm-6">
        <div class="chart-wrapper">
          <div class="chart-title">
          </div>
		  <div class="chart-stage stage-240">
				<div id="cssr" style="height:100%"></div>
		  </div>
          
        </div>
      </div>
      <div class="col-sm-6">
        <div class="chart-wrapper">
          <div class="chart-title">

          </div>
          <div class="chart-stage stage-240">
           <div id="cssrps" style="height:100%"></div>
          </div>
 
        </div>
      </div>
      <div class="col-sm-6">
        <div class="chart-wrapper">
          <div class="chart-title">
    
          </div>
         <div class="chart-stage stage-240">
           <div id="cssrhsdpa" style="height:100%"></div>
          </div>
        </div>
      </div>
	  
	   <div class="col-sm-6">
        <div class="chart-wrapper">
          <div class="chart-title">
          </div>
		  <div class="chart-stage stage-240">
				<div id="cssrhsupa" style="height:100%"></div>
		  </div>
          
        </div>
      </div>
	  
	        <div class="col-sm-12">
        <div class="chart-wrapper">
    
          <div class="chart-stage  >
            <div align="center" style="background:#EEEAEA">
            <div align="center" class="style1">RETAINABILITY</div>
          </div>
        </div>
        </div>
 
	  
      <div class="col-sm-6">
        <div class="chart-wrapper">
          <div class="chart-title">

          </div>
          <div class="chart-stage stage-240">
           <div id="ccsrcs" style="height:100%"></div>
          </div>
 
        </div>
      </div>
      <div class="col-sm-6">
        <div class="chart-wrapper">
          <div class="chart-title">
    
          </div>
         <div class="chart-stage stage-240">
           <div id="ccsrps" style="height:100%"></div>
          </div>
        </div>
      </div>
	  <div class="col-sm-6">
        <div class="chart-wrapper">
          <div class="chart-title">
    
          </div>
         <div class="chart-stage stage-240">
           <div id="ccsrhsdpa" style="height:100%"></div>
          </div>
        </div>
      </div>
	   <div class="col-sm-6">
        <div class="chart-wrapper">
          <div class="chart-title">
          </div>
		  <div class="chart-stage stage-240">
				<div id="ccsrhsupa" style="height:100%"></div>
		  </div>
          
        </div>
      </div>
	  
	  <div class="col-sm-12">
        <div class="chart-wrapper">
    
          <div class="chart-stage  >
            <div align="center" style="background:#EEEAEA">
            <div align="center" class="style1">MOBILITY</div>
          </div>
        </div>
        </div>
	  <div class="col-sm-6 col-md-4">
        <div class="chart-wrapper">
          <div class="chart-title">
    
          </div>
         <div class="chart-stage stage-240">
           <div id="isho" style="height:100%"></div>
          </div>
        </div>
      </div>
	  <div class="col-sm-6 col-md-4">
        <div class="chart-wrapper">
          <div class="chart-title">
    
          </div>
         <div class="chart-stage stage-240">
           <div id="sho" style="height:100%"></div>
          </div>
        </div>
      </div>
	   <div class="col-sm-6 col-md-4">
        <div class="chart-wrapper">
          <div class="chart-title">
          </div>
		  <div class="chart-stage stage-240">
				<div id="ifho" style="height:100%"></div>
		  </div>
          
        </div>
      </div>
<!-- end of three -->

    </div>
  </div>
	<?php include('pages/chart3gpku.php'); ?>

    <hr>

    <p class="small text-muted">Copyright &copy; 2017 <a href="http://www.huawei.com">Huawei Indonesia</a> All rights
    reserved.</p>

  </div>

  <script type="text/javascript" src="assets/lib/bootstrap/dist/js/bootstrap.min.js"></script>

  <script type="text/javascript" src="assets/lib/holderjs/holder.js"></script>
  <script>
    Holder.add_theme("white", { background:"#fff", foreground:"#a7a7a7", size:10 });
  </script>

  <script type="text/javascript" src="assets/lib/keen-js/dist/keen.min.js"></script>
  <script type="text/javascript" src="assets/js/meta.js"></script>
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
</body>
</html>

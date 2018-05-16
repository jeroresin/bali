<?php
// In this page, we open the connection to the Database
// In this page, we open the connection to the Database
// Our MySQL database (blueprintdb) for the Blueprint Application
// Function to connect to the DB
// Now you can pass the database name to the function
//sqlsrv_configure("LogSubsystems", SQLSRV_LOG_SYSTEM_CONN);

//sqlsrv_configure("LogSeverity", SQLSRV_LOG_SEVERITY_ALL);
//set_time_limit(120);
function connectToDB( $dbName="" ) {
    // These four parameters must be changed dependent on your MySQL settings
   
  /* $hostdb = "localhost";   // 
   $connectionInfo = array( "UID"=>'root',
                       "PWD"=>'',
                      "Database"=>'smartcaredb');*/
	
   $hostdb = "localhost";   // 
   $connectionInfo = array( "UID"=>'ibnu',
                       "PWD"=>'pascal',
                      "Database"=>'swap_sumatera');
		

  	$link =  mysqli_connect (trim($hostdb), trim($connectionInfo["UID"]),trim($connectionInfo["PWD"]),trim($connectionInfo["Database"]));
  // echo "val:".$link[0];
   
    //var_dump($connectionInfo);
	
	//var_dump($link);
	//var_dump(sqlsrv_client_info($link));
	
    if (!$link) {
        // we should have connected, but if any of the above parameters
        // are incorrect or we can't access the DB for some reason,
        // then we will stop execution here
		//echo "error:".mysqli_connect_error();
       die('Could not connect: ' . var_dump(mysqli_connect_error()));
    } 

  //  $db_selected = mysql_select_db($namedb);
   // if (!$db_selected) {
   //     die ('Can\'t use database : ' . mysql_error());
   // }
    return $link;
}


function add_date($givendate,$day=0,$mth=0,$yr=0) {
      $cd = strtotime($givendate);
      $newdate = date('Y-m-d', mktime(date('h',$cd),
    date('i',$cd), date('s',$cd), date('m',$cd)+$mth,
    date('d',$cd)+$day, date('Y',$cd)+$yr));
      return $newdate;
              }
function connectToDBB( $dbName="" ) {

   $hostdb = "127.0.0.1:3308";   // 
   $connectionInfo = array( "UID"=>'ibnu',
                       "PWD"=>'pascal',
					   
                      "Database"=>'swap_sumatera');
  	
  	$link =  mysqli_connect ($hostdb, $connectionInfo["UID"],$connectionInfo["PWD"],$connectionInfo["Database"]);
}

function rChart($area,$areadata,$tabletarget,$datefrom,$dateto,$kpi,$tipe,$baseline) {
	$FC = NULL;

	$kpiid=str_replace("_%","",$kpi);
	$kpiid=str_replace("(%)","",$kpiid);
	$kpiid=str_replace("%","",$kpiid);
 	$FC = new FusionCharts($tipe,"400","250",$kpiid); 
	$FC->setInitParam("registerWithJS",true);
    $conn=connectToDBB();
	
	
	$strBase = "SELECT CAST([(EPL)] AS NUMERIC(18,2)) AS EPL,CAST([(MPL)] AS NUMERIC(18,2)) AS MPL FROM ".$baseline." WHERE KPI_NAME='".$kpi."';";
	$resBase = mysqli_query($conn,$strBase) or die("Error Baseline".mysqli_connect_error());
	$valepl="";
	if ($resBase!== NULL) {
	$rowdt=smysqli_num_rows($resBase);
	
		if ($rowdt){
			$DataBaseline = mysqli_fetch_array($resBase);
			$FC->addTrendLine("startValue=".$DataBaseline[0].";color=ff0000;displayvalue=NetQB;showOnTop=1;valueOnRight=1");
			//$FC->addTrendLine("startValue=".$DataBaseline[1].";color=000000;displayvalue=MPL;showOnTop=1;valueOnRight=1");
			$valepl = $DataBaseline[0]." %";
			//$valmpl = $DataBaseline[1]." %";
		}
	}
	mysqli_free_result($resBase);
	if ($valepl!==""){
		$valcaption=$kpi." (NetQB ".$valepl.")";
	//echo $valcaption;
	}else {
		$valcaption=$kpi;
	}
	
	//end Fetching Baseline
	//====================================================
	
	





	# Set Relative Path of swf file.
 	$FC->setSWFPath("ChartsBasic/");
		
	# Define chart attributes
	$strParam="caption=".$valcaption.";showValues=0;labelDisplay=ROTATE;exportShowMenuItem=1;exportEnabled=1;aboutMenuItemLabel=About HuaweiIndonesia;aboutMenuItemLink=n-http://www.Huawei.com;showExportDataMenuItem=1;setAdaptiveYMin=1;exportAtClient=1;exportDialogMessage=Please wait..;exportHandler=".$kpiid."xx;exportFileName=".$kpiid."xx;exportFileName=".$kpi."_".$areadata."_".$datefrom."_".$dateto."";

 	#  Set Chart attributes
 	$FC->setChartParams($strParam);
	
	#add chart data values and category names
	 $strQuery = "SELECT dbo.fnFormatDate(DATE_ID,'m/d/yy') AS [DATE_],CAST([".$kpi."] AS NUMERIC(18,2)) AS [".$kpi."_]  FROM ".$tabletarget." WHERE ".$area."='".$areadata."' AND  LEFT(DATE_ID,10)>='".$datefrom."' AND LEFT(DATE_ID,10)<='".$dateto."' ORDER BY LEFT(DATE_ID,10);"; 
  //  echo $strQuery;
	 $result = mysqli_query($conn,$strQuery) or die("Error Main QUery".var_dump(mysqli_connect_error()));
      

 if ($result) 
  {	
		while ($row = mysqli_fetch_array($result)) {

        $FC->addChartData($row[1],"Label=".$row[0]);
		
   }

  }
	# Render  Chart 
 	$FC->renderChart();

   mysqli_free_result($result);
   mysqli_close($conn);

   echo "<div id=\"".$kpiid."kk\" align=\"center\"></div>
   <script type=\"text/javascript\">
    var myExportComponent = new FusionChartsExportObject(\"".$kpiid."xx\", \"ChartsBasic/FCExporter2.swf\");
    myExportComponent.Render(\"".$kpiid."kk\");
  </script>";
   
}
?>





<?php
// Set the JSON header
//header("Content-type: text/json");
require_once("pages/DB_conn.php");

$strmaxdate = "SELECT MAX(date) as dtk from Cluster2GDay" ;
$conn=connectToDB();
$resBase = mysqli_query($conn,$strmaxdate) or die("Error Baseline".mysqli_connect_error());
$row=mysqli_fetch_array($resBase);
$datamax = $row[0];

$iray=0;
$datebefore = add_date($datamax,-1,0,0);
$strBase = "SELECT * FROM Cluster2GDay  ORDER BY date";
$result = mysqli_query($conn,$strBase) or die(mysqli_connect_error());
if ($result) 
  {	
		while ($row = mysqli_fetch_array($result)) {
        $iray=$iray+1;
        $date_[]=date("m/d/y H:i", strtotime($row[0]));
		
		
		$PakRiriek_int_plr[]=(float)$row[6];
		$PakSukardi2nd_int_plr[]=(float)$row[7];
		$BuJuanita_int_plr[]=(float)$row[8];
		$PakSukardi1st_int_plr[]=(float)$row[9];
		$BuYetty_int_plr[]=(float)$row[10];
		
		$PakRiriek_ext_plr[]=(float)$row[11];
		$PakSukardi2nd_ext_plr[]=(float)$row[12];
		$BuJuanita_ext_plr[]=(float)$row[13];
		$PakSukardi1st_ext_plr[]=(float)$row[14];
		$BuYetty_ext_plr[]=(float)$row[15];
		
		$PakRiriek_int_lat[]=(float)$row[16];
		$PakSukardi2nd_int_lat[]=(float)$row[17];
		$BuJuanita_int_lat[]=(float)$row[18];
		$PakSukardi1st_int_lat[]=(float)$row[19];
		$BuYetty_int_lat[]=(float)$row[20];
		
		$PakRiriek_ext_lat[]=(float)$row[21];
		$PakSukardi2nd_ext_lat[]=(float)$row[22];
		$BuJuanita_ext_lat[]=(float)$row[23];
		$PakSukardi1st_ext_lat[]=(float)$row[24];
		$BuYetty_ext_lat[]=(float)$row[25];


		
		
   }
  }
  

function getPLRLastMeasTime(){
	$conn=connectToDB();
	$strSQL = "SELECT MAX(date_) as dtk from intext_vvip;";
	$rs = mysqli_query($conn,$strSQL) or die("Error SQL plrmeas".mysqli_connect_error());
    $result = mysqli_fetch_array($rs)[0];
    mysqli_free_result($rs);
    mysqli_close($conn);
    return $result;
}
  




   
  
    function getcolor($dateval) {
            $valk = $dateval;
                        if($valk=0) {
                            return "text-blue";
                        } elseif($valk<0){
                            return "text-red";
                        } else {
                            return "text-green";
                          };
  };

  
function getatper($dat1,$dat2) {
  if($dat1>$dat2) {
      return round(($dat2-$dat1)/$dat2*100.2);
  }else {
     return "-".round(($dat1-$dat2)/$dat1*100,2);
  };
};

 mysqli_free_result($result);
mysqli_close($conn);


?>
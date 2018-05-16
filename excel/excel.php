<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<body>
<?php 
$id=$_REQUEST['id'];  
if(empty($id)){$id='Jabodetabek';}
if (isset($_POST['region'])) {
$id = ($_POST['region']);
}
?>
<?php
$koneksi = mssql_connect("localhost","osshq", "Jakarta12");
            if (!$koneksi) {
                die(mssql_error());
            }
            mssql_select_db("OSS_National_Summary");
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));			
$option_chosen=$_POST['option_chosen'];
?>
<?php
if(mssql_connect( "localhost","osshq","Jakarta12" )){
   mssql_select_db( "KPI_National" );
}
$datetime = date('Ymd-His');
$filename = "$id$datetime";
include "Classes/PHPExcel.php";
include "Classes/PHPExcel/Writer/Excel2007.php";
 
$excel = new PHPExcel;
 
$excel->getProperties()->setCreator("OSSHQ");
$excel->getProperties()->setLastModifiedBy("OSSHQ");
$excel->getProperties()->setTitle("TELKOMSEL KPI DAILY REGION");
$excel->removeSheetByIndex(0);
 
 
$sheet = $excel->createSheet();
$sheet->setTitle('sheet_1');
$sheet->setCellValue("A1", "Tanggal");
$sheet->setCellValue("B1", "Region");
$sheet->setCellValue("C1", "Availability");
$sheet->setCellValue("D1", "Traffic Voice Erlang");
$sheet->setCellValue("E1", "Traffic Video Erlang");
$sheet->setCellValue("F1", "Payload PS Gbyte");
$sheet->setCellValue("G1", "Payload DL PS Gbyte");
$sheet->setCellValue("H1", "Payload UL PS Gbyte");
$sheet->setCellValue("I1", "Payload HSDPA Gbyte");
$sheet->setCellValue("J1", "Payload HSUPA GByte");
$sheet->setCellValue("K1", "CSSR CS ");
$sheet->setCellValue("L1", "CSSR CS_NUM");
$sheet->setCellValue("M1", "CSSR CS_DEN");
$sheet->setCellValue("N1", "CSSR PS ");
$sheet->setCellValue("O1", "CSSR PS_NUM");
$sheet->setCellValue("P1", "CSSR PS_DEN");
$sheet->setCellValue("Q1", "HSDPA_Acc_SR");
$sheet->setCellValue("R1", "HSDPA Access_NUM");
$sheet->setCellValue("S1", "HSDPA Access_DEN");
$sheet->setCellValue("T1", "HSUPA_Acc_SR");
$sheet->setCellValue("U1", "HSUPA Access_NUM");
$sheet->setCellValue("V1", "HSUPA Access_DEN");
$sheet->setCellValue("W1", "CCSR CS ");
$sheet->setCellValue("X1", "CCSR CS_NUM");
$sheet->setCellValue("Y1", "CCSR CS_DEN");
$sheet->setCellValue("Z1", "CCSR PS ");
$sheet->setCellValue("AA1", "CCSR PS_NUM");
$sheet->setCellValue("AB1", "CCSR PS_DEN");
$sheet->setCellValue("AC1", "HSDPA Ret SR ");
$sheet->setCellValue("AD1", "HSDPA RET_NUM");
$sheet->setCellValue("AE1", "HSDPA RET_DEN");
$sheet->setCellValue("AF1", "HSUPA Ret SR ");
$sheet->setCellValue("AG1", "HSUPA RET_NUM");
$sheet->setCellValue("AH1", "HSUPA RET_DEN");
$sheet->setCellValue("AI1", "SHO SR ");
$sheet->setCellValue("AJ1", "SHO_NUM");
$sheet->setCellValue("AK1", "SHO_DEN");
$sheet->setCellValue("AL1", "ISHO SR ");
$sheet->setCellValue("AM1", "ISHO_NUM");
$sheet->setCellValue("AN1", "ISHO_DEN");
$sheet->setCellValue("AO1", "IFHO SR ");
$sheet->setCellValue("AP1", "IFHO_NUM");
$sheet->setCellValue("AQ1", "IFHO_DEN");
$sheet->setCellValue("AR1", "SHO OH");
$sheet->setCellValue("AS1", "PS DL THP");
$sheet->setCellValue("AT1", "PS UL THP");
$sheet->setCellValue("AU1", "HSDPA User Thp");
$sheet->setCellValue("AV1", "HSUPA User Thp");
$sheet->setCellValue("AW1", "CQI Average");
$sheet->setCellValue("AX1", "VSMaxRTWP");
$sheet->setCellValue("AY1", "VSMeanRTWP");
$sheet->setCellValue("AZ1", "Code_Utilization ");
$sheet->setCellValue("BA1", "Power Uitlization");
$sheet->setCellValue("BB1", "IuB Utilization");
$sheet->setCellValue("BC1", "UL CE Utilization");

$sqlex = "SELECT CONVERT(DATE, [DAY], 101) as [DAY1]
      ,[Region] [Region]
      ,round([Availability],2) [Availability]
      ,round([Traffic Voice (Erlang)],2) [Traffic_Voice_(Erlang)]
      ,round([Traffic Video (Erlang)],2) [Traffic_Video_(Erlang)]
      ,round([Payload PS (Gbyte)],2) [Payload_PS_(Gbyte)]
      ,round([Payload DL PS (Gbyte)],2) [Payload_DL_PS_(Gbyte)]
      ,round([Payload UL PS (Gbyte)],2) [Payload_UL_PS_(Gbyte)]
      ,round([Payload HSDPA (Gbyte)],2) [Payload_HSDPA_(Gbyte)]
      ,round([Payload HSUPA (GByte)],2) [Payload_HSUPA_(GByte)]
      ,round([CSSR CS (%)],2) [CSSR_CS_(%)]
      ,round([CSSR CS_NUM],2) [CSSR_CS_NUM]
      ,round([CSSR CS_DEN],2) [CSSR_CS_DEN]
      ,round([CSSR PS (%)],2) [CSSR_PS_(%)]
      ,round([CSSR PS_NUM],2) [CSSR_PS_NUM]
      ,round([CSSR PS_DEN],2) [CSSR_PS_DEN]
      ,round([HSDPA_Acc_SR],2) [HSDPA_Acc_SR]
      ,round([HSDPA Access_NUM],2) [HSDPA_Access_NUM]
      ,round([HSDPA Access_DEN],2) [HSDPA_Access_DEN]
      ,round([HSUPA_Acc_SR],2) [HSUPA_Acc_SR]
      ,round([HSUPA Access_NUM],2) [HSUPA_Access_NUM]
      ,round([HSUPA Access_DEN],2) [HSUPA_Access_DEN]
      ,round([CCSR CS %],2) [CCSR_CS_%]
      ,round([CCSR CS_NUM],2) [CCSR_CS_NUM]
      ,round([CCSR CS_DEN],2) [CCSR_CS_DEN]
      ,round([CCSR PS (%)],2) [CCSR_PS_(%)]
      ,round([CCSR PS_NUM],2) [CCSR_PS_NUM]
      ,round([CCSR PS_DEN],2) [CCSR_PS_DEN]
      ,round([HSDPA Ret SR (%)],2) [HSDPA_Ret_SR_(%)]
      ,round([HSDPA RET_NUM],2) [HSDPA_RET_NUM]
      ,round([HSDPA RET_DEN],2) [HSDPA_RET_DEN]
      ,round([HSUPA Ret SR (%)],2) [HSUPA_Ret_SR_(%)]
      ,round([HSUPA RET_NUM],2) [HSUPA_RET_NUM]
      ,round([HSUPA RET_DEN],2) [HSUPA_RET_DEN]
      ,round([SHO SR (%)],2) [SHO_SR_(%)]
      ,round([SHO_NUM],2) [SHO_NUM]
      ,round([SHO_DEN],2) [SHO_DEN]
      ,round([ISHO SR (%)],2) [ISHO_SR_(%)]
      ,round([ISHO_NUM],2) [ISHO_NUM]
      ,round([ISHO_DEN],2) [ISHO_DEN]
      ,round([IFHO SR (%)],2) [IFHO_SR_(%)]
      ,round([IFHO_NUM],2) [IFHO_NUM]
      ,round([IFHO_DEN],2) [IFHO_DEN]
      ,round([SHO OH],2) [SHO_OH]
      ,round([PS DL THP],2) [PS_DL_THP]
      ,round([PS UL THP],2) [PS_UL_THP]
      ,round([HSDPA User Thp],2) [HSDPA_User_Thp]
      ,round([HSUPA User Thp],2) [HSUPA_User_Thp]
      ,round([CQI Average],2) [CQI_Average]
      ,round([VSMaxRTWP],2) [VSMaxRTWP]
      ,round([VSMeanRTWP],2) [VSMeanRTWP]
      ,round([Code_Utilization (%)],2) [Code_Utilization_(%)]
      ,round([Power Uitlization],2) [Power_Uitlization]
      ,round([IuB Utilization],2) [IuB_Utilization]
      ,round([UL CE Utilization],2) [UL_CE_Utilization]
  FROM [KPI_National].[dbo].[Region3G_KPI] where [Region] like '$id%' and CONVERT(DATE, [DAY], 101) between '2016-07-01' and '2016-07-31' order by CONVERT(DATE, [DAY], 101)";
$q = mssql_query( $sqlex );
$i = 2; //Dimulai dengan baris ke dua, baris pertama digunakan oleh titel kolom
while( $r = mssql_fetch_assoc( $q ) ){
$sheet->setCellValue( "A" . $i, $r['DAY1'] );
$sheet->setCellValue( "B" . $i, $r['Region'] );
$sheet->setCellValue( "C" . $i, $r ['Availability'] );
$sheet->setCellValue( "D" . $i, $r ['Traffic_Voice_(Erlang)'] );
$sheet->setCellValue( "E" . $i, $r ['Traffic_Video_(Erlang)'] );
$sheet->setCellValue( "F" . $i, $r ['Payload_PS_(Gbyte)'] );
$sheet->setCellValue( "G" . $i, $r ['Payload_DL_PS_(Gbyte)'] );
$sheet->setCellValue( "H" . $i, $r ['Payload_UL_PS_(Gbyte)'] );
$sheet->setCellValue( "I" . $i, $r ['Payload_HSDPA_(Gbyte)'] );
$sheet->setCellValue( "J" . $i, $r ['Payload_HSUPA_(GByte)'] );
$sheet->setCellValue( "K" . $i, $r ['CSSR_CS_(%)'] );
$sheet->setCellValue( "L" . $i, $r ['CSSR_CS_NUM'] );
$sheet->setCellValue( "M" . $i, $r ['CSSR_CS_DEN'] );
$sheet->setCellValue( "N" . $i, $r ['CSSR_PS_(%)'] );
$sheet->setCellValue( "O" . $i, $r ['CSSR_PS_NUM'] );
$sheet->setCellValue( "P" . $i, $r ['CSSR_PS_DEN'] );
$sheet->setCellValue( "Q" . $i, $r ['HSDPA_Acc_SR'] );
$sheet->setCellValue( "R" . $i, $r ['HSDPA_Access_NUM'] );
$sheet->setCellValue( "S" . $i, $r ['HSDPA_Access_DEN'] );
$sheet->setCellValue( "T" . $i, $r ['HSUPA_Acc_SR'] );
$sheet->setCellValue( "U" . $i, $r ['HSUPA_Access_NUM'] );
$sheet->setCellValue( "V" . $i, $r ['HSUPA_Access_DEN'] );
$sheet->setCellValue( "W" . $i, $r ['CCSR_CS_%'] );
$sheet->setCellValue( "X" . $i, $r ['CCSR_CS_NUM'] );
$sheet->setCellValue( "Y" . $i, $r ['CCSR_CS_DEN'] );
$sheet->setCellValue( "Z" . $i, $r ['CCSR_PS_(%)'] );
$sheet->setCellValue( "AA" . $i, $r ['CCSR_PS_NUM'] );
$sheet->setCellValue( "AB" . $i, $r ['CCSR_PS_DEN'] );
$sheet->setCellValue( "AC" . $i, $r ['HSDPA_Ret_SR_(%)'] );
$sheet->setCellValue( "AD" . $i, $r ['HSDPA_RET_NUM'] );
$sheet->setCellValue( "AE" . $i, $r ['HSDPA_RET_DEN'] );
$sheet->setCellValue( "AF" . $i, $r ['HSUPA_Ret_SR_(%)'] );
$sheet->setCellValue( "AG" . $i, $r ['HSUPA_RET_NUM'] );
$sheet->setCellValue( "AH" . $i, $r ['HSUPA_RET_DEN'] );
$sheet->setCellValue( "AI" . $i, $r ['SHO_SR_(%)'] );
$sheet->setCellValue( "AJ" . $i, $r ['SHO_NUM'] );
$sheet->setCellValue( "AK" . $i, $r ['SHO_DEN'] );
$sheet->setCellValue( "AL" . $i, $r ['ISHO_SR_(%)'] );
$sheet->setCellValue( "AM" . $i, $r ['ISHO_NUM'] );
$sheet->setCellValue( "AN" . $i, $r ['ISHO_DEN'] );
$sheet->setCellValue( "AO" . $i, $r ['IFHO_SR_(%)'] );
$sheet->setCellValue( "AP" . $i, $r ['IFHO_NUM'] );
$sheet->setCellValue( "AQ" . $i, $r ['IFHO_DEN'] );
$sheet->setCellValue( "AR" . $i, $r ['SHO_OH'] );
$sheet->setCellValue( "AS" . $i, $r ['PS_DL_THP'] );
$sheet->setCellValue( "AT" . $i, $r ['PS_UL_THP'] );
$sheet->setCellValue( "AU" . $i, $r ['HSDPA_User_Thp'] );
$sheet->setCellValue( "AV" . $i, $r ['HSUPA_User_Thp'] );
$sheet->setCellValue( "AW" . $i, $r ['CQI_Average'] );
$sheet->setCellValue( "AX" . $i, $r ['VSMaxRTWP'] );
$sheet->setCellValue( "AY" . $i, $r ['VSMeanRTWP'] );
$sheet->setCellValue( "AZ" . $i, $r ['Code_Utilization_(%)'] );
$sheet->setCellValue( "BA" . $i, $r ['Power_Uitlization'] );
$sheet->setCellValue( "BB" . $i, $r ['IuB_Utilization'] );
$sheet->setCellValue( "BC" . $i, $r ['UL_CE_Utilization'] );
$i++;
}
 
 
 $writer = new PHPExcel_Writer_Excel2007($excel);
 $writer->save("$filename.xlsx");
 
 ?>
</body>
</html>

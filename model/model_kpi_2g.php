<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
 
date_default_timezone_set('Asia/Jakarta');
 


class My2G {
    

    public function query2G($colom,$tabel) {
        include('connect.php');       
        $resulttime='TGL';
        //$case_colom = 'branch';
        $case=array('TCH_BLOCK');
        $case_alias=$case;    
        $query = "SELECT Date AS TGL, `TCH_BLOCK_(%)` AS TCH_BLOCK
                  FROM swap_sumatera.Region2GHour";
        $sql  = mysql_query($query);   

        //echo $query;
        $result = array();
        $myVar = array();
        $j = 0;
        
        while ($row = mysql_fetch_assoc($sql)) {

        //$result[] = $row;
            if($j == 0){
                $myVar1['name'] = "'".'TGL'."'"; //declare tanggal
                $i=0;        
                foreach ($case as $name){
                   $myVar[$i]['name']=$name;
                   $i++; 
                }
            $j++;
            }
            
            $myVar1['data'][] = $row['TGL'];
            $i=0;
            foreach ($case_alias as $name){
               if ($row[$name] == 0){
                   $myVar[$i]['data'][]=null;
               } else {
                   $myVar[$i]['data'][]=$row[$name]*1;
               }             
               //$myVar[$i]['data'][]=$row[$name]*1; //*1 to float value
               $i++; 
            }
        }

        array_push($result,$myVar1);
        $i=0;
        foreach ($case as $name){           
           array_push($result,$myVar[$i]);
           $i++; 
        }

        echo json_encode($result);
    }
    public function CellQuery3G($case=array(),$alias=array(),$rnc,$cellid,$start_date,$end_date) {
        include 'dbConnect.php';    
        
        $resulttime='TGL';
        
	$param_ = implode(',', $case);
        
        $query = "SELECT $resulttime,$param_ FROM dbdump.d3g_kpi
                  WHERE RNC = '$rnc' AND CI = '$cellid' AND TGL BETWEEN '$start_date' AND '$end_date'";
        $sql	= mysql_query($query);   

        //echo $query;
        $result = array();
        $myVar = array();
        $j = 0;
        
        while ($row = mysql_fetch_assoc($sql)) {

        //$result[] = $row;
            if($j == 0){
                $myVar1['name'] = "'".$resulttime."'"; //declare tanggal
                $i=0;        
                foreach ($alias as $name){
                   $myVar[$i]['name']=$name;
                   $i++; 
                }
            $j++;
            }
            
            $myVar1['data'][] = $row[$resulttime];
            $i=0;
            foreach ($alias as $name){           
               if ($row[$name] == 0){
                   $myVar[$i]['data'][]=null;
               } else {
                   $myVar[$i]['data'][]=$row[$name]*1;
               }              
                //$myVar[$i]['data'][]=$row[$name]*1; //*1 to float value
               $i++; 
            }

        }

        array_push($result,$myVar1);
        $i=0;
        foreach ($case as $name){           
           array_push($result,$myVar[$i]);
           $i++; 
        }        
        
       
        echo json_encode($result);
        mysql_close($con);        
    }
    
    public function RNCCI($cellname) {
        include 'dbConnect.php';
        $query = "SELECT RNC,CELLID FROM dbperformance.conf_dapotucell
                  WHERE CELLNAME='$cellname' AND TGL_UPDATE>=DATE( DATE_SUB( NOW() , INTERVAL 7 DAY ) )";
        $q = mysql_query($query);
        while($row = mysql_fetch_assoc($q)) {
                $rnc[]=$row['RNC'];
                $cellid[]=$row['CELLID'];
        } 
        return array_merge($rnc,$cellid);
        
    }
    
}


if(isset($_GET['toID'])){
    $content=$_GET['toID'];
    //$content = 'charthosr';
    if ($content == 'charthosr') { 
            $colom = 'TCH_BLOCK_(%)';
			$tabel = '';
            $MyClass = new My2G;
            $MyClass->query2G($colom,$tabel);
    } 
    if ($content == 'acc_cs') { 
            $colom = '((CSSR_VOICE_NUM+CSSR_VIDEO_NUM)/(CSSR_VOICE_DEN+CSSR_VIDEO_DEN))*100';
            $MyClass = new My3G;
            $MyClass->RNCQuery3G($colom);          
    }     
    if ($content == 'acc_hs') { 
            $colom = '((CSSR_HSDPA_NUM)/(CSSR_HSDPA_DEN))*100';
            $MyClass = new My3G;
            $MyClass->RNCQuery3G($colom);          
    }   
    if ($content == 'acc_hsupa') { 
            $colom = '((CSSR_HSUPA_NUM)/(CSSR_HSUPA_DEN))*100';
            $MyClass = new My3G;
            $MyClass->RNCQuery3G($colom);          
    }  
    if ($content == 'ret_ps') { 
            $colom = 'CCSR_PS_EFD';
            $MyClass = new My3G;
            $MyClass->RNCQuery3G($colom);
    } 
    if ($content == 'ret_cs') { 
            $colom = '((CCSR_CS_Num_Tinem3)/(CCSR_CS_Denum_Tinem3))*100';
            $MyClass = new My3G;
            $MyClass->RNCQuery3G($colom);          
    }     
    if ($content == 'ret_hs') { 
            $colom = '100-((CCSR_HSDPA_EFD_NUM)/(CCSR_HSDPA_EFD_DEN))*100';
            $MyClass = new My3G;
            $MyClass->RNCQuery3G($colom);          
    }   
    if ($content == 'ret_hsupa') { 
            $colom = 'CCSR_HSUPA';
            $MyClass = new My3G;
            $MyClass->RNCQuery3G($colom);          
    } 
    if ($content == 'sho') { 
            $colom = 'SHO_SR';
            $MyClass = new My3G;
            $MyClass->RNCQuery3G($colom);          
    }
    if ($content == 'ifho') { 
            $colom = 'IFHO_SR';
            $MyClass = new My3G;
            $MyClass->RNCQuery3G($colom);          
    }
    if ($content == 'isho') { 
            $colom = 'ISHO_SR';
            $MyClass = new My3G;
            $MyClass->RNCQuery3G($colom);          
    }
    if ($content == 'rnc_trf') { 
            $colom = 'TRAFFIC_VIDEO+TRAFFIC_VOICE';
            $MyClass = new My3G;
            $MyClass->RNCQuery3G($colom);          
    }     
    if ($content == 'rnc_pay') { 
            $colom = '(PS_DL_PAYLOAD_Mbit+PS_UL_PAYLOAD_Mbit+HSDPA_PAYLOAD_Mbit+HSUPA_PAYLOAD_Mbit)*1000000';
            $MyClass = new My3G;
            $MyClass->RNCQuery3G($colom);          
    }  
    if ($content == 'rnc_thr') { 
            $colom = 'PS_DL_THR+PS_UL_THR+HSDPA_THR+HSUPA_THR';
            $MyClass = new My3G;
            $MyClass->RNCQuery3G($colom);          
    }	
    if ($content == 'rnc_cellavai') { 
            $colom = 'CELL_AVAILABLE';
            $MyClass = new My3G;
            $MyClass->RNCQuery3G($colom);          
    }
	if ($content == 'ci_3g') { 
            $colom = 'COUNT_CI';
            $MyClass = new My3G;
            $MyClass->RNCQuery3G($colom);          
    }	
}


<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
 
date_default_timezone_set('Asia/Jakarta');
 


class My3G {
    
    public function SumCase($colom,$case_colom,$case=array(),$case_alias=array()){
        $count=count($case)-1;
        $array = array();
        for ($i=0;$i<=$count;$i++)
        {
            $array[] = "SUM(CASE WHEN $case_colom = '$case[$i]' THEN $colom END) $case_alias[$i]";
        }
        return implode(',',$array);
    }
    
    public function RNCQuery3G($colom) {
        include 'dbConnect.php';        
        $resulttime='RESULTTIME';
        $case_colom = 'RNC';
        $case=array('RNC_SoloBaru3','RNC_Semarang4','RNC_Kentungan','RNC_KotaBaru','RNC_Margorejo','RNC_Pekalongan','RNC_Purwonegoro','RNC_Semarang','RNC_Semarang2','RNC_SoloBaru','RNC_Yogyakarta','RNC_Wirosari','RNC_KotaBaru2','RNC_SoloBaru2','RNC_Semarang3', 'RNC_Maos','RNC_SumurPanggang','RNC_Solo2','RNC_Purwokerto2','RNC_KotaBaru3','RNC_Purwonegoro2','RNC_GombelKudus');
        $case_alias=$case;		
        $query = "SELECT $resulttime," . $this->SumCase($colom,$case_colom,$case,$case_alias)
                . " FROM dbdump.h3g_kpi_rnc WHERE $resulttime >= DATE_SUB(NOW(), INTERVAL 194 HOUR) GROUP BY $resulttime";
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
                foreach ($case as $name){
                   $myVar[$i]['name']=$name;
                   $i++; 
                }
            $j++;
            }
            
            $myVar1['data'][] = $row[$resulttime];
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
        mysql_close($con);        
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
    //$content = 'acc_ps';
    if ($content == 'charthosr') { 
            $colom = 'CSSR_PS';
            $MyClass = new My3G;
            $MyClass->RNCQuery3G($colom);
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


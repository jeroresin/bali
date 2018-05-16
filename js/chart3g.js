<script type="text/javascript">  
  
  var chart; 

  $(document).ready(function() {  
 
   chart = new Highcharts.Chart({  
    chart: {  
     renderTo: 'cssr',  
     zoomType: 'xy',

    },  
    title: {  
     text: 'Pekanbaru 3G KPI',
	 style: {
	 font: 'normal 14px Verdana, sans-serif',
     color : '#FA5858'
	 }
    },  
    
    xAxis:[{
	 
     categories: [<?php echo $date; ?>],
 labels: {
 
			rotation: -0
        }
    }],

    yAxis: [{ // Primary yAxis  

	 labels: {  
      formatter: function() {  
       return this.value +' % ';  
      },
      style: {  
       color: '#696969'  
      }  
     },  
	 max: 100,
     title: {
      text: ' '
      
     }
    }
	],  
    tooltip: {  
    shared: true,
        useHTML: true,
        headerFormat: 'Date : {point.key}<table>',
        pointFormat: '<tr><td style="color: {series.color}">{series.name}:  </td>' +' '+
        '<td style="text-align: right"><b> {point.y} %</b></td></tr>',
        footerFormat: '</table>',
        valueDecimals: 2
    },  
    legend: {  
     enabled: true
    },
 plotOptions: {
            column: {
                stacking: 'percent'
            }
        },
    series: [
	
	{

	name: 'CCSR CS',  
     color: '#04B4AE',  
     type: 'spline',  
     data: [<?php echo $cssr_cs;?>],
marker: {
            enabled: true,
     
            radius: 3
        },
	 }
	]  
   });  
    
    
  });  
    
          </script>
		  
		  <script type="text/javascript">  
  
  var chart; 

  $(document).ready(function() {  
 
   chart = new Highcharts.Chart({  
    chart: {  
     renderTo: 'cssrps',  
     zoomType: 'xy',

    },  
    title: {  
     text: 'Pekanbaru 3G KPI',
	 style: {
	 font: 'normal 14px Verdana, sans-serif',
     color : '#FA5858'
	 }
    },  
    
    xAxis:[{
	 
     categories: [<?php echo $date; ?>],
 labels: {
 
			rotation: -0
        }
    }],

    yAxis: [{ // Primary yAxis  

	 labels: {  
      formatter: function() {  
       return this.value +' % ';  
      },
      style: {  
       color: '#696969'  
      }  
     },  
	 max: 100,
     title: {
      text: ' '
      
     }
    }
	],  
    tooltip: {  
    shared: true,
        useHTML: true,
        headerFormat: 'Date : {point.key}<table>',
        pointFormat: '<tr><td style="color: {series.color}">{series.name}:  </td>' +' '+
        '<td style="text-align: right"><b> {point.y} %</b></td></tr>',
        footerFormat: '</table>',
        valueDecimals: 2
    },  
    legend: {  
     enabled: true
    },
 plotOptions: {
            column: {
                stacking: 'percent'
            }
        },
    series: [
	
	{

	name: 'CCSR PS',  
     color: '#BF00FF',  
     type: 'spline',  
     data: [<?php echo $cssr_ps;?>],
marker: {
            enabled: true,
     
            radius: 3
        },
	 }
	]  
   });  
    
    
  });  
    
          </script>
		<script type="text/javascript">  
  
  var chart; 

  $(document).ready(function() {  
 
   chart = new Highcharts.Chart({  
    chart: {  
     renderTo: 'cssrhsdpa',  
     zoomType: 'xy',

    },  
    title: {  
     text: 'Pekanbaru 3G KPI',
	 style: {
	 font: 'normal 14px Verdana, sans-serif',
     color : '#FA5858'
	 }
    },  
    
    xAxis:[{
	 
     categories: [<?php echo $date; ?>],
 labels: {
 
			rotation: -0
        }
    }],

    yAxis: [{ // Primary yAxis  

	 labels: {  
      formatter: function() {  
       return this.value +' % ';  
      },
      style: {  
       color: '#696969'  
      }  
     },  
	 max: 100,
     title: {
      text: ' '
      
     }
    }
	],  
    tooltip: {  
    shared: true,
        useHTML: true,
        headerFormat: 'Date : {point.key}<table>',
        pointFormat: '<tr><td style="color: {series.color}">{series.name}:  </td>' +' '+
        '<td style="text-align: right"><b> {point.y} %</b></td></tr>',
        footerFormat: '</table>',
        valueDecimals: 2
    },  
    legend: {  
     enabled: true
    },
 plotOptions: {
            column: {
                stacking: 'percent'
            }
        },
    series: [
	
	{

	name: 'CCSR HSDPA',  
     color: '#FE642E',  
     type: 'spline',  
     data: [<?php echo $cssr_hsdpa;?>],
marker: {
            enabled: true,
     
            radius: 3
        },
	 }
	]  
   });  
    
    
  });  
    
          </script>  
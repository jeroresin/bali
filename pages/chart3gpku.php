<script type="text/javascript">  
  var chart; 
  function create_line_chart(data,index)
  {
  	chart = new Highcharts.Chart({  
		chart: {  renderTo: data.data[index].container,  zoomType: 'xy' },  // param container
		
		title: {  
			text: data.chart_title,
			style: {
				font: 'normal 14px Verdana, sans-serif',
				fontWeight: 'bold',
				color : '#2E4053',
			}
		},     
		exporting: {
        buttons: {
            contextButtons: {
                enabled: false,
                menuItems: null
            }
        },
        enabled: false
    }, 
		xAxis:[{
		 categories: data.date, // data date
		 labels: {
                style: {
   
                    fontSize:'9px'
                }
            }
		}],
		yAxis: [{ // Primary yAxis  
		 labels: {
			formatter: function() { return this.value +' % ';  },
			style: {  color: '#696969'  }  
		 },  
		 max: 100,
		 title: {text:null}
		}],  
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
			line: {lineWidth: 2.7}
		},
		series: [{
			zoneAxis: "x",
			name: data.data[index].name,
			/*color: data.data[index].color,*/
			type: 'line',  
			data: data.data[index].data,
			zones: data.zones,
			marker: {enabled: true,radius: 1},
		 }]
	});
  }
  $(document).ready(function() {   
     $.ajax({url : "pages/ajax/3gregdayqry2.php"})
	 .done(function(res){
			create_line_chart(res,0);		
			create_line_chart(res,1);		
			create_line_chart(res,2);
			create_line_chart(res,3);		
			create_line_chart(res,4);		
			create_line_chart(res,5);
			create_line_chart(res,6);		
			create_line_chart(res,7);		
			create_line_chart(res,8);
			create_line_chart(res,9);		
			create_line_chart(res,10);		
	 });
  });  
          </script>  
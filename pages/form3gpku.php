
	<div class="col-md-12">
		<div class="row">
			<form id="filter-form" class="form-inline" method="POST"> 
				<?php
				set_time_limit(500);
				$regsql = "select distinct Cluster from Cluster3GDay"; 
				$result = mysql_query($regsql); 
				$where = "";
				if(isset($id))
					$where = "where cluster='".$id."'";
				$regsql1 = "select distinct SITEID from Site3GDayClust ".$where;
				$result2 = mysql_query($regsql1);
				?>
				<?php include('pages/date_picker.php'); ?>
				<div class="form-group">
					<label>CLUSTER</label>
				<select name='region' class='form-control selectWidth load-cluster'>
					<option value="">CLUSTER</option>
					<?php while ($row = mysql_fetch_array($result)) { echo "<option value='" . $row['Cluster'] ."'>" . $row['Cluster'] ."</option>"; } ?>
				</select>
				</div>
				<div class="form-group">
					<label>SITE_ID</label>
				<select name="rnc" class='form-control' id="cluster-container">
					<option value="" selected="selected">SITE_ID</option>
					<?php while ($row = mysql_fetch_array($result2)) { echo "<option value='" . $row['SITEID'] ."'>" . $row['SITEID'] ."</option>"; }?>
				</select>
				</div>
				<div class="form-group">
				<input class="form-control btn btn-primary" name="submit" type="submit" value="SUBMIT">
				</div>
			</form>
		</div>
	</div>
<script>
$("#cluster-container").change(function(){
	$("#filter-form").submit();	
	
});
$(".load-cluster").change(function(){
	var region = $(this).val();
	$.ajax({
		url: "pages/ajax/load_cluster_from_region2.php",
		method: "POST",
		data: { region : region },
		dataType: "html"
	}).done(function(res){
		$("#cluster-container").empty().html(res);
		$("#filter-form").submit();		
	});
});
$("#filter-form").submit(function(e){
	e.preventDefault();
	var data = new FormData($(this)[0]);
	var active_form = $(this);
	$.ajax({
		url: "pages/ajax/3gregdayqry2.php",
		type: 'POST',
		data: data,
		async: false,
		success: function (res) {	
					
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

		},
		cache: false,
		contentType: false,
		processData: false
	});
});
</script>
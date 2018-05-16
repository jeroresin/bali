
	<div class="col-md-12">
		<div class="row">
			<form id="filter-form" class="form-inline" method="POST"> 
				<?php
				$regsql = "select distinct Region from Cluster3GDay"; 
				$result = mysql_query($regsql); 
				$regsql1 = "select distinct Cluster from Cluster3GDay where Region ='$id'"; 
				$result2 = mysql_query($regsql1);
				?>
				<?php include('pages/date_picker.php'); ?>
				<div class="form-group">
					<label>REGION</label>
				<select name='region' class='form-control selectWidth load-cluster'>
					<option value="">REGION</option>
					<?php while ($row = mysql_fetch_array($result)) { echo "<option value='" . $row['Region'] ."'>" . $row['Region'] ."</option>"; } ?>
				</select>
				</div>
				<div class="form-group">
					<label>CLUSTER</label>
				<select name="rnc" class='form-control' id="cluster-container">
					<option value="" selected="selected">CLUSTER</option>
					<?php while ($row = mysql_fetch_array($result2)) { echo "<option value='" . $row['Cluster'] ."'>" . $row['Cluster'] ."</option>"; }?>
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
	//naaah ini udah ada... tinggal ditambahin script ajax kyak load-cluster dibawah ini
});
$(".load-cluster").change(function(){
	var region = $(this).val();
	$.ajax({
		url: "pages/ajax/load_cluster_from_region.php",
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
		url: "pages/ajax/3gregdayqry.php",
		type: 'POST',
		data: data,
		async: false,
		success: function (res) {	
			// ini saat klik submit atau onchange region/cluster		
			create_line_chart(res,0);		
			create_line_chart(res,1);		
			create_line_chart(res,2);
		},
		cache: false,
		contentType: false,
		processData: false
	});
});
</script>
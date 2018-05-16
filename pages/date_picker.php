<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
<script>
$( function() {
$( "#datepicker" ).daterangepicker();
} );
</script>
<div class="form-group">
<label>DATE</label>
<select name="filter_by_date" id="filter_by_date" class="form-control">
	<option value="0">CHANGE DATE</option>
	<option value="1">Filter By Date</option>
</select>
<input type="text" id="datepicker" class="form-control" placeholder="input the date" name="daterange" style="display:none"/>
</div>
<script>
$("#filter_by_date").change(function(){
	if($(this).val() == '1'){
		$("#datepicker").show();
	}else{
		$("#datepicker").hide();
	}
});
</script>
<?php
	#Include the connect.php file
	include('connect2.php');
	#Connect to the database
	//connection String
	$connect = mysql_connect($hostname, $username, $password)
	or die('Could not connect: ' . mysql_error());
	//Select The database
	$bool = mysql_select_db($database, $connect);
	if ($bool === False){
	   print "can't find $database";
	}
	?>
<table width=100% Align="center" bgcolor="#A4A4A4">
		<tr>
			<td width=20%><form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
				<b>Level :</b>
				<select  name="optaggr" id="ddl1" onchange="configureDropDownLists(this,document.getElementById('ddl2','ddl3','ddl4'))" >
						<option selected="selected">oke</option>
						<option>oke bos</option>
						
				</select>	
			</td>
			<td width=20%><b>Start Date :</b>
					  				
			</td>
			<td width=20%><b>End Date :</b>
						
			</td>
			<td width=25%><b>Object:</b>
			
			<select id="ddl2">
				
						<?php
						$res = mysql_query("SELECT Distinct SITEID FROM h3g_sitedaily ORDER BY SITEID",$connect);
						while($row=mysql_fetch_array($res)){
						echo "<option value='".$row['0']."'>".$row['0']."</option>";
					}?>
				
				
			</select>
			</td>
			<td width=20%><input type="submit" name="submit" value="Submit"></td>
			</form>
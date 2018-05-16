<?php
echo "<html>";
echo "<body>";
for($i=0; $i<5;$i++){
    echo "<input name='C[]' value='$Texting[$i]' " . 
         "style='background-color:#D0A9F5;'></input>";

}
echo "</body>";
echo "</html>";
echo '<input type="submit" value="Save The Table" name="G"></input>'
?>
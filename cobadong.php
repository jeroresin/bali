<label for='formCountries[]'>Select the countries that you have visited:</label><br>
<select multiple="multiple" name="formCountries[]">
    <option value="US">United States</option>
    <option value="UK">United Kingdom</option>
    <option value="France">France</option>
    <option value="Mexico">Mexico</option>
    <option value="Russia">Russia</option>
    <option value="Japan">Japan</option>
</select>
</td>
			<td width=20%><input type="submit" name="submit" value="Submit"></td>
<?php

if(isset($_POST['formSubmit'])) 
{
  $aCountries = $_POST['formCountries'];
  
  if(!isset($aCountries)) 
  {
    echo("<p>You didn't select any countries!</p>\n");
  } 
  else 
  {
    $nCountries = count($aCountries);
    
    echo("<p>You selected $nCountries countries: ");
    for($i=0; $i < $nCountries; $i++)
    {
      echo($aCountries[$i] . " ");
    }
    echo("</p>");
  }
}

?>

<?php

if(isset($_POST['formSubmit'])) 
{
  $varCountry = $_POST['formCountry'];
  $errorMessage = "";
  
  if(empty($varCountry)) 
  {
    $errorMessage = "<li>You forgot to select a country!</li>";
  }
  
  if($errorMessage != "") 
  {
    echo("<p>There was an error with your form:</p>\n");
    echo("<ul>" . $errorMessage . "</ul>\n");
  } 
  else 
  {
    // note that both methods can't be demonstrated at the same time
    // comment out the method you don't want to demonstrate

    // method 1: switch
    $redir = "US.html";
    switch($varCountry)
    {
      case "US": $redir = "US.html"; break;
      case "UK": $redir = "UK.html"; break;
      case "France": $redir = "France.html"; break;
      case "Mexico": $redir = "Mexico.html"; break;
      case "Russia": $redir = "Russia.html"; break;
      case "Japan": $redir = "Japan.html"; break;
      default: echo("Error!"); exit(); break;
    }
    echo " redirecting to: $redir ";
    
    // header("Location: $redir");
    // end method 1
    
    // method 2: dynamic redirect
    //header("Location: " . $varCountry . ".html");
    // end method 2

    exit();
  }
}
?>
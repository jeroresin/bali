<?php
   // define database related variables
   $database = 'db_web';
   $host = '31.220.57.21';
   $user = 'ibnu';
   $pass = 'pascal';

   // try to conncet to database
   $dbh = new PDO("mysql:dbname={$database};host={$host};port={3306}", $user, $pass);

   if(!$dbh){

      echo "unable to connect to database";
   }
   
?>
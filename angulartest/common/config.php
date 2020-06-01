<?php 

   $host     = "localhost"; 
   $database = "angulartest";
   $user     = "root";
   $password = "secret";
   
   $db  = new Db($host,$user,$password,$database);
   
   $GLOBALS['DB'] = $db;

?>

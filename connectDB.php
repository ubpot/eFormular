<?php
// hier bitte die zugehörigen Zugangsdaten eintragen
$db = mysqli_connect("localhost", "root", "DEladT");
  if( !$db ) {
  	die("Error connecting to the Server");
    exit;
  }
  $result = mysqli_select_db($db, "eFormular");
  if( !$result ) {
  	die("Error selecting Database");
    exit;
  }


?>


<?php
// hier bitte die zugehörigen Zugangsdaten eintragen
$db = mysqli_connect("localhost", "eformular", "");
  if( !$db ) {
  	die("Error connecting to the Server");
    exit;
  }
  $result = mysqli_select_db($db, "eformular");
  if( !$result ) {
  	die("Error selecting Database");
    exit;
  }


?>


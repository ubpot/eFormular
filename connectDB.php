<?
// hier bitte die zugehörigen Zugangsdaten eintragen
$db = mysql_connect("localhost", "user", "pass");
  if( !$db ) {
  	die("Error connecting to the Server");
    exit;
  }
  $result = mysql_select_db("eFormular", $db);
  if( !$result ) {
  	die("Error selecting Database");
    exit;
  }
  
  
?>

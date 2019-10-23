<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" );
header("Cache-Control: no-cache, must-revalidate" );
header("Pragma: no-cache" );
header("Content-Type: text/xml; charset=UTF-8");

require('../connectDB.php');


$trayid = $_POST['trayid'];
$name= $_POST['name'];
$editor= $_POST['editor'];

if ($trayid != "") {
	$sql = " UPDATE Tray SET name='".$name."', editor='".$editor."' where id=".$trayid;
	mysqli_query($db,$sql);
	$newid = $trayid;
} else {
	$sql = " INSERT INTO Tray (name,editor) VALUES ('".$name."','".$editor."' )";
	mysqli_query($db,$sql);
	$newid = mysqli_insert_id($db);
}



if (mysqli_affected_rows($db)!=1) {
	echo "Bei Speichern ist ein Fehler aufgetreten: \n";
	echo "mysqli_affected_rows()".mysqli_affected_rows($db);
	echo mysqli_error($db);
	die();
}

echo $newid;


?>
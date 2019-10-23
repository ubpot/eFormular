<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" );
header("Cache-Control: no-cache, must-revalidate" );
header("Pragma: no-cache" );
header("Content-Type: text/xml; charset=UTF-8");

require('../connectDB.php');

$sstringid= $_GET['sstringid'];
$title= $_GET['title'];
$sstring= $_GET['sstring'];
$editor= $_GET['editor'];
$newid = $sstringid;

if ($sstringid != "") {
	$sql = " UPDATE Searchstring SET title='".$title."' , sstring='".$sstring."' , editor='".$editor."' where id=".$sstringid;
	mysqli_query($db,$sql);
} else {
	$sql = " INSERT INTO Searchstring (sstring,title,editor) VALUES ('".$sstring."' , '".$title."', '".$editor."')";
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
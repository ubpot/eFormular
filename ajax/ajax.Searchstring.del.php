<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" );
header("Cache-Control: no-cache, must-revalidate" );
header("Pragma: no-cache" );
header("Content-Type: text/xml; charset=UTF-8");

require('../connectDB.php');


$sstringid = $_GET['sstringid'];


if ($sstringid != "") {
	$sql = " DELETE FROM Searchstring where id=".$sstringid;
	mysqli_query($db,$sql);
	if (mysqli_affected_rows($db)== 0) {
		echo "Bei Löschen ist ein Fehler aufgetreten: \n";
		echo "mysqli_affected_rows()".mysqli_affected_rows($db);
		echo mysqli_error($db);
		die();
	}
	$newid = "1";
} else {
	$newid = "Error: keine ID";
}

echo $newid;


?>
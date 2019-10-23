<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" );
header("Cache-Control: no-cache, must-revalidate" );
header("Pragma: no-cache" );
header("Content-Type: text/xml; charset=UTF-8");

require('../connectDB.php');


$title= $_GET['foldertitle'];
$id= (isset ($_GET['id'])) ? $_GET['id'] : null;

if ($id) {
	$sql = " UPDATE Folder SET title ='".$title."'  "
			." WHERE id=".$id;
	mysqli_query($db,$sql);
	if (mysqli_affected_rows($db)!=1) {
		echo "Bei Umbenennen des Ordners ist ein Fehler aufgetreten: \n";
		echo $sql."\n";
		echo "mysqli_affected_rows()".mysqli_affected_rows($db)."\n";
		echo mysqli_error($db);
		die();
	}
	$newid = $id;
} else {

	$sql = " INSERT INTO Folder (title) "
			." VALUES ('".$title."')";
	mysqli_query($db,$sql);
	if (mysqli_affected_rows($db)!=1) {
		echo "Bei Anlegen eines neuen Ordners ist ein Fehler aufgetreten: \n";
		echo $sql."\n";
		echo "mysqli_affected_rows()".mysqli_affected_rows($db)."\n";
		echo mysqli_error($db);
		die();
	}
	$newid = mysqli_insert_id($db);
}


echo $newid;


?>
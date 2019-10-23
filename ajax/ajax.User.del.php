<?php
require('../connectDB.php');
require('ajax.lib.php');

sendAjaxHeader();

$userid = $_GET['userid'];


if ($userid != "") {

	$sql = " DELETE FROM Watchlist where id_User=".$userid;
	mysqli_query($db,$sql);
	if (mysqli_error($db)) {
		echo "Bei Löschen der Merkliste ist ein Fehler aufgetreten: \n";
		echo "mysqli_affected_rows()".mysqli_affected_rows($db);
		echo mysqli_error($db);
		die();
	}
	$sql = " UPDATE Formdata SET block_id_User = null where block_id_User=".$userid;
	mysqli_query($db,$sql);
	if (mysqli_error($db)) {
		echo "Bei Löschen der Referenzen ist ein Fehler aufgetreten: \n";
		echo "mysqli_affected_rows()".mysqli_affected_rows($db);
		echo mysqli_error($db);
		die();
	}
	$sql = " DELETE FROM User where id=".$userid;
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
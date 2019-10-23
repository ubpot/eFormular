<?php

require('../connectDB.php');
require('ajax.lib.php');

sendAjaxHeader();

$formdataid = (isset ($_GET['formdataid']) ) ? $_GET['formdataid'] : array();

$Userid= (isset ($_GET['userid']) ) ? $_GET['userid'] : "";

for ($i = 0; $i < count($formdataid); $i++) {

	$sql = " INSERT INTO Watchlist (id_User,id_FormData) "
			." VALUES (".$Userid." , ".$_GET['formdataid'][$i].")";

	mysqli_query($db,$sql);
	if (mysqli_affected_rows($db)!=1) {
		echo "Bei Speichern der Watchlist ist ein Fehler aufgetreten: \n";
		echo $sql."\n";
		echo "mysqli_affected_rows()".mysqli_affected_rows($db)."\n";
		echo mysqli_error($db);

	}
};



?>
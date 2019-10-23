<?php

require('../connectDB.php');
require('ajax.lib.php');

sendAjaxHeader();

$formdataid = (isset ($_GET['formdataid']) ) ? $_GET['formdataid'] : array();

$Userid= (isset ($_GET['userid']) ) ? $_GET['userid'] : "";

for ($i = 0; $i < count($formdataid); $i++) {

	$sql = " DELETE FROM Watchlist  "
			." WHERE id_User = ".$Userid." AND id_FormData = ".$formdataid[$i];
	mysqli_query($db,$sql);
	if (mysqli_affected_rows()!=1) {
		echo "Bei Löschen der Watchlist ist ein Fehler aufgetreten: \n";
		echo $sql."\n";
		echo "mysqli_affected_rows()".mysqli_affected_rows()."\n";
		echo mysqli_error();

	}
};



?>
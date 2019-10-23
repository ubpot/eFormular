<?php

require('../connectDB.php');
require('ajax.lib.php');

sendAjaxHeader();


function delForm($Formdataid){
    global $db;

	$sql = " Select id_Folder from Formdata  where id=".$Formdataid ;
	//echo $sql;
	$result = mysqli_query($db,$sql);
	echo mysqli_error($db);
	$row = mysqli_fetch_assoc($result);
	$Folderid = $row['id_Folder'];

	while ($Formdataid != "") {
		$sql = " Select prevVersion,id_Folder "
				." from Formdata "
				." where id=".$Formdataid ;
		//echo $sql;
		$result = mysqli_query($db,$sql);
		echo mysqli_error($db);
		$row = mysqli_fetch_assoc($result);
		$previd=$row['prevVersion'];

		$sql = " DELETE FROM Formvalues where id_Formdata=".$Formdataid;
		mysqli_query($db,$sql);
		echo mysqli_error($db);

		$sql = " DELETE FROM Watchlist where id_FormData=".$Formdataid;
		mysqli_query($db,$sql);
		echo mysqli_error($db);

		$sql = " DELETE FROM Formdata where id=".$Formdataid;
		mysqli_query($db,$sql);
		echo mysqli_error($db);

		$Formdataid = $previd;
	}

	if ($Folderid) {
		$sql = " Select count(*) as Count from Folder,Formdata  where Folder.id=Formdata.id_Folder AND Folder.id=".$Folderid;
		//echo $sql;
		$result = mysqli_query($db,$sql);
		echo mysqli_error($db);
		$row = mysqli_fetch_assoc($result);

		if ($row['Count'] == 0) {
			$sql = " DELETE FROM Folder where id=".$Folderid;
			mysqli_query($db,$sql);
			echo mysqli_error($db);
		}
	}
	return $Folderid ;
}

$formdataid = $_GET['formdataid'];

if ($formdataid == "") {
	echo "Fehlender Parameter.";
	die();
}

$Folderid = delForm($formdataid);


echo $Folderid;
?>
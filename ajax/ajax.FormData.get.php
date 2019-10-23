<?php

require('../connectDB.php');
require('myJSONlib.php');
require('ajax.lib.php');

sendAjaxHeader();

$dataid = $_GET['dataid'];
$editorid= $_GET['editorid'];
if (! $dataid) {
	die("{}");
}


$sql = " Select Formdata.title as title,version,prevVersion,nextVersion,json,Formdata.editor as editor "
		." ,hinttext,id_Tray,status,id_Folder,block_begin, block_id_User, User.name as block_User "
		." from Formdata LEFT JOIN User ON (Formdata.block_id_User = User.id) where  Formdata.id=".$dataid;

$result = mysqli_query($db,$sql);
echo mysqli_error($db);

$row = mysqli_fetch_assoc($result);

if ($row['block_begin']=="" && $row['nextVersion']=="") {
	$sql = "UPDATE Formdata SET block_begin=now(),block_id_User = ".$editorid." where Formdata.id=".$dataid;
	mysqli_query($db,$sql);
	if (mysqli_affected_rows($db)!=1 )  {
		echo "Bei Blockieren des Formulars ist ein Fehler aufgetreten: \n";
		echo "mysqli_affected_rows()".mysqli_affected_rows($db);
		echo mysqli_error($db);
		echo $sql;
	}
}
//print_r ($row);

$string = getRecord($row);

echo $string;
echo mysqli_error($db);

?>
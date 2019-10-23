<?php
session_start();


require('../connectDB.php');
require('ajax.lib.php');
require('myJSONlib.php');

sendAjaxHeader();

$sql = " Select id_FormData as formdataid,Formdata.title as title,id_Form as formid, Folder.title as foldertitle "
		." from Watchlist,(Formdata left JOIN Folder on(Formdata.id_Folder = Folder.id)) "
		." where Watchlist.id_FormData = Formdata.id AND  id_User=".$_SESSION['userid'];
//echo $sql;
$result = mysqli_query($db,$sql);


$json=result2Json($result);

//print_r ($row);

echo $json;
echo mysqli_error($db);

?>
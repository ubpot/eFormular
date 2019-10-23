<?php
/*
*	Diese Datei ist nur noch für die Gesamtliste und Blocklist
* 	da solle aber durchaus entfernt werden und in ajax.search übergehen
*
*
*/
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" );
header("Cache-Control: no-cache, must-revalidate" );
header("Pragma: no-cache" );
header("Content-Type: text/xml; charset=UTF-8");

require('../connectDB.php');
require('myJSONlib.php');


if ($_GET['blockList']) {
	$where_block=" AND block_begin is not null ";
}

if ($_GET['onlyoutstanding'] == 1) {
	$where_block.= " AND status='unerledigt'";
}

$order_block = " status ";

if ($_GET['sort'] == 'name') {
	$order_block = " Folder.title,Formdata.title DESC";
}

if ($_GET['sort'] == 'date') {
	$order_block = " timestamp DESC";
}

if ($_GET['sort'] == 'dateasc') {
	$order_block = " date ";
}


$sql = " Select Formdata.id as formdataid, id_Form as formid , Formdata.title as title, Formular.title as Formulartyptitle,status, Tray.name as ablage, Folder.title as foldertitle "
		." , block_begin, User.name as blocker, hinttext , date_format(Formdata.timestamp,'%Y-%m-%d') as date "
		." from (Formdata LEFT JOIN Tray ON (Formdata.id_Tray=Tray.id)) LEFT JOIN Folder ON (Formdata.id_Folder=Folder.id) LEFT JOIN User ON (User.id = block_id_User),Formular "
		." where Formdata.id_Form =  Formular.id  AND Formdata.nextVersion is NULL ".$where_block."  "
		." ORDER BY ".$order_block;
//echo $sql;
$result = mysqli_query($db,$sql);

$json=result2Json($result);

//print_r ($row);

echo $json;
echo mysqli_error($db);

?>
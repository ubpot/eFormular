<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" );
header("Cache-Control: no-cache, must-revalidate" );
header("Pragma: no-cache" );
header("Content-Type: text/xml; charset=iso-8859-1");

require('../connectDB.php');


$folderid = $_GET['folderid'];

if ($folderid == "") {
	echo "Fehlender Parameter.";
	die();
}



$sql = " DELETE Formdata,Formvalues FROM  Formdata,Formvalues where Formdata.id = Formvalues.id_Formdata AND id_Folder=".$folderid;
mysqli_query($db,$sql);
echo mysqli_error($db);

$sql = " DELETE FROM Folder where id=".$folderid;
mysqli_query($db,$sql);
echo mysqli_error($db);


//echo $folderid;
?>
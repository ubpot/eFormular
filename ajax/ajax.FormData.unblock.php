<? 
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT" ); 
header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" ); 
header("Cache-Control: no-cache, must-revalidate" ); 
header("Pragma: no-cache" );
header("Content-Type: text/xml; charset=iso-8859-1");

require('../connectDB.php');


$formdataid = $_GET['formdataid']; 

if ($formdataid == "") {
	echo "Fehlender Parameter.";
	die();
}

$sql = " UPDATE Formdata SET block_id_User = null, block_begin=null where id=".$formdataid;
mysql_query($sql);
if (mysql_affected_rows()!=1 )  {
	echo "Bei Deblockieren des Formulars ist ein Fehler aufgetreten: \n";
	echo "mysql_affected_rows()".mysql_affected_rows();
	echo mysql_error();
	echo $sql;
}




?>
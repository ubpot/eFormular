<? 
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT" ); 
header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" ); 
header("Cache-Control: no-cache, must-revalidate" ); 
header("Pragma: no-cache" );
header("Content-Type: text/xml; charset=UTF-8");

require('../connectDB.php');


$sstringid = $_GET['sstringid'];


if ($sstringid != "") {
	$sql = " DELETE FROM Searchstring where id=".$sstringid;
	mysql_query($sql);
	if (mysql_affected_rows()== 0) {
		echo "Bei Löschen ist ein Fehler aufgetreten: \n";
		echo "mysql_affected_rows()".mysql_affected_rows();
		echo mysql_error();
		die();
	}
	$newid = "1";
} else {
	$newid = "Error: keine ID";
}

echo $newid;


?>
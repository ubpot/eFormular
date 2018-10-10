<? 
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT" ); 
header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" ); 
header("Cache-Control: no-cache, must-revalidate" ); 
header("Pragma: no-cache" );
header("Content-Type: text/xml; charset=UTF-8");

require('../connectDB.php');


$userid = $_GET['userid'];


if ($userid != "") {
	
	$sql = " DELETE FROM Watchlist where id_User=".$userid;
	mysql_query($sql);
	if (mysql_error()) {
		echo "Bei Löschen der Merkliste ist ein Fehler aufgetreten: \n";
		echo "mysql_affected_rows()".mysql_affected_rows();
		echo mysql_error();
		die();
	}
	$sql = " UPDATE Formdata SET block_id_User = null where block_id_User=".$userid;
	mysql_query($sql);
	if (mysql_error()) {
		echo "Bei Löschen der Referenzen ist ein Fehler aufgetreten: \n";
		echo "mysql_affected_rows()".mysql_affected_rows();
		echo mysql_error();
		die();
	}
	$sql = " DELETE FROM User where id=".$userid;
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
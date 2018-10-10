<? 
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT" ); 
header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" ); 
header("Cache-Control: no-cache, must-revalidate" ); 
header("Pragma: no-cache" );
header("Content-Type: text/xml; charset=UTF-8");

require('../connectDB.php');


$title= $_GET[foldertitle];
$id= $_GET['id'];

if ($id) {
	$sql = " UPDATE Folder SET title ='".$title."'  "
			." WHERE id=".$id;
	mysql_query($sql);
	if (mysql_affected_rows()!=1) {
		echo "Bei Umbenennen des Ordners ist ein Fehler aufgetreten: \n";
		echo $sql."\n";
		echo "mysql_affected_rows()".mysql_affected_rows()."\n";
		echo mysql_error();
		die();
	}
	$newid = $id;
} else {

	$sql = " INSERT INTO Folder (title) "
			." VALUES ('".$title."')";
	mysql_query($sql);
	if (mysql_affected_rows()!=1) {
		echo "Bei Anlegen eines neuen Ordners ist ein Fehler aufgetreten: \n";
		echo $sql."\n";
		echo "mysql_affected_rows()".mysql_affected_rows()."\n";
		echo mysql_error();
		die();
	}
	$newid = mysql_insert_id();
}


echo $newid;


?>
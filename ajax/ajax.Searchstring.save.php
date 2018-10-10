<? 
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT" ); 
header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" ); 
header("Cache-Control: no-cache, must-revalidate" ); 
header("Pragma: no-cache" );
header("Content-Type: text/xml; charset=UTF-8");

require('../connectDB.php');

$sstringid= $_GET[sstringid];
$title= $_GET[title];
$sstring= $_GET[sstring];
$editor= $_GET[editor];
$newid = $sstringid;

if ($sstringid != "") {
	$sql = " UPDATE Searchstring SET title='".$title."' , sstring='".$sstring."' , editor='".$editor."' where id=".$sstringid;
	mysql_query($sql);
} else {
	$sql = " INSERT INTO Searchstring (sstring,title,editor) VALUES ('".$sstring."' , '".$title."', '".$editor."')";
	mysql_query($sql);
	$newid = mysql_insert_id();
}



if (mysql_affected_rows()!=1) {
	echo "Bei Speichern ist ein Fehler aufgetreten: \n";
	echo "mysql_affected_rows()".mysql_affected_rows();
	echo mysql_error();
	die();
}
	
echo $newid;


?>
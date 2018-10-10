<? 
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT" ); 
header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" ); 
header("Cache-Control: no-cache, must-revalidate" ); 
header("Pragma: no-cache" );
header("Content-Type: text/xml; charset=UTF-8");

require('../connectDB.php');


$trayid = $_POST['trayid'];
$name= $_POST['name'];
$editor= $_POST['editor'];

if ($trayid != "") {
	$sql = " UPDATE Tray SET name='".$name."', editor='".$editor."' where id=".$trayid;
	mysql_query($sql);
	$newid = $trayid;
} else {
	$sql = " INSERT INTO Tray (name,editor) VALUES ('".$name."','".$editor."' )";
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
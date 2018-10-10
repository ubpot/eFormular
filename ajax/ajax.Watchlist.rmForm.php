<? 
session_start();

header("Expires: Mon, 26 Jul 1997 05:00:00 GMT" ); 
header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" ); 
header("Cache-Control: no-cache, must-revalidate" ); 
header("Pragma: no-cache" );
header("Content-Type: text/xml; charset=iso-8859-1");

require('../connectDB.php');

$Userid= $_SESSION['userid'];

for ($i = 0; $i < count($_GET['formdataid']); $i++) {

	$sql = " DELETE FROM Watchlist  "
			." WHERE id_User = ".$userid." AND id_FormData = ".$_GET['formdataid'];
	mysql_query($sql);
	if (mysql_affected_rows()!=1) {
		echo "Bei Löschen der Watchlist ist ein Fehler aufgetreten: \n";
		echo $sql."\n";
		echo "mysql_affected_rows()".mysql_affected_rows()."\n";
		echo mysql_error();
		
	}
};



?>
<?
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT" ); 
header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" ); 
header("Cache-Control: no-cache, must-revalidate" ); 
header("Pragma: no-cache" );
header("Content-Type: text/xml;  charset=UTF-8");

require('myJSONlib.php'); 
require('../connectDB.php');

$id = $_GET[id];



$sql = " UPDATE Formular SET nextVersion=0 where id=".$id;
//echo $sql;
$result = mysql_query($sql);

//$row = mysql_fetch_assoc($result);
//print_r ($row);

//$string = row2Json($row);

//echo $string;
//echo mysql_error();
if (mysql_affected_rows()!=1) {
	echo 0;
} else {
	echo 1;
}
?>

<?
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT" ); 
header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" ); 
header("Cache-Control: no-cache, must-revalidate" ); 
header("Pragma: no-cache" );
header("Content-Type: text/xml; charset=UTF-8");

require('../connectDB.php');
require('myJSONlib.php'); 


$folderid = $_GET[folderid];

$sql = " Select title,id from Folder where id=".$folderid;
//echo $sql;
$result = mysql_query($sql);

$row = mysql_fetch_assoc($result);
//print_r ($row);

$string = getRecord($row);

echo $string;
echo mysql_error();

?>
<?
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT" ); 
header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" ); 
header("Cache-Control: no-cache, must-revalidate" ); 
header("Pragma: no-cache" );
header("Content-Type: text/xml; charset=UTF-8");

require('myJSONlib.php'); 
require('../connectDB.php');


$sql = " Select id,name from Mailtempl ORDER BY name";

$result = mysql_query($sql);

$json=result2Json($result);

echo $json;
echo mysql_error();

?>
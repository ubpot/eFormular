<?
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT" ); 
header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" ); 
header("Cache-Control: no-cache, must-revalidate" ); 
header("Pragma: no-cache" );
header("Content-Type: text/xml; charset=UTF-8");

require('myJSONlib.php'); 

require('../connectDB.php');
$id = $_GET[id];



$sql = " Select id,title,sstring,editor,date_format(Searchstring.timestamp,'%Y-%m-%d') as timestamp  from Searchstring where id=".$id;
//echo $sql;
$result = mysql_query($sql);

$row = mysql_fetch_assoc($result);
//print_r ($row);

$string = row2Json($row);

echo $string;
echo mysql_error();

?>

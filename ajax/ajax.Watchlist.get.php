<? 
session_start();

header("Expires: Mon, 26 Jul 1997 05:00:00 GMT" ); 
header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" ); 
header("Cache-Control: no-cache, must-revalidate" ); 
header("Pragma: no-cache" );
header("Content-Type: text/xml;  charset=UTF-8");

require('../connectDB.php');
require('myJSONlib.php'); 

$sql = " Select id_FormData as formdataid,Formdata.title as title,id_Form as formid, Folder.title as foldertitle "
		." from Watchlist,(Formdata left JOIN Folder on(Formdata.id_Folder = Folder.id)) "
		." where Watchlist.id_FormData = Formdata.id AND  id_User=".$_SESSION['userid'];
//echo $sql;
$result = mysql_query($sql);

$json=result2Json($result);

//print_r ($row);

echo $json;
echo mysql_error();

?>
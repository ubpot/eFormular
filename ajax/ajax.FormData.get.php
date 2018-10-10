<?
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT" ); 
header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" ); 
header("Cache-Control: no-cache, must-revalidate" ); 
header("Pragma: no-cache" );
header("Content-Type: text/xml; charset=UTF-8");

require('../connectDB.php');
require('myJSONlib.php'); 


$dataid = $_GET[dataid];
$editorid= $_GET[editorid];
if (! $dataid) {
	die("{}");
}


$sql = " Select Formdata.title as title,version,prevVersion,nextVersion,json,Formdata.editor as editor "
		." ,hinttext,id_Tray,status,id_Folder,block_begin, block_id_User, User.name as block_User "
		." from Formdata LEFT JOIN User ON (Formdata.block_id_User = User.id) where  Formdata.id=".$dataid;

$result = mysql_query($sql);
echo mysql_error();

$row = mysql_fetch_assoc($result);

if ($row['block_begin']=="" && $row['nextVersion']=="") {
	$sql = "UPDATE Formdata SET block_begin=now(),block_id_User = ".$editorid." where Formdata.id=".$dataid;
	mysql_query($sql);
	if (mysql_affected_rows()!=1 )  {
		echo "Bei Blockieren des Formulars ist ein Fehler aufgetreten: \n";
		echo "mysql_affected_rows()".mysql_affected_rows();
		echo mysql_error();
		echo $sql;
	}
}
//print_r ($row);

$string = getRecord($row);

echo $string;
echo mysql_error();

?>
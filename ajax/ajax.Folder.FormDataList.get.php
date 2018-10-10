<?
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT" ); 
header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" ); 
header("Cache-Control: no-cache, must-revalidate" ); 
header("Pragma: no-cache" );
header("Content-Type: text/xml; charset=iso-8859-1");

require('../connectDB.php');
require('myJSONlib.php'); 

$folderid = $_GET['folderid'];

$sql = " Select Formdata.id as formdataid, id_Form as formid , Formdata.title as title, Formular.title as Formulartyptitle,status "
		." from Formdata ,Formular "
		." where Formdata.id_Form =  Formular.id  AND Formdata.nextVersion is NULL  AND id_Folder = ".$folderid 
		." ORDER BY Formular.title  " ;
//echo $sql;
$result = mysql_query($sql);

$json=result2Json($result);

//print_r ($row);

echo $json;
echo mysql_error();

?>
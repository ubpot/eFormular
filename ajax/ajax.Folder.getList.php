<?
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT" ); 
header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" ); 
header("Cache-Control: no-cache, must-revalidate" ); 
header("Pragma: no-cache" );
header("Content-Type: text/xml; charset=UTF-8");

require('../connectDB.php');
require('myJSONlib.php'); 

if ($_GET['onlyoutstanding']) {
	// UNION aus Perfomancegründen
	$sql = "   (Select Folder.id as folderid, Folder.title as title"
			." 		from Folder JOIN Formdata ON (Folder.id = Formdata.id_Folder) "
			." 		WHERE Formdata.nextVersion IS NULL AND status != 'erledigt'"
			." ) "
			." UNION "
			." (Select Folder.id as folderid, Folder.title as title"
			." 		from Folder LEFT JOIN Formdata ON (Folder.id = Formdata.id_Folder) "
			." 		WHERE 	status is null	"
			." )order by title";
}	else  {
		$sql = " Select id as folderid, title from Folder order by title";
}


//echo $sql;
$result = mysql_query($sql);

$json=result2Json($result);

//print_r ($row);

echo $json;
echo mysql_error();


?>
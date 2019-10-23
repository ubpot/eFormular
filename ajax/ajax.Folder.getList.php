<?php
require('../connectDB.php');
require('myJSONlib.php');

require('ajax.lib.php');

sendAjaxHeader();

if (isset ($_GET['onlyoutstanding'])) {
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
$result = mysqli_query($db,$sql);

$json=result2Json($result);

//print_r ($row);

echo $json;
echo mysqli_error($db);


?>
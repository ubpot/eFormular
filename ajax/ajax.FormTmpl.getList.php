<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" );
header("Cache-Control: no-cache, must-revalidate" );
header("Pragma: no-cache" );
header("Content-Type: text/xml; charset=UTF-8");

require('../connectDB.php');
require('myJSONlib.php');


$sql = " Select id as formid, title from Formular where nextVersion is null ORDER BY title";
//echo $sql;
$result = mysqli_query($db,$sql);

$json=result2Json($result);

//print_r ($row);

echo $json;
echo mysqli_error($db);


?>
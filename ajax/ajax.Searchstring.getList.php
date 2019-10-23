<?php

require('myJSONlib.php');

require('../connectDB.php');
require('ajax.lib.php');

sendAjaxHeader();

$sql = " Select id,title,sstring from Searchstring ORDER BY title";
//echo $sql;
$result = mysqli_query($db,$sql);

$json=result2Json($result);

echo $json;
echo mysqli_error($db);

?>

<?php

require('myJSONlib.php');
require('../connectDB.php');

require('ajax.lib.php');

sendAjaxHeader();

$sql = " Select id,name from Mailtempl ORDER BY name";

$result = mysqli_query($db,$sql);

$json=result2Json($result);

echo $json;
echo mysqli_error($db);

?>
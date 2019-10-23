<?php

require('../connectDB.php');
require('ajax.lib.php');

sendAjaxHeader();

$id = $_GET['id'];

$sql = " Select id,name,params,text,editor,date_format(Mailtempl.timestamp,'%Y-%m-%d') as timestamp from Mailtempl where id=".$id;
//echo $sql;
$result = mysqli_query($db,$sql);

$row = mysqli_fetch_assoc($result);
//print_r ($row);

$row = nullValues2emptyString($row);
$string = json_encode ($row);

echo $string;
echo mysqli_error($db);

?>
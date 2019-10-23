<?php
require('../connectDB.php');
require('ajax.lib.php');

sendAjaxHeader();

$id = $_GET['id'];

$sql = " Select id,html,title,version,nextVersion,prevVersion,editor from Formular where id=".$id;
//echo $sql;
$result = mysqli_query($db,$sql);

$row = mysqli_fetch_assoc($result);
//print_r ($row);

$row = nullValues2emptyString($row);
$string = json_encode($row,JSON_THROW_ON_ERROR|JSON_INVALID_UTF8_SUBSTITUTE);

echo $string;
echo mysqli_error($db);

?>

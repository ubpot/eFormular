<?php

require('../connectDB.php');
require('ajax.lib.php');

sendAjaxHeader();


$folderid = $_GET['folderid'];

$sql = " Select title,id from Folder where id=".$folderid;
//echo $sql;
$result = mysqli_query($db,$sql);

$row = mysqli_fetch_assoc($result);
//print_r ($row);

$row = nullValues2emptyString($row);
$string = json_encode ($row);

echo $string;
echo mysqli_error($db);

?>
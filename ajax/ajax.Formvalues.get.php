<?php

require('../connectDB.php');
require('myJSONlib.php');
require('ajax.lib.php');

sendAjaxHeader();

$folderid = $_GET['folderid'];
if (! $folderid) {
	die("{}");
}


$sql = " Select Formular.title as formulartitle"
		." from Formdata,Formular where Formdata.id_Form=Formular.id AND Formdata.nextVersion is null AND Formdata.id_Folder=".$folderid;
//echo $sql."\n";
$result = mysqli_query($db,$sql);
echo mysqli_error($db);

$string = "{";

while ($row = mysqli_fetch_assoc($result)){
	$sql2 = " Select Formvalues.value as value, Formvalues.id_Element as id "
		." from Formvalues,Formdata,Formular where Formvalues.id_Formdata= Formdata.id AND Formdata.id_Form=Formular.id AND  Formdata.nextVersion is null "
		." AND Formular.title='".$row['formulartitle']."' AND Formdata.id_Folder=".$folderid;
	//echo $sql2."\n";;
	$result2 = mysqli_query($db,$sql2);
	echo mysqli_error($db);
	$string2 = "";
	while ($row2 = mysqli_fetch_assoc($result2)){
		$string2 .= '"'.$row2['id'].'":"'.$row2['value'].'",';
	}
	$string2 = substr($string2, 0, -1);
	$string .= '"'.$row['formulartitle'].'":{'.$string2."},";
}

$string = substr($string, 0, -1);

$string .= "}";

echo $string;


?>
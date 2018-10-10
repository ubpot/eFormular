<?
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT" ); 
header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" ); 
header("Cache-Control: no-cache, must-revalidate" ); 
header("Pragma: no-cache" );
header("Content-Type: text/xml; charset=UTF-8");

require('../connectDB.php');
require('myJSONlib.php'); 


$folderid = $_GET[folderid];
if (! $folderid) {
	die("{}");
}


$sql = " Select Formular.title as formulartitle"
		." from Formdata,Formular where Formdata.id_Form=Formular.id AND Formdata.nextVersion is null AND Formdata.id_Folder=".$folderid;
//echo $sql."\n";
$result = mysql_query($sql);
echo mysql_error();

$string = "{";

while ($row = mysql_fetch_assoc($result)){
	$sql2 = " Select Formvalues.value as value, Formvalues.id_Element as id "
		." from Formvalues,Formdata,Formular where Formvalues.id_Formdata= Formdata.id AND Formdata.id_Form=Formular.id AND  Formdata.nextVersion is null "
		." AND Formular.title='".$row['formulartitle']."' AND Formdata.id_Folder=".$folderid;
	//echo $sql2."\n";;
	$result2 = mysql_query($sql2);
	echo mysql_error();
	$string2 = "";
	while ($row2 = mysql_fetch_assoc($result2)){
		$string2 .= '"'.$row2['id'].'":"'.$row2['value'].'",';
	}
	$string2 = substr($string2, 0, -1);	
	$string .= '"'.$row['formulartitle'].'":{'.$string2."},";
}

$string = substr($string, 0, -1);	

$string .= "}";

echo $string;


?>
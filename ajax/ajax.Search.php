<?php

require('../connectDB.php');
require('ajax.lib.php');

sendAjaxHeader();

$where_block = "";

if ($_GET['onlyoutstanding'] == 1) {
	$where_block .= " AND status='unerledigt'";
}

$order_block = " status ";

if ($_GET['sort'] == 'name') {
	$order_block = " Folder.title,Formdata.title DESC";
}

if ($_GET['sort'] == 'date') {
	$order_block = " date DESC";
}

if ($_GET['sort'] == 'dateasc') {
	$order_block = " date ASC ";
}


function row2Json($row) {
	if ($row == "") {
		return ("{}");
	}
	$string = '{';
	foreach ($row as $key => $val) {
		$string.='"'.$key.'":"'.addslashes(str_replace("\r\n", " ", $val)).'",';
	}
	$string = substr($string, 0, -1);				// Letztes komma lÃ¶schen
	$string.='}';
	return $string;

}

function result2Json ($result) {
	$string = "[";
	while ($row = mysqli_fetch_assoc($result)) {
		$string .= row2Json($row).",";
	}
	$string = substr($string, 0, -1);				// Letztes komma lÃ¶schen
	$string .= "]";
	return $string;
}

function query2sql($query) {
	global $where_block;
	global $order_block;
	$query_array = explode (" ",$query);
	$jsonstring = "";
	$elementstring = "";
	$elementleftjoin = "";
	$Makros= array();

	$Makros['/%EF_NOW[+]1WEEK%/'] = date('Y-m-d',time()+ (7 * 24 * 60 * 60));
	$Makros['/%EF_NOW[+]1MONTH%/'] = date('Y-m-d',time()+ (30 * 24 * 60 * 60));
	$Makros['/%EF_NOW%/'] = date('Y-m-d');

	// echo $query;
	for ($i = 0; $i < count($query_array); $i++ ) {
		foreach ($Makros as $key => $val) {

			$query_array [$i] = preg_replace($key, $val,  $query_array [$i]);
			//if ($_SERVER['REMOTE_ADDR']=="141.89.36.117") echo $key.", ".$val." - ". $query_array [$i]."\n";
		}
		if (preg_match('/(.*)=(.*)/', $query_array [$i], $treffer)) {
			//print_r ($treffer);
			$elementstring .= " Formvalues.id_Element='".$treffer[1]."' AND Formvalues.value like '%".$treffer[2]."%' AND ";
			$elementleftjoin = " LEFT JOIN Formvalues ON (Formdata.id =  Formvalues.id_Formdata) ";
		} else if (preg_match('/(.*)!=(.*)/', $query_array [$i], $treffer)) {
			$elementstring .= " Formvalues.id_Element='".$treffer[1]."' AND not Formvalues.value like '%".$treffer[2]."%' AND ";
			$elementleftjoin = " LEFT JOIN Formvalues ON (Formdata.id =  Formvalues.id_Formdata) ";
		} else if (preg_match('/(.*)>(.*)/', $query_array [$i], $treffer)) {
			$elementstring .= " Formvalues.id_Element='".$treffer[1]."' AND Formvalues.value > '".$treffer[2]."' AND ";
			$elementleftjoin = " LEFT JOIN Formvalues ON (Formdata.id =  Formvalues.id_Formdata) ";
		} else if (preg_match('/(.*)<(.*)/', $query_array [$i], $treffer)) {
			$elementstring .= " Formvalues.id_Element='".$treffer[1]."' AND Formvalues.value < '".$treffer[2]."' AND ";
			$elementleftjoin = " LEFT JOIN Formvalues ON (Formdata.id =  Formvalues.id_Formdata) ";
		} else if (preg_match('/(.*)>=(.*)/', $query_array [$i], $treffer)) {
			$elementstring .= " Formvalues.id_Element='".$treffer[1]."' AND Formvalues.value >= '".$treffer[2]."' AND ";
			$elementleftjoin = " LEFT JOIN Formvalues ON (Formdata.id =  Formvalues.id_Formdata) ";
		} else if (preg_match('/(.*)<=(.*)/', $query_array [$i], $treffer)) {
			$elementstring .= " Formvalues.id_Element='".$treffer[1]."' AND Formvalues.value <= '".$treffer[2]."' AND ";
			$elementleftjoin = " LEFT JOIN Formvalues ON (Formdata.id =  Formvalues.id_Formdata) ";
		} else  {
			$jsonstring .= "(json like '%".$query_array [$i]."%' OR Formdata.title like '%".$query_array [$i]."%' OR Folder.title like '%".$query_array [$i]."%') AND";
		}
	}
	//$jsonstring = substr($jsonstring, 0, -4);

	$sql = " Select Formdata.id as formdataid, id_Form as formid, Formdata.title as title, Formular.title as Formulartyptitle,status,Tray.name as ablage , "
			." Folder.title as foldertitle , hinttext , date_format(Formdata.timestamp,'%Y-%m-%d') as date"
			." from Formdata LEFT JOIN Tray ON (Formdata.id_Tray=Tray.id) LEFT JOIN Folder ON (Formdata.id_Folder=Folder.id) "
			." 			 ".$elementleftjoin ." ,Formular  "
			." where ".$jsonstring.$elementstring." Formdata.nextVersion is NULL AND Formdata.id_Form =  Formular.id ".$where_block." ORDER BY ".$order_block ;
	return $sql;
}

$query = (isset($_GET['query'])) ? $_GET['query'] : null;
$sstringid = (isset($_GET['sstringid'])) ? $_GET['sstringid'] : null;
$tray = (isset($_GET['tray'])) ? $_GET['tray'] : null;

if ($query) {
	$sql= query2sql($query);
} else if ($tray) {
	$sql = " Select Formdata.id as formdataid, id_Form as formid, Formdata.title as title, Formular.title as Formulartyptitle,status,Tray.name as ablage ,"
			." Folder.title as foldertitle, hinttext , date_format(Formdata.timestamp,'%Y-%m-%d') as date  "
			." from (Formdata LEFT JOIN Tray ON (Formdata.id_Tray=Tray.id))LEFT JOIN Folder ON (Formdata.id_Folder=Folder.id)  ,Formular "
			." where id_Tray = ".$tray." AND Formdata.nextVersion is NULL AND Formdata.id_Form =  Formular.id  ".$where_block." ORDER BY ".$order_block ;
} else if ($sstringid) {

	$sql = " Select id,title,sstring from Searchstring where id=".$sstringid;
	$result = mysqli_query($db,$sql);
	$row = mysqli_fetch_assoc($result);
	$query = $row['sstring'];

	$sql= query2sql($query);
}

//if ($_SERVER['REMOTE_ADDR']=="141.89.36.117") echo $sql;
//echo $sql;

$result = mysqli_query($db,$sql);

$json=result2Json($result);

//print_r ($row);

echo $json;
echo mysqli_error($db);

?>

<?
function getRecord($row) {
	if ($row == "") {
		return ("{}");
	}
	$string = '{';
	foreach ($row as $key => $val) {
		$string.='"'.$key.'":"'.addslashes(str_replace("\r\n", " ", $val)).'",';
	}
	$string = substr($string, 0, -1);				// Letztes komma löschen
	$string.='}';
	return $string;

}

function row2Json($row) {
	if ($row == "") {
		return ("{}");
	}
	$string = '{';
	foreach ($row as $key => $val) {
		$string.='"'.$key.'":"'.addslashes(str_replace("\r\n", " ", $val)).'",';
	}
	$string = substr($string, 0, -1);				// Letztes komma löschen
	$string.='}';
	return $string;

}

function result2Json ($result) {
	$string = "[";
	while ($row = mysql_fetch_assoc($result)) {
		$string .= row2Json($row).",";
	}
	if ($string != "[" ) $string = substr($string, 0, -1);				// Letztes komma löschen
	$string .= "]";
	return $string;
}
?>
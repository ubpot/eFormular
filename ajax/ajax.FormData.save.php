<?
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" );
header("Cache-Control: no-cache, must-revalidate" );
header("Pragma: no-cache" );
header("Content-Type: text/xml; charset=UTF-8");

require('../connectDB.php');

$formid = $_POST[formid];
if ($_POST['dataid']) $dataid = $_POST['dataid']; else $dataid="NULL";
$json= $_POST[json];
$title= $_POST[title];
if ($_POST[version])  $version= $_POST[version]; else $version=1;
$editor= $_POST[editor];
$editorid= $_POST[editorid];
$hinttext= $_POST[hinttext];
if ($_POST['trayid']) $trayid = $_POST['trayid']; else $trayid = "null";
if ($_POST['folderid']) $folderid = $_POST['folderid']; else $folderid = "null";
$status = $_POST['status'];

//if ($dataid != "") {
//	$sql = " UPDATE Formdata SET json='".$json."', title='".$title."' , json='".$json."' where id=".$dataid;
//} else {
	$json2 = str_replace("\\\\\\\\u007d","}",$json);
	$sql = " INSERT INTO Formdata (json,id_Form,title,version,prevVersion,editor,hinttext,id_Tray,status,id_Folder,block_begin,block_id_User) "
			." VALUES ('".$json2."' , ".$formid.",'".$title."',".$version.",".$dataid.",'".$editor."','".$hinttext."',".$trayid.",'".$status."',".$folderid.",now(),".$editorid.")";
	mysql_query($sql);
	if (mysql_affected_rows()!=1) {
		echo "Bei Speichern der neuen Version ist ein Fehler aufgetreten: \n";
		echo $sql."\n";
		echo "mysql_affected_rows()".mysql_affected_rows()."\n";
		echo mysql_error();
		die();
	}
	$newid = mysql_insert_id();
	if ($dataid != "NULL") {
		$sql = "UPDATE Formdata SET nextVersion=".$newid .", block_begin = null, block_id_User=null where id=".$dataid;
		mysql_query($sql);
		if (mysql_affected_rows()!=1 )  {
			echo "Bei aktualisieren der Vorversion ist ein Fehler aufgetreten: \n";
			echo "mysql_affected_rows()".mysql_affected_rows();
			echo mysql_error();
		}
	}
	// Füllen der Tabelle mit den Values
	// Ermiteln der Values

	// Alte Einträge in der Indextabelle löschen
	$sql = "DELETE FROM Formvalues where id_Formdata=".$dataid;
	mysql_query($sql);
	echo mysql_error();
	
	
	preg_match_all ('/{.*}/U',$json,$Matches,PREG_SET_ORDER);
	//print_r($Matches);
	for ($i=0; $i < count($Matches);$i++) {
		
		preg_match ('/\\\"id\\\":\\\"(.*)\\\"/U',$Matches[$i][0],$Matches_id);
		$id_Element = $Matches_id[1];
		//print_r($Matches_id);
		if (trim($id_Element)=="") continue;
		
		preg_match ('/\\\"value\\\":\\\"(.*)\\\"/U',$Matches[$i][0],$Matches_value);
		$Value_Element = str_replace("\\\\\\\\u007d","}",$Matches_value[1]);
		//print_r($Matches_value);
		

		if (trim($Value_Element)=="") continue;
		
		$sql = " INSERT INTO Formvalues (id_Element,id_Formdata,value) "
		." VALUES ('".$id_Element."' , ".$newid.",'".$Value_Element."')";
		//echo $sql;
		mysql_query($sql);
		
		if (mysql_affected_rows()!=1 )  {
			echo "Bei aktualisieren der Indextabelle ist ein Fehler aufgetreten: \n";
			echo "mysql_affected_rows()".mysql_affected_rows();
			
			echo mysql_error();
			echo "\n".$sql."\n";
		}
		
	}
		

	echo $newid;


?>
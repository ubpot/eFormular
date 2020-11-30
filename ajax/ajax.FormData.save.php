<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" );
header("Cache-Control: no-cache, must-revalidate" );
header("Pragma: no-cache" );
header("Content-Type: text/xml; charset=UTF-8");

require('../connectDB.php');

$formid = $_POST['formid'];
if ($_POST['dataid']) $dataid = $_POST['dataid']; else $dataid="NULL";
$json= $_POST['json'];
$title= $_POST['title'];
if ($_POST['version'])  $version= $_POST['version']; else $version=1;
$editor= $_POST['editor'];
$editorid= $_POST['editorid'];
$hinttext= $_POST['hinttext'];
if ($_POST['trayid']) $trayid = $_POST['trayid']; else $trayid = "null";
if ($_POST['folderid']) $folderid = $_POST['folderid']; else $folderid = "null";
$status = $_POST['status'];

//if ($dataid != "") {
//	$sql = " UPDATE Formdata SET json='".$json."', title='".$title."' , json='".$json."' where id=".$dataid;
//} else {
	$json2 = str_replace("\\\\\\\\u007d","}",$json);
	$sql = " INSERT INTO Formdata (json,id_Form,title,version,prevVersion,editor,hinttext,id_Tray,status,id_Folder,block_begin,block_id_User) "
			." VALUES ('".$json2."' , ".$formid.",'".$title."',".$version.",".$dataid.",'".$editor."','".$hinttext."',".$trayid.",'".$status."',".$folderid.",now(),".$editorid.")";
	mysqli_query($db,$sql);
	if (mysqli_affected_rows($db)!=1) {
		echo "Bei Speichern der neuen Version ist ein Fehler aufgetreten: \n";
		echo $sql."\n";
		echo "mysqli_affected_rows()".mysqli_affected_rows($db)."\n";
		echo mysqli_error($db);
		die();
	}
	$newid = mysqli_insert_id($db);
	if ($dataid != "NULL") {
		$sql = "UPDATE Formdata SET nextVersion=".$newid .", block_begin = null, block_id_User=null where id=".$dataid;
		mysqli_query($db,$sql);
		if (mysqli_affected_rows($db)!=1 )  {
			echo "Bei aktualisieren der Vorversion ist ein Fehler aufgetreten: \n";
			echo "mysqli_affected_rows()".mysqli_affected_rows($db);
			echo mysqli_error($db);
		}
	}
	// Füllen der Tabelle mit den Values
	// Ermiteln der Values

	// Alte Einträge in der Indextabelle löschen
	$sql = "DELETE FROM Formvalues where id_Formdata=".$dataid;
	mysqli_query($db,$sql);
	echo mysqli_error($db);


	preg_match_all ('/{.*}/U',$json,$Matches,PREG_SET_ORDER);
	//print_r($Matches);
	for ($i=0; $i < count($Matches);$i++) {

		preg_match ('/\\\"id\\\":\\\"(.*)\\\"/U',$Matches[$i][0],$Matches_id);

		if ( isset ($Matches_id[1])) {
			$id_Element = $Matches_id[1];

			preg_match ('/\\\"value\\\":\\\"(.*)\\\"/U',$Matches[$i][0],$Matches_value);
			$Value_Element = str_replace("\\\\\\\\u007d","}",$Matches_value[1]);
			//print_r($Matches_value);


			if (trim($Value_Element)=="") continue;

			$sql = " INSERT INTO Formvalues (id_Element,id_Formdata,value) "
			." VALUES ('".$id_Element."' , ".$newid.",'".$Value_Element."')";
			mysqli_query($db,$sql);

			if (mysqli_affected_rows($db)!=1 )  {
				echo "Bei aktualisieren der Indextabelle ist ein Fehler aufgetreten: \n";
				echo "mysqli_affected_rows()".mysqli_affected_rows($db);

				echo mysqli_error($db);
				echo "\n".$sql."\n";
			}
		} else{
			preg_match ('/\"id\":\"(.*)\"/U',$Matches[$i][0],$Matches_id);
			//print_r($Matches_id);
			if (!isset ($Matches_id[1]) || $Matches_id[1] == "" || $Matches_id[1] == " ") {continue;}
			$id_Element = $Matches_id[1];


			preg_match ('/\"value\":\"(.*)\"/U',$Matches[$i][0],$Matches_value);
			$Value_Element = str_replace("\\\\\\\\u007d","}",$Matches_value[1]);
			//print_r($Matches_value);


			if (trim($Value_Element)=="") continue;

			$sql = " INSERT INTO Formvalues (id_Element,id_Formdata,value) "
			." VALUES ('".$id_Element."' , ".$newid.",'".$Value_Element."')";
			mysqli_query($db,$sql);

			if (mysqli_affected_rows($db)!=1 )  {
				echo "Bei aktualisieren der Indextabelle ist ein Fehler aufgetreten: \n";
				echo "mysqli_affected_rows()".mysqli_affected_rows($db);

				echo mysqli_error($db);
				echo "\n".$sql."\n";
			}
		}

	}


	echo $newid;


?>

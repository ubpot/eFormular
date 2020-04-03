<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" );
header("Cache-Control: no-cache, must-revalidate" );
header("Pragma: no-cache" );
header("Content-Type: text/xml; charset=iso-8859-1");

require('../connectDB.php');


if ($_POST['formid']) $formid = $_POST['formid']; else $formid="NULL";
$html= mysqli_real_escape_string($db, $_POST['html']);
$title= $_POST['title'];
if ($_POST['version'])  $version= $_POST['version']; else $version=1;
$editor= $_POST['editor'];

//if ($dataid != "") {
//      $sql = " UPDATE Formdata SET json='".$json."', title='".$title."' , json='".$json."' where id=".$dataid;
//} else {

        $sql = " INSERT INTO Formular (html,title,version,prevVersion,editor) VALUES ('".$html."' , '".$title."',".$version.",".$formid.",'".$editor."')";
        mysqli_query($db,$sql);
        if (mysqli_affected_rows($db)!=1) {
                echo "Bei Speichern der neuen Version ist ein Fehler aufgetreten: \n";
                echo "mysqli_affected_rows()".mysqli_affected_rows($db);
                echo mysqli_error($db);
                die();
        }
        $newid = mysqli_insert_id($db);
        if ($formid != "NULL") {
                $sql = "UPDATE Formular SET nextVersion=".$newid ." where id=".$formid;
                mysqli_query($db,$sql);
                if (mysqli_affected_rows($db)!=1 )  {
                        echo "Bei aktualisieren der Vorversion ist ein Fehler aufgetreten: \n";
                        echo "mysqli_affected_rows()".mysqli_affected_rows($db)."\n";
                        echo mysqli_error($db);
                }
        }

        echo $newid;



?>

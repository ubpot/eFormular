<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" );
header("Cache-Control: no-cache, must-revalidate" );
header("Pragma: no-cache" );
header("Content-Type: text/xml; charset=iso-8859-1");

require('connectDB.php');


$Name = $_POST[Name];
$Mail = $_POST[Mail];
$Institution = $_POST[Institution];
$Publikation = $_POST[Publikation];
$DOI = $_POST[DOI];
$Zeitschrift = $_POST[Zeitschrift];
$Verlag = $_POST[Verlag];
$ISSN = $_POST[ISSN];
$Datum = $_POST[Datum];
$Akzeptanz = $_POST[Akzeptanz];
$Kosten = $_POST[Kosten];
$Drittmittel = $_POST[Drittmittel];
$Bemerkungen = $_POST[Bemerkungen];
$Akzeptieren = $_POST[Akzeptieren];
$Angehoeriger = $_POST[Angehoeriger];
$Nachwuchs = $_POST[Nachwuchs];
$timestamp = time();
	$sqlform = "SELECT * FROM Formular where (id = 786)";
	$resultform = mysql_query($sqlform);
	$rowform = mysql_fetch_array($resultform);

//inhalt formstring

	$html2 = $rowform['html'];
	$html = real_escape_string($html2);

$eintrag = "INSERT INTO anfrage (Name, Mail, Institution, Publikation, DOI, Zeitschrift, Verlag, ISSN, Datum, Akzeptanz, Kosten, Drittmittel, Bemerkungen, Akzeptieren, Angehoeriger, Nachwuchs, timestamp) VALUES ('$Name','$Mail', '$Institution', '$Publikation', '$DOI', '$Zeitschrift', '$Verlag', '$ISSN', '$Datum', '$Akzeptanz', '$Kosten', '$Drittmittel', '$Bemerkungen', '$Akzeptieren', '$Angehoeriger', '$Nachwuchs', '$timestamp' )";
//$eintrag = "INSERT INTO anfrage (Name, Mail) VALUES ('$Name','$Mail')";
$eintragen = mysql_query($eintrag);

$eintrag = " INSERT INTO anfrage (Name, Bemerkungen) VALUES ('".$Name."','".$html."')";
//$eintrag = "INSERT INTO anfrage (Name, Mail) VALUES ('$Name','$Mail')";
$eintragen = mysql_query($eintrag);

echo $Name;




//if ($dataid != "") {
//      $sql = " UPDATE Formdata SET json='".$json."', title='".$title."' , json='".$json."' where id=".$dataid;
//} else {
if (false)
{
        $sql = " INSERT INTO Formular (html,title,version,prevVersion,editor) VALUES ('".$html."' , '".$title."',".$version.",".$formid.",'".$editor."')";
        mysql_query($sql);
        if (mysql_affected_rows()!=1) {
                echo "Bei Speichern der neuen Version ist ein Fehler aufgetreten: \n";
                echo "mysql_affected_rows()".mysql_affected_rows();
                echo mysql_error();
                die();
        }
        $newid = mysql_insert_id();
        if ($formid != "NULL") {
                $sql = "UPDATE Formular SET nextVersion=".$newid ." where id=".$formid;
                mysql_query($sql);
                if (mysql_affected_rows()!=1 )  {
                        echo "Bei aktualisieren der Vorversion ist ein Fehler aufgetreten: \n";
                        echo "mysql_affected_rows()".mysql_affected_rows()."\n";
                        echo mysql_error();
                }
        }

        echo $newid;

}

?>
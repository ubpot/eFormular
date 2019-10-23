<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" );
header("Cache-Control: no-cache, must-revalidate" );
header("Pragma: no-cache" );
header("Content-Type: text/xml; charset=UTF-8");

require('../connectDB.php');


$userid = $_POST['userid'];
$page= $_POST['page'];
$name= $_POST['name'];
$shortname= $_POST['shortname'];
$login= $_POST['login'];
$passwd= $_POST['passwd'];
$editor= $_POST['editor'];

if ($userid != "") {
	if ($passwd) {
		$sql = " UPDATE User SET name='".$name."' , login='".$login."' , passwd='".$passwd."', page='".$page."', shortname='".$shortname."' , editor='".$editor."' where id=".$userid;
	} else {
		$sql = " UPDATE User SET name='".$name."' , login='".$login."' , page='".$page."' , shortname='".$shortname."' , editor='".$editor."' where id=".$userid;
	}
	mysqli_query($db,$sql);
	$newid = $userid;
} else {
	if ($passwd) {
		$sql = " INSERT INTO User (name,login,shortname,passwd,page,editor) VALUES ('".$name."' , '".$login."', '".$shortname."', '".$passwd."' , '".$page."',  '".$editor."')";
	} else {
		$sql = " INSERT INTO User (name,login,shortname,page,editor) VALUES ('".$name."' , '".$login."', '".$shortname."',  '".$page."',  '".$editor."')";
	}

	mysqli_query($db,$sql);
	$newid = mysqli_insert_id($db);
}



if (mysqli_affected_rows($db)!=1) {
	echo "Bei Speichern ist ein Fehler aufgetreten: \n";
	echo "mysqli_affected_rows()".mysqli_affected_rows($db);
	echo mysqli_error($db);
	echo $sql;
	die();
}

echo $newid;


?>
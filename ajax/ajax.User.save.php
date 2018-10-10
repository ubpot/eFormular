<? 
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT" ); 
header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" ); 
header("Cache-Control: no-cache, must-revalidate" ); 
header("Pragma: no-cache" );
header("Content-Type: text/xml; charset=UTF-8");

require('../connectDB.php');


$userid = $_POST['userid'];
$page= $_POST[page];
$name= $_POST[name];
$shortname= $_POST[shortname];
$login= $_POST[login];
$passwd= $_POST[passwd];
$editor= $_POST[editor];

//if ($dataid != "") {
//	$sql = " UPDATE Formdata SET json='".$json."', title='".$title."' , json='".$json."' where id=".$dataid;
//} else {

if ($userid != "") {
	if ($passwd) {
		$sql = " UPDATE User SET name='".$name."' , login='".$login."' , passwd='".$passwd."', page='".$page."', shortname='".$shortname."' , editor='".$editor."' where id=".$userid;
	} else {
		$sql = " UPDATE User SET name='".$name."' , login='".$login."' , page='".$page."' , shortname='".$shortname."' , editor='".$editor."' where id=".$userid;
	}
	mysql_query($sql);
	$newid = $userid;
} else {
	if ($passwd) {
		$sql = " INSERT INTO User (name,login,shortname,passwd,page,editor) VALUES ('".$name."' , '".$login."', '".$shortname."', '".$passwd."' , '".$page."',  '".$editor."')";
	} else {
		$sql = " INSERT INTO User (name,login,shortname,page,editor) VALUES ('".$name."' , '".$login."', '".$shortname."',  '".$page."',  '".$editor."')";
	}
	
	mysql_query($sql);
	$newid = mysql_insert_id();
}



if (mysql_affected_rows()!=1) {
	echo "Bei Speichern ist ein Fehler aufgetreten: \n";
	echo "mysql_affected_rows()".mysql_affected_rows();
	echo mysql_error();
	die();
}
	
echo $newid;


?>
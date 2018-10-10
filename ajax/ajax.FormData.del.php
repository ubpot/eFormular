<? 
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT" ); 
header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" ); 
header("Cache-Control: no-cache, must-revalidate" ); 
header("Pragma: no-cache" );
header("Content-Type: text/xml; charset=iso-8859-1");

require('../connectDB.php');

function delForm($Formdataid){
	$sql = " Select id_Folder from Formdata  where id=".$Formdataid ;
	//echo $sql;
	$result = mysql_query($sql);
	echo mysql_error();
	$row = mysql_fetch_assoc($result);
	$Folderid = $row['id_Folder'];
	
	while ($Formdataid != "") {
		$sql = " Select prevVersion,id_Folder "
				." from Formdata "
				." where id=".$Formdataid ;
		//echo $sql;
		$result = mysql_query($sql);
		echo mysql_error();
		$row = mysql_fetch_assoc($result);
		$previd=$row['prevVersion'];
	
		$sql = " DELETE FROM Formvalues where id_Formdata=".$Formdataid;
		mysql_query($sql);
		echo mysql_error();
		
		$sql = " DELETE FROM Watchlist where id_FormData=".$Formdataid;
		mysql_query($sql);
		echo mysql_error();
	
		$sql = " DELETE FROM Formdata where id=".$Formdataid;
		mysql_query($sql);
		echo mysql_error();
		 
		$Formdataid = $previd;
	}
	
	if ($Folderid) {
		$sql = " Select count(*) as Count from Folder,Formdata  where Folder.id=Formdata.id_Folder AND Folder.id=".$Folderid;
		//echo $sql;
		$result = mysql_query($sql);
		echo mysql_error();
		$row = mysql_fetch_assoc($result);
		
		if ($row['Count'] == 0) {
			$sql = " DELETE FROM Folder where id=".$Folderid;
			mysql_query($sql);
			echo mysql_error();
		}
	}
	return $Folderid ;
}

$formdataid = $_GET['formdataid']; 

if ($formdataid == "") {
	echo "Fehlender Parameter.";
	die();
}

$Folderid = delForm($formdataid);


echo $Folderid;
?>
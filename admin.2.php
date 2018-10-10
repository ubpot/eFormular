<?
header('content-type: text/html; charset=utf-8');
session_set_cookie_params(20000);

session_start();
require('connectDB.php');

// Module laden
$Moduledir="admin/";

$MODULS = array();
include($Moduledir."admin.FormTmpl.php");
include($Moduledir."admin.Searchstring.php");
include($Moduledir."admin.User.php");
include($Moduledir."admin.Tray.php");
include($Moduledir."admin.Blocklist.php");
include($Moduledir."admin.Mail.php");


if ($_GET['logout']=="true") {
	$_SESSION['userid']="";
	$_SESSION['username']="";
	session_destroy();
}

if ($_POST['login']) {
	$_SESSION['userid'] = "";
	$sql = "SELECT id,passwd,name,role FROM User WHERE login='".$_POST['login']."'";
	$result = mysql_query($sql);
	$row = mysql_fetch_assoc($result);
	if ($row) {
		if ($_POST['passwd']==$row['passwd']) {
			$_SESSION['userid']=$row['id'];
			$_SESSION['username']=$row['name'];
			$_SESSION['role']=$row['role'];
		} else {
			$LoginError = "Falsches Passwort";
		}
	} else {
		$LoginError = "Loginname nicht gefunden.";
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>eFormular - UB Potsdam</title>
    <script src="JSON-parser/json.js" type="text/javascript"> </script>
    
    <script src="codemirror/js/codemirror.js" type="text/javascript"></script>
    <script src="jquery-1.7.1.js" type="text/javascript"> </script>
    
    <link href="main.2.css" rel="stylesheet" type="text/css" />-
    
    <script type="text/javascript" src="admin.js"> </script>
<?php
	for ($i=0; $i < count ($MODULS); $i++) {
?>		 
		<script type="text/javascript" src="<?php echo $Moduledir.$MODULS[$i][javascript]; ?>"> </script> 
<?php 
	}
			
?>   

	<script language="javascript">
        var USER = "<? echo $_SESSION['username'];?>"; 
    </script> 



</head>

<body>
<? 
if (! $_SESSION['userid']) {
?>
	<div class="login">
    	<img src="img/Logo_eForm.png" />
         <h1> Adminbereich </h1>
        <p style="color:#F00"> <? echo $LoginError; ?> </p>
    	<form method="post" action="<? $_SERVER['PHP_SELF'] ?>">
            <table>
                <tr> <td> Login:    </td> <td> <input name="login"  /> </td> </tr>
                <tr> <td> Password: </td> <td> <input  type="password" name="passwd" /> </td> </tr>
            </table>
            <input type="submit" value="Login" />
        </form>
    </div>
<?
} else if ($_SESSION['role'] == "") {
?>
	<div class="eF_Head">
    	<img  src="img/Logo_eForm.png" />
        <div class="ef_Head_r">
        <b> Login: </b> 
        <? echo $_SESSION['username'];?> <br  />
        <a href="<? $_SERVER['PHP_SELF'] ?>?logout=true"> Abmelden </a> <br /> <br />
        <a href="index.2.php"> Formularverwaltung </a> 
        </div>
        <h1> Adminbereich </h1>
    </div>
     <h1 style="color:#F00"> Nur Administratoren dürfen die Funktionen des Adminbereichs nutzen.  </h1>
<?
} else {
?>
	<div class="eF_Head">
    	<img  src="img/Logo_eForm.png" />
        <div class="ef_Head_r">
        <b> Login: </b> 
        <? echo $_SESSION['username'];?> <br  />
        <a href="<? $_SERVER['PHP_SELF'] ?>?logout=true"> Abmelden </a> <br /> <br />
        <a href="index.2.php"> Formularverwaltung </a> 
        </div>
        <h1> Adminbereich </h1>
    </div>
   
	<div class="leftMenue">
    
<?php
			for ($i=0; $i < count ($MODULS); $i++) {
				eval ($MODULS[$i][leftmenue].";");
			}
			
?>       
	</div>

    <div class="wrap">
    	<div > 
<?php
			for ($i=0; $i < count ($MODULS); $i++) {
				eval ($MODULS[$i][topmenue].";");
			}
			
?>
        </div>
        
<?php
			for ($i=0; $i < count ($MODULS); $i++) {
				eval ($MODULS[$i][content].";");
			}
			//$MODULSinclude("admin.FormTmpl.php");
?>      
        
    </div>
 
    <div id="popup" class="popup">
    </div>
<?
} 
?>    
		
</body>
</html>
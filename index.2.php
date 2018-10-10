<?
header('content-type: text/html; charset=utf-8');
session_set_cookie_params(20000);
session_start();
require('connectDB.php');
require_once('htmlMakros.php');

if ($_GET['logout']=="true") {
	$sql = "UPDATE Formdata SET block_begin=null,block_id_User = null where block_id_User=".$_SESSION['userid'];
	$result = mysql_query($sql);
	mysql_error();
	
	$_SESSION['userid']="";
	$_SESSION['username']="";
	session_destroy();
}

if ($_POST['login']) {
	$_SESSION['userid'] = "";
	$sql = "SELECT id,passwd,name,page,shortname,role FROM User WHERE login='".$_POST['login']."'";
	$result = mysql_query($sql);
	$row = mysql_fetch_assoc($result);
	if ($row) {
		if ($_POST['passwd']==$row['passwd']) {
			$_SESSION['userid']=$row['id'];
			$_SESSION['username']=$row['name'];
			$_SESSION['shortname']=$row['shortname'];
			$_SESSION['role']=$row['role'];
		} else {
			$LoginError = "Falsches Passwort";
		}
		$User_Page = $row['page'];
	} else {
		$LoginError = "Loginname nicht gefunden.";
	}
}

if ($_GET['loadFolderId']) {
	$sql = "SELECT id,id_Form from Formdata where nextVersion is null AND id_Folder=".$_GET['loadFolderId'];
	$result = mysql_query($sql);
	$row= mysql_fetch_assoc($result) ;
	if (mysql_affected_rows()>0) {
		$loadFormId = $row['id_Form'];
		$loadFormDataId = $row['id'];
	}
}
if ($_GET['loadFormId']) $loadFormId = $loadFormId;
$countDivWatchlist = 0;

if ($_GET['loadFormDataId']) {
	$loadFormDataId = $loadFormDataId;
	
	if ($_GET['watchlistlink']==1) {
		$sql = "Select id,nextVersion,id_Form from Formdata where id=".$loadFormDataId;
		$result = mysql_query($sql);
		$row= mysql_fetch_assoc($result) ;
		while ($row['nextVersion']!= "") {
			$loadFormDataId = $row['nextVersion'];
			$sql = "Select id,nextVersion,id_Form from Formdata where id=".$loadFormDataId;
			$result = mysql_query($sql);
			$row= mysql_fetch_assoc($result) ;
			$countDivWatchlist++;
		}
	}
}

if ($loadFormId) {
	$sql = "SELECT id, html from Formular where id=".$loadFormId;
	$result = mysql_query($sql);
	$FORMULARTMPL= mysql_fetch_assoc($result) ;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
<title>eFormular - UB Potsdam</title>
<? if ($_GET['print']) { ?>
	<link href="print.css" rel="stylesheet" type="text/css" />
<? } else { ?>
	<link href="main.2.css" rel="stylesheet" type="text/css" />
<? } ?>
<script type="text/javascript" src="JSON-parser/json.js"> </script>
<script language="javascript" src="main.2.js" /> </script>
<script language="javascript" src="workflow.js" /> </script>
<script language="javascript" src="eFormAPI.js" /> </script>

<!-- calendar stylesheet -->
<link rel="stylesheet" type="text/css" media="all" href="jscalendar-1.0/calendar-win2k-cold-1.css" title="win2k-cold-1" />
<!-- main calendar program -->
<script type="text/javascript" src="jscalendar-1.0/calendar.js"></script>
<!-- language for the calendar -->
<script type="text/javascript" src="jscalendar-1.0/lang/calendar-de.js"></script>
<!-- the following script defines the Calendar.setup helper function, which makes
       	adding a calendar a matter of 1 or 2 lines of code. -->
<script type="text/javascript" src="jscalendar-1.0/calendar-setup.js"></script>

</head>

<body onload="onload_Form(<? if ($loadFormId) echo $loadFormId; else echo "''"; ?>,<? if ($loadFormDataId) echo $loadFormDataId;  else echo "''"; ?> ,  
													 <? echo $countDivWatchlist ?>,<? if ($loadFolderId) echo $loadFolderId; else echo "''"; ?>);print_Watchlist();">

<?
if (! $_SESSION['userid']) {
?>
	<div class="login">
    	<img src="img/Logo_eForm.png" />
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
} else {
?>
	<div class="eF_Head">

    	<div class="ef_Head_r">
        <b> Login: </b>
        <? echo $_SESSION['username'];?> <br  />
        <script language="javascript">
			var USER = "<? echo $_SESSION['username'];?>";
			var USER_ID = "<? echo $_SESSION['userid'];?>";
			var SHORTNAME = "<? echo $_SESSION['shortname'];?>";
		</script>
        <a href="<? $_SERVER['PHP_SELF'] ?>?logout=true"> Abmelden </a> <br /> <br />
        <a href="admin.2.php"> Adminbereich </a>
        </div>
        <img  src="img/Logo_eForm.png" />


    </div>

<div class="leftMenue">
        <div style="padding-left:10px;padding-top:10px">
		<form action="" onSubmit="onclick_search(); return false;">
            	<input style="width:200px" id="searchString"/> 
                <br /> 
                <input style="margin-left:140px" type="button" onclick="onclick_search()" value="Suche" />
		</form>
            <ul class="Menulist">

                <li > <a href="javascript: void(0)" onClick="onClick_popup_Searchstring();" class="ef_Link"> vordefinierte Suchen </a> </li>

                <li > <a href="javascript: void(0)" onclick="onClick_Trays();" class="ef_Link"> Ablagen </a> </li>
                <li > <a href="javascript: void(0)" onclick="onClick_Folders();" class="ef_Link"> Ordner </a> </li>
                <li > <a href="javascript: void(0)" onclick="onClick_listFormData_akt()" class="ef_Link"> Gesamtliste </a> </li>
            </ul>
        </div>

        <div class="leftMenue_heading" > Merkliste: </div>
        <div id="watchlist" class="watchlist">
        	<p style="padding:10px">
	        	Bitte eine Suche ausf&uuml;hren oder Ablage &ouml;ffnen.
            </p>
        </div>

    </div>
    <div class="wrap">
    	<div class="topMenue">
        	<div class="buttons">
	        	<input type="button" onClick="onClick_popup_newForm();" value="Neues Formular">
                <button id="ef_button_saveFormData2" onClick="saveFormData(MyEFolderId);" <? if (! $loadFormId) echo 'disabled="disabled"';?> > Formular speichern </button>
		       <input id="ef_button_saveFormData" type="button" onClick="onClick_popup_saveFormData();" value="Formular speichern unter..."
			   							<? if (! $loadFormId) echo 'disabled="disabled"';?> >
                <button id="ef_button_addToWatchlist" onClick="onClick_addToWatchlist();" <? if (! $loadFormId) echo 'disabled="disabled"';?> > Formular in die Merkliste </button>
                
                <button id="ef_button_delFormData" onClick="onClick_delFormData();" <? if (! $loadFormId) echo 'disabled="disabled"';?> > Formular l&ouml;schen </button>
                <button id="ef_button_delFolder" onClick="onClick_delFolder();" <? if (! $loadFormId) echo 'disabled="disabled"';?> > Ordner l&ouml;schen </button>
                <button id="ef_button_Print" onClick="window.open('?loadFormId=<? echo $loadFormId; ?>&loadFormDataId=<? echo $loadFormDataId; ?>&print=true','_new')" 
						<? if (! $loadFormId) echo 'disabled="disabled"';?> > Drucken </button>



            </div>
            <div id="ef_Folder" class="ef_Folder">

            	<b> Ordnertitel: </b> <span id="eF_Foldertitle"> / </span>
                <div id="eF_FolderFormList" class="eF_FolderFormList"> </div>
            </div>
            <div id="ef_FormularHead" class="ef_FormularHead">
            <script language="javascript">
<?		   	if ($loadFormId || $loadFolderId) {	?>
      				document.getElementById("ef_FormularHead").style.display="block";
<?		   	} else { 				?>
				document.getElementById("ef_FormularHead").style.display="none";

<?		   	} 	 				?>

            </script>

                <div style="float:left; height:70px;">
                    <table>
                        <tr>
                            <td> <b> Bearbeiter:</b> </td> <td> <span id="eF_Editor"> </span> </td>
                        </tr>
                        <tr>
                            <td> <b> Titel: </b> </td> <td> <input id="eF_Title"/> </td>

                        </tr>
                    </table>
                </div>
                <div style="float:right;position:relative">
                    <table>
                        
                        <tr>
                            <td> <b> Ablage:</b> </td>
                            <td>
                            	<select id='eF_Tray'>
                                	<option  value="" selected="selected"> ------- </option>
<?
									$sql = "SELECT id,name FROM Tray ";
									$result = mysql_query($sql);
									while ($row = mysql_fetch_assoc($result)) {
										echo "<option value='".$row['id']."'> ".$row['name']." </option>\n";
									};
?>
								</select>
                            </td>
                        </tr>
                        <tr style="text-align:right">
                        	<td> </td>
                        	<td onclick="document.getElementById('eF_div_Hinttext').style.display='block';"> Bemerkungen  <br /> &nbsp;
                            
                           
                            </td>
                        </tr>

                    </table>
                     <div  id="eF_div_Hinttext" >
                     	<div style="float:right">
                     	<img src="img/button_del.png" onClick="document.getElementById('eF_div_Hinttext').style.display='none';" /><br />
                        </div>
                   		<textarea id="eF_Hinttext" cols="33" rows="7" >  </textarea>
                     </div>
                </div>
                <div style="text-align:center;margin-top:5px;">
                	<div style="margin-bottom: 5px;">
                        <b> Status: </b>
                        <select id='eF_Status'>
                            <option value="unerledigt" selected='selected'> unerledigt </option> <option value="erledigt"> erledigt </option>
                        </select> 
                    </div>
                    <b> Version:  </b> <br />
                    <a id="eF_prevVersion" href="javascript:void(0);"> 	&larr;  </a> &nbsp;
                    <span id="eF_Version"> </span> <!--<input id="eF_Version" size="3" disabled="disabled"/>--> &nbsp;
                    <a id="eF_nextVersion" href="javascript:void(0);"> 	&rarr; </a>
                </div>
            </div>
        </div>
        <div id="ef_Formular" class="ef_Formular"  <? if ($loadFormId || $loadFolderId) echo ('style="display:block"') ?> >
<?
		if ($loadFormId) {
			echo  replaceMakros($FORMULARTMPL['html']);

		}
?>

        </div>

        <div id="ef_Searchresult" style="display:none" class="main">
        	<h2> Suchergebnisse: </h2>
            <div style=" margin-left:100px;text-align:center; margin-bottom:5px; border:solid thin black; width:670px; padding:5px; ">
            	<table>
                	<tr> 
                    	<td> <b> Auswahl:</b> </td>
                    	<td>
                            <input id="ef_radio_search_onlyoutstanding_1" type="radio" name="ef_radio_search_onlyoutstanding" 
                                    value="1" checked="checked"  onchange="onchange_searchparam()"/> Unerledigte Formulare
                            <input id="ef_radio_search_onlyoutstanding_2" type="radio" name="ef_radio_search_onlyoutstanding" 
                                    value="0"  onchange="onchange_searchparam()"/> Alle Formulare
						</td>
        		
                	</tr>
                    <tr>
		            	<td> <b> Sortierung:  </b> </td>
                		<td>
                            <input id="ef_radio_search_sort_1" type="radio" name="ef_radio_search_sort" 
                                    value="1" checked="checked"  onchange="onchange_searchparam()"/> nach Titel
                            <input id="ef_radio_search_sort_2" type="radio" name="ef_radio_search_sort" 
                                    value="0"  onchange="onchange_searchparam()"/> nach Datum absteigend
                            <input id="ef_radio_search_sort_3" type="radio" name="ef_radio_search_sort" 
                                    value="2"  onchange="onchange_searchparam()"/> nach Datum aufsteigend
                        </td>
                    </tr>
                </table>
        	</div>
            <div id="ef_Searchresultlist" class="Searchresultlist">
            </div>
        </div>

        <div id="main" class="main" <? if ($loadFormId || $loadFolderId) echo ('style="display:none"') ?>>
<?
			if ($User_Page != "") {
				echo $User_Page;
			} else {
?>
        	<h2> Herzlich Willkommen bei eFormular</h2>
            <p>
            	eFormular ist ein System zum Erstellen und Verwalten von elektronischen Formularen.
                Eine Besonderheit ist die Workflowkomponente, die eine besonders einfache effiziente M&ouml;glichkeit zum
                Erstellen von Workflow Formularen bietet.
            </p>
            <h3> Einf&uuml;hrung </h3>
		  <p>
          	 	Um die Arbeitsweise mit den Formularen kennenzulernen, sollte man sich die Beispielformulare ansehen.
             	Ein Formular kann durch den Klick auf den Button "Neues Formular" erstellt werden. Nach dem Ausf&uuml;llen
             	muss das Formular abgespeichert werden. Um ein abgespeichertes Formular zu finden kannman danach suchen
              	oder man l&auml;sst sich die zuletzt bearbeiteten anzeigen. <br />
              	Es gibt folgende Beispielformulare:
              	<ul>
                        <li> Beispiel 1  - Erkl&auml;rung </li>
                        <li> Beispiel 2  - Erkl&auml;rung </li>
                        <li> Beispiel 3  - Erkl&auml;rung </li>
              </ul>
          </p>
<?
		}
?>

      </div>
    </div>
    <div id="ef_popup_newTmpl" class="ef_popup">
    	<h3> Bitte Formulartyp ausw&auml;hlen </h3>
        <div id="ef_popup_ForTmplList"  class="ef_popup_Select">
        </div>
        <button style="margin-left:200px;" onclick="onClick_newForm()"> Formular erstellen </button>
        <button onclick="document.getElementById('ef_popup_newTmpl').style.visibility='hidden';"> Abbrechen </button>

    </div>
    <div id="ef_popup_Searchstring" class="ef_popup">
    	<h3> Bitte vordefiniere Suche ausw&auml;hlen </h3>
        <div id="ef_popup_ForSearchstring"  class="ef_popup_Select">
        </div>
        <button style="margin-left:200px;" onclick="onClick_startSearch()"> Suche starten </button>
        <button onclick="document.getElementById('ef_popup_Searchstring').style.visibility='hidden';"> Abbrechen </button>
    </div>
    <div id="ef_popup_Trays"  class="ef_popup">
        <h2> Ablagen: </h2>
        <div  id="ef_popup_Trays_TrayList" class="ef_popup_Select"><select size=2>
<?
                $sql = "SELECT id,name FROM Tray ORDER BY name ";
                    $result = mysql_query($sql);
                    while ($row = mysql_fetch_assoc($result)) {
                        echo "<option value='".$row['id']."'> ".$row['name']." </option>\n";
                };
?>
            </select >
        </div>


	<button style="margin-left:200px;" onclick="onClick_load_tray()"> Ablage auflisten </button>
	<button onclick="document.getElementById('ef_popup_Trays').style.visibility='hidden';"> Abbrechen </button>
    </div>

	<div id="ef_popup_Folders"  class="ef_popup">
        <h2> Ordner: </h2>
        <div  id="ef_popup_Folders_FolderList" class="ef_popup_Select">
        	
        </div>
        <div style=" width:100%;text-align:center; margin-bottom:5px;">
        <input type="radio" name="ef_radio_onlyoutstanding2" value="1" checked="checked"  onchange="onchange_onlyoutstanding(this)"/> Unerledigte und leere Ordner
        <input type="radio" name="ef_radio_onlyoutstanding2" value="0"  onchange="onchange_onlyoutstanding(this)"/> Alle Ordner
        </div>


	<button style="margin-left:200px;" onclick="onClick_open_Folder()"> Ordner öffnen  </button>
	<button onclick="document.getElementById('ef_popup_Folders').style.visibility='hidden';"> Abbrechen </button>
    </div>

    <div id="ef_popup_saveFormData" class="ef_popup">
    	<h3>   Formular speichern </h3>

        <div style="margin-bottom:0px;" id="ef_popup_SaveFormData_FolderList"  class="ef_popup_Select">
        </div>
        <div style=" width:100%;text-align:center; margin-bottom:5px;">
        <input type="radio" name="ef_radio_onlyoutstanding" value="1" checked="checked"  onchange="onchange_onlyoutstanding(this)"/> Unerledigte und leere Ordner
        <input type="radio" name="ef_radio_onlyoutstanding" value="0"  onchange="onchange_onlyoutstanding(this)"/> Alle Ordner
        </div>
        
        <button onclick="onClick_newFolder();"> neuer Ordner</button>
        <button style="margin-right:1px;" onclick="onClick_renameFolder();"> Ordner umbenennen </button>

        <button onclick="saveFormDataFolder()"> Speichern </button>
        <button onclick="document.getElementById('ef_popup_saveFormData').style.visibility='hidden';"> Abbrechen </button>


    </div> 

<?
}
?>
</body>
</html>

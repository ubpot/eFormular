<?php
$i = count($MODULS);

$MODULS[$i][leftmenue] = "eF_admin_Tray_leftMenue ()";
$MODULS[$i][topmenue] = "eF_admin_Tray_topMenue ()";
$MODULS[$i][content] = "eF_admin_Tray_content ()";
$MODULS[$i][javascript] = "admin.Tray.js";


function eF_admin_Tray_leftMenue () {
?>	
		<div class="leftMenue_heading" onclick="onClick_Traylist(); "> Ablagenverwaltung </div>
        <div id="ef_Traylist" class="ef_Formlist"> </div>
<?php
}

function eF_admin_Tray_topMenue () {
?>	
			<div id="eF_MenueTray" class="topMenue" style="display:none">
             	<div class="buttons">
             	 	<input type="button" onClick="newTray();" value="neue Ablage">  
                	<input type="button" onClick="saveTray();" value="Ablage speichern"> 
                    <input type="button" onClick="delTray();" value="Ablage löschen">
                </div>
                <div id="ef_FormularHead" class="ef_FormularHead">
                	<div style="position:absolute">
                        <table>
                            <tr> 
                                <td> <b> Bearbeiter:</b> </td> <td> <span id="eF_Editor_Tray"> </span> </td>
                            </tr>
                            <tr> 
                                <td> <b> geändert am:</b> </td> <td> <span id="eF_Timestamp_Tray"> </span> </td>
                            </tr>
                        </table>
                    </div>  
                </div>
             </div>
<?php           
}

function eF_admin_Tray_content () {
?>
		<div id="eF_div_Tray" class="main" style="display:none">                                     
           	<table>
            	<tr> 
                	<td> <b> Name: </b> </td> <td> <input id="ef_Trayname" /> </td>
                </tr>
            </table>
                 
      	</div>
<?php
}
?>
<?php

$i = count($MODULS);

$MODULS[$i][leftmenue] = "eF_admin_Searchstring_leftMenue ()";
$MODULS[$i][topmenue] = "eF_admin_Searchstring_topMenue ()";
$MODULS[$i][content] = "eF_admin_Searchstring_content ()"; 
$MODULS[$i][javascript] = "admin.Searchstring.js";


function eF_admin_Searchstring_leftMenue () {
?>	
		<div class="leftMenue_heading" onclick="onClick_adm_getSStringList () ;"> definierte Suchen: </div>
        <div id="ef_SStringlist" class="ef_Formlist">   </div>
<?php
}

function eF_admin_Searchstring_topMenue () {
?>
			<div id="eF_MenueSearchstring" class="topMenue" style="display:none">
             	<div class="buttons">
             	 	<input type="button" onClick="newSearchString();" value="neuer Suchstring">  
                	<input type="button" onClick="saveSearchString();" value="Suchstring speichern"> 
                    <input type="button" onClick="delSearchString();" value="Suchstring löschen"> 
                </div>
                <div id="ef_FormularHead" class="ef_FormularHead">
                	<div style="position:absolute">
                        <table>
                            <tr> 
                                <td> <b> Bearbeiter:</b> </td> <td> <span id="eF_Editor_Searchstring"> </span> </td>
                                <td> <b> geändert am:</b> </td> <td> <span id="eF_Timestamp_Searchstring"> </span> </td>
                            </tr>
                            <tr>
                                <td> <b> Titel: </b> </td> <td> <input id="eF_Title_Searchstring" value=""/> </td>
                                <td> </td>
                            </tr>
                        </table>
                    </div>  
                    
                   
                     
                    
                    
                </div>
             	
                
             </div>
<?php
}

function eF_admin_Searchstring_content () {
?>
		<div id="eF_div_Searchstring" class="main" style="display:none">                                     
            <input id="eF_Searchstring"  size="150"  />
            <h3> Zeitmakros:</h3>
            <ul>
            	<li> <b> %EF_NOW%  </b>  - das aktuelle Datum (YYYY-mm-dd) </li>
            	<li> <b> %EF_NOW+1WEEK% </b> - das Datum in sieben Tagen (YYYY-mm-dd) </li>                
               	<li> <b> %EF_NOW+1MONTH% </b> - das Datum in 30 Tagen (YYYY-mm-dd) </li>
            </ul>
      	</div>
<?php	
}

?>
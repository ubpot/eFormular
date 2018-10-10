<?php
$i = count($MODULS);

$MODULS[$i][leftmenue] = "eF_admin_User_leftMenue ()";
$MODULS[$i][topmenue] = "eF_admin_User_topMenue ()";
$MODULS[$i][content] = "eF_admin_User_content ()";
$MODULS[$i][javascript] = "admin.User.js";


function eF_admin_User_leftMenue () {
?>	
		<div class="leftMenue_heading" onclick="onClick_Userlist() ;"> Userverwaltung </div>
        <div id="ef_Userlist" class="ef_Formlist"> </div>
<?php
}

function eF_admin_User_topMenue () {
?>	
			<div id="eF_MenueUser" class="topMenue" style="display:none">
             	<div class="buttons">
             	 	<!-- <input type="button" onClick="newSearchString();" value="neuer Suchstring">  -->
                	<input type="button" onClick="newUser();" value="neuer User"> 
                    <input type="button" onClick="saveUser();" value="User speichern"> 
                    <input type="button" onClick="delUser();" value="User löschen"> 
                </div>
                <div id="ef_FormularHead" class="ef_FormularHead">
                	<div style="position:absolute">
                        <table>
                            <tr> 
                                <td> <b> Bearbeiter:</b> </td> <td> <span id="eF_Editor_User"> </span> </td>
                            </tr>
                            <tr> 
                                <td> <b> geändert am:</b> </td> <td> <span id="eF_Timestamp_User"> </span> </td>
                            </tr>
                        </table>
                    </div>  
                </div>
             </div>
<?php           
}

function eF_admin_User_content () {
?>
		<div id="eF_div_User" class="main" style="display:none">                                     
           	<table>
            	<tr> 
                	<td> <b> Name: </b> </td> <td> <input id="ef_Username" /> </td>
                </tr>
                <tr> 
                	<td> <b> Login: </b> </td> <td> <input id="ef_Userlogin" /> </td>
                </tr>
                <tr> 
                	<td> <b> Namenskürzel: </b> </td> <td> <input id="ef_Shortname" /> </td>
                </tr>
                <tr> 
                	<td> <b> Passwort: </b> </td> <td> <input id="ef_Passwd"  type="password"/> </td>
                </tr>
                <tr> 
                	<td> <b> Passwort: (wiederholen) </b> </td> <td> <input id="ef_Passwd2" type="password" /> </td>
                </tr>
                <tr> 
                	<td style="vertical-align: top;" > <b> Startseite: </b> </td> 
                    <td>  <div style="border:solid thin black"> <textarea id="eF_Userpage" name="eF_Userpage"  cols="100" rows="30"></textarea> </div> </td>
                </tr>
            </table>
         
            
            <script type="text/javascript">
			  	var editorpage = CodeMirror.fromTextArea('eF_Userpage', {
					height: "250px", width:"500px",
					parserfile: ["parsexml.js", "parsecss.js", "tokenizejavascript.js", "parsejavascript.js", "parsehtmlmixed.js"],
					stylesheet: ["codemirror/css/xmlcolors.css", "codemirror/css/jscolors.css", "codemirror/css/csscolors.css"],
					path: "codemirror/js/"
			  	});
			</script>  
      	</div>
<?php
}
?>
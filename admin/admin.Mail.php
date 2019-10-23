<?php
$i = count($MODULS);

$MODULS[$i]['leftmenue'] = "eF_admin_Mail_leftMenue ()";
$MODULS[$i]['topmenue'] = "eF_admin_Mail_topMenue ()";
$MODULS[$i]['content'] = "eF_admin_Mail_content ()";
$MODULS[$i]['javascript'] = "admin.Mail.js";


function eF_admin_Mail_leftMenue () {
?>
		<div class="leftMenue_heading" onclick="onClick_Maillist(); "> Mailvorlagen </div>
        <div id="ef_Maillist" class="ef_Formlist"> </div>
<?php
}

function eF_admin_Mail_topMenue () {
?>
			<div id="eF_MenueMail" class="topMenue" style="display:none">
             	<div class="buttons">
             	 	<input type="button" onClick="newMail();" value="neue Mailvorlage">
                	<input type="button" onClick="saveMail();" value="Mailvorlage speichern">
                    <input type="button" onClick="delMail();" value="Mailvorlage löschen">
                </div>
                <div id="ef_FormularHead" class="ef_FormularHead">
                	<div style="position:absolute">
                        <table>
                            <tr>
                                <td> <b> Bearbeiter:</b> </td> <td> <span id="eF_Editor_Mail"> </span> </td>
                            </tr>
                            <tr>
                                <td> <b> geändert am:</b> </td> <td> <span id="eF_Timestamp_Mail"> </span> </td>
                            </tr>
                        </table>
                    </div>
                </div>
             </div>
<?php
}

function eF_admin_Mail_content () {
?>
		<div id="eF_div_Mail" class="main" style="display:none">
        	<h2> noch nicht freigeschaltet </h2>
           	<table>
            	<tr>
                	<td> <b> Name: </b> </td> <td> <input id="ef_Mailname" /> </td>
                </tr>
            	<tr>
                	<td> <b> Parameter: </b> </td> <td> <input id="ef_Params" /> </td>
                </tr>
                <tr>
                	<td style="vertical-align: top;" > <b> Mailtext: </b> </td>
                    <td>  <div style="border:solid thin black"> <textarea id="eF_Mailtext" name="eF_Mailtext"  cols="100" rows="30"></textarea> </div> </td>
                </tr>
            </table>

            <script type="text/javascript">
			  	var editorpage = CodeMirror.fromTextArea('eF_Mailtext', {
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
<?php

$i = count($MODULS);

$MODULS[$i]['leftmenue'] = "eF_admin_FormTmpl_leftMenue ()";
$MODULS[$i]['topmenue'] = "eF_admin_FormTmpl_topMenue ()";
$MODULS[$i]['content'] = "eF_admin_FormTmpl_content ()";
$MODULS[$i]['javascript'] = "admin.FormTmpl.js";

function eF_admin_FormTmpl_leftMenue () {
?>
		<div class="leftMenue_heading" onclick="onClick_adm_getFormTmplList () ;"> Formulartemplates: </div>
        <div id="ef_Formlist" class="ef_Formlist">  </div>
<?php
}


function eF_admin_FormTmpl_topMenue () {
?>
			<div id="eF_MenueForm" class="topMenue" style="display:none">
            	<div class="buttons">
                    <input type="button" onClick="onClick_newFormTmpl();" value="Neues Formulartemplate">
                    <input id ="ef_button_saveFormTmpl" type="button" onClick="saveFormTmpl();" value="Formulartemplate speichern">
                    <input id ="ef_button_hideFormTmpl" type="button" onClick="hideFormTmpl();" value="Formulartemplate verstecken">
                </div>
                <div id="ef_FormularHead" class="ef_FormularHead">
                	<div style="position:absolute">
                        <table>
                            <tr>
                                <td> <b> Bearbeiter:</b> </td> <td> <span id="eF_Editor"> </span> </td>
                            </tr>
                            <tr>
                                <td> <b> Titel: </b> </td> <td> <input id="eF_Title" value=""/> </td>

                            </tr>
                        </table>
                    </div>


                     <script language="javascript">
                        var USER = "<?php echo $_SESSION['username'];?>";
                    </script>
                    <div style="text-align:center;margin-top:15px;">
                        <b> Version:  </b> <br />
                        <a id="eF_prevVersion" href="javascript:void(0);"> 	&larr;  </a> &nbsp;
                        <span id="eF_Version"> 0 </span> <!--<input id="eF_Version" size="3" disabled="disabled"/>--> &nbsp;
                        <a id="eF_nextVersion" href="javascript:void(0);"> 	&rarr; </a>
                	</div>

                </div>
           	</div>
<?php
}

function eF_admin_FormTmpl_content () {
?>
		<div id="ef_div_HTMLText" class="main" style="border: 1px solid black; padding: 3px; margin-top:15px;display:none;" >

            <textarea id="eF_HTMLText" name="eF_HTMLText"  cols="100" rows="30">

            </textarea>

            <script type="text/javascript">
			  	var editor = CodeMirror.fromTextArea('eF_HTMLText', {
					height: "350px",
					parserfile: ["parsexml.js", "parsecss.js", "tokenizejavascript.js", "parsejavascript.js", "parsehtmlmixed.js"],
					stylesheet: ["codemirror/css/xmlcolors.css", "codemirror/css/jscolors.css", "codemirror/css/csscolors.css"],
					path: "codemirror/js/"
			  	});
			</script>


        </div>
<?php
}
?>

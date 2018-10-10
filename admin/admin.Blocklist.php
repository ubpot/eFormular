<?php
$i = count($MODULS);

$MODULS[$i][leftmenue] = "eF_admin_Blocklist_leftMenue ()";
$MODULS[$i][topmenue] = "eF_admin_Blocklist_topMenue ()";
$MODULS[$i][content] = "eF_admin_Blocklist_content ()";
$MODULS[$i][javascript] = "admin.Blocklist.js";


function eF_admin_Blocklist_leftMenue () {
?>	
		<div class="leftMenue_heading" onclick="onClick_blockFormList () ;"> Formular entsperren </div>
<?php
}

function eF_admin_Blocklist_topMenue () {
?>	
			
<?php           
}

function eF_admin_Blocklist_content () {
?>
		<div id="eF_div_BlockList" class="main" style="display:none">                                     
           
        </div>
<?php
}
?>
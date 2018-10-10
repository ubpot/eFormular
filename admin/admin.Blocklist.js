function response_unblock_form() {
	if (http_request_Form.readyState == 4) {
   		if (http_request_Form.status == 200) {
			onClick_blockFormList ();
		}
	}
}

function unblock_form(formDataId) {
	http_request_Form = handle_request ();
	http_request_Form.onreadystatechange = response_unblock_form;
   	http_request_Form.open('GET', 'ajax/ajax.FormData.unblock.php?formdataid=' + formDataId , true);
	http_request_Form.send(null);
}

function response_blockFormList () {
	if (http_request_Form.readyState == 4) {
   		if (http_request_Form.status == 200) {
			
			responseText = http_request_Form.responseText.replace(/\n/g,"\\n");
			FormList = responseText.parseJSON();
			//FormList = eval ('(' + http_request_Form.responseText +')');
			
			if (FormList.length == 0 ) {
				HTML ="Keine gesperrten Formulare gefunden.";
			} else {
				HTML ="";
			};
			for (var i = 0; i < FormList.length ; i++ ) { 
				
				if (FormList[i].foldertitle) Folder = ""+FormList[i].foldertitle+"/"; else Folder = "";
				
				HTML+=' <div style="margin-top:10px; margin-bottom:10px;">';
				//HTML+= '<b> <a href="javascript:void(0);" class="ef_Link" onclick="onClick_loadForm(' + FormList[i].formid +',' + FormList[i].formdataid + ');"> '
				HTML+= '<div style="float:left; height: 45px;line-height: 45px; vertical-align:middle; text-align:center;padding-right: 10px; ">';
				HTML+= '   <button type="button" onClick="unblock_form('+ FormList[i].formdataid + ');"> Entsperren </button>'; 
				HTML+= '</div> ';
				//HTML+= '<div style="height:45px;"> <b> <a href="?loadFormId=' + FormList[i].formid + '&loadFormDataId=' + FormList[i].formdataid + '" class="ef_Link" > '
				HTML+= '<div style="height:45px;"> <b> '
				HTML+=	'<a href="javascript:void(0)" onclick="loadForm(' + FormList[i].formid + ',' + FormList[i].formdataid + ')" class="ef_Link" > '
				HTML+=  Folder + FormList[i].title + "</a> </b> "
				HTML+= " - "+ FormList[i].Formulartyptitle  + " <br />";
				HTML+= "<b>" + FormList[i].blocker + " (" + FormList[i].block_begin + ")</b> "
				if (FormList[i].ablage != "") HTML+= "&nbsp; - &nbsp; Ablage: " + FormList[i].ablage + "\n";					
				HTML+="</div> </div>\n";
				
			}
			
			document.getElementById('eF_div_BlockList').innerHTML=HTML;
		} 
	}
}

function onClick_blockFormList () {
	hide_all();
	
	document.getElementById("eF_div_BlockList").style.display="block";
	
	http_request_Form = handle_request ();
	http_request_Form.onreadystatechange = response_blockFormList;
   	http_request_Form.open('GET', 'ajax/ajax.FormData.getList.php?blockList=1' , true);
	http_request_Form.send(null);
}
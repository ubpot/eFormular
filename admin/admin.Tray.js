var MyTrayId = "";

function response_delTray() {
	if (http_request_Form.readyState == 4) {
   		if (http_request_Form.status == 200) {
			if (http_request_Form.responseText == "1") {
					alert ("Ablagedaten wurden gelöscht");
					newTray();
					adm_getTrayList ();
			} else {
				alert ("Beim Löschen ist ein Fehler aufgetreten:" + http_request_Form.responseText+"T");
			}
		}
	}
}

function delTray(){
	http_request_Form = handle_request ();
	http_request_Form.onreadystatechange = response_delTray;
   	http_request_Form.open('GET', 'ajax/ajax.Tray.del.php?trayid='+ MyTrayId, true);
	http_request_Form.send(null);
}

function newTray(){
	MyTrayId="";
	document.getElementById('ef_Trayname').value = "";
}

function response_saveTray() {
	if (http_request_saveForm.readyState == 4) {
   		if (http_request_saveForm.status == 200) {
			if (! isNaN(http_request_saveForm.responseText)) {
				
				trayId = parseInt(http_request_saveForm.responseText);
				
				alert ("Ablagedaten wurden gespeichert");
				onClick_adm_loadTray (trayId);
				
				adm_getTrayList ();
			} else {
				alert (http_request_saveForm.responseText);
			}
		}
	}
}

function saveTray() {
	
	Name = document.getElementById('ef_Trayname').value;
	var params = 'trayid=' + MyTrayId + '&name=' + encodeURIComponent(Name)+ '&editor=' + encodeURIComponent(USER);
	
	http_request_saveForm = handle_request ();
	http_request_saveForm.open('POST', 'ajax/ajax.Tray.save.php', true);
	
	http_request_saveForm.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	http_request_saveForm.setRequestHeader("Content-length", params.length);
	http_request_saveForm.setRequestHeader("Connection", "close");
	
	http_request_saveForm.onreadystatechange = response_saveTray;
   	
	http_request_saveForm.send(params);
}


function response_getTray() {
	if (http_request_Form.readyState == 4) {
   		if (http_request_Form.status == 200) {
			//alert(http_request_Form.responseText);
			responseText = http_request_Form.responseText.replace(/\n/g,"\\n");
			var TrayData=eval ('(' + responseText +')');
			document.getElementById('ef_Trayname').value=TrayData.name;
			document.getElementById('eF_Editor_Tray').innerHTML=TrayData.editor;
			document.getElementById('eF_Timestamp_Tray').innerHTML=TrayData.timestamp;
		} 
	}
}

function onClick_adm_loadTray(trayId) {
	MyTrayId=trayId;
	http_request_Form = handle_request ();
	http_request_Form.onreadystatechange = response_getTray;
   	http_request_Form.open('GET', 'ajax/ajax.Tray.get.php?id=' + trayId , true);
	http_request_Form.send(null);
}

function response_getTrayList () {
	if (http_request_Form.readyState == 4) {
   		if (http_request_Form.status == 200) {
			//FormList=http_request_Menu.responseText.parseJSON();
			TrayList=eval ('(' + http_request_Form.responseText +')');
			HTML ="<ul>";
			
			for (var i = 0; i < TrayList.length ; i++ ) {
				HTML+='<li onclick="onClick_adm_loadTray(' + TrayList[i].id  + ')">' + TrayList[i].name + " </li>\n";
			}
			HTML+="</ul>";
			document.getElementById('ef_Traylist').innerHTML=HTML;
		} 
	}
}

function adm_getTrayList () {
	http_request_Form = handle_request ();
	http_request_Form.onreadystatechange = response_getTrayList;
   	http_request_Form.open('GET', 'ajax/ajax.Tray.getList.php' , true);
	http_request_Form.send(null);
}

function onClick_Traylist() {
	hide_all();
	
	document.getElementById("eF_MenueTray").style.display="block";
	document.getElementById("eF_div_Tray").style.display="block";
	document.getElementById("ef_Traylist").style.display="block";
	adm_getTrayList () ;
}
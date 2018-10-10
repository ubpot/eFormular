var MyMailId = "";

function response_getMail() {
	if (http_request_Form.readyState == 4) {
   		if (http_request_Form.status == 200) {
			//alert(http_request_Form.responseText);
			var responseText = http_request_Form.responseText.replace(/\\'/g,"'");
			responseText = responseText.replace(/\n/g,"\\n");
			var MailData=eval ('(' + responseText +')');
			document.getElementById('ef_Mailname').value=MailData.name;
			document.getElementById('ef_Params').value=MailData.params;
			document.getElementById('ef_Mailtext').value=MailData.text;
			document.getElementById('eF_Editor_Mail').innerHTML=MailData.editor;
			document.getElementById('eF_Timestamp_Mail').innerHTML=MailData.timestamp;
		} 
	}
}

function onClick_adm_loadMail(mailId) {
	MyMailId=mailId;
	http_request_Form = handle_request ();
	http_request_Form.onreadystatechange = response_getMail;
   	http_request_Form.open('GET', 'ajax/ajax.MailTmpl.get.php?id=' + mailId , true);
	http_request_Form.send(null);
}


function response_getMailList () {
	if (http_request_Form.readyState == 4) {
   		if (http_request_Form.status == 200) {
			//FormList=http_request_Menu.responseText.parseJSON();
			MailList=eval ('(' + http_request_Form.responseText +')');
			HTML ="<ul>";
			
			for (var i = 0; i < MailList.length ; i++ ) {
				HTML+='<li onclick="onClick_adm_loadMail(' + MailList[i].id  + ')">' + MailList[i].name + " </li>\n";
			}
			HTML+="</ul>";
			document.getElementById('ef_Maillist').innerHTML=HTML;
		} 
	}
}

function adm_getMailList () {
	http_request_Form = handle_request ();
	http_request_Form.onreadystatechange = response_getMailList;
   	http_request_Form.open('GET', 'ajax/ajax.MailTmpl.getList.php' , true);
	http_request_Form.send(null);
}



function onClick_Maillist () {
	hide_all();
	
    document.getElementById("eF_MenueMail").style.display="block";
	document.getElementById("eF_div_Mail").style.display="block";
	document.getElementById("ef_Maillist").style.display="block";
	
	adm_getMailList () ;
}
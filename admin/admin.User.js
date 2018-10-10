var MyUserId = "";


function response_saveUser() {
	if (http_request_saveForm.readyState == 4) {
   		if (http_request_saveForm.status == 200) {
			if (! isNaN(http_request_saveForm.responseText)) {
				
				userId = parseInt(http_request_saveForm.responseText);
				
				alert ("Userdaten wurden gespeichert");
				onClick_adm_loadUser (userId);
				
				adm_getUserList ();
			} else {
				alert (http_request_saveForm.responseText);
			}
		}
	}
}

function saveUser() {
	if (document.getElementById('ef_Passwd').value != document.getElementById('ef_Passwd2').value) {
		alert ('Die Passwörter sind nicht identisch.');
		return;
	}
	Name = document.getElementById('ef_Username').value;
	Shortname = document.getElementById('ef_Shortname').value;
	Login = document.getElementById('ef_Userlogin').value;
	Passwd = document.getElementById('ef_Passwd').value;
	Page = editorpage.getCode();
	
	var params = 'userid=' + MyUserId + '&name=' + Name  + '&login=' +  Login   + '&shortname=' + Shortname + '&passwd=' + Passwd  + '&editor='+ USER + '&page=' + encodeURIComponent(Page);
	
	http_request_saveForm = handle_request ();
	http_request_saveForm.open('POST', 'ajax/ajax.User.save.php', true);
	
	http_request_saveForm.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	http_request_saveForm.setRequestHeader("Content-length", params.length);
	http_request_saveForm.setRequestHeader("Connection", "close");
	
	http_request_saveForm.onreadystatechange = response_saveUser;
   	
	http_request_saveForm.send(params);
}


function response_getUser() {
	if (http_request_Form.readyState == 4) {
   		if (http_request_Form.status == 200) {
			//alert(http_request_Form.responseText);
			responseText = http_request_Form.responseText.replace(/\n/g,"\\n");
			var UserData=eval ('(' + responseText +')');
			//var UserData = http_request_Form.responseText.parseJSON();
			document.getElementById('ef_Username').value=UserData.name;
			document.getElementById('ef_Userlogin').value = UserData.login;
			document.getElementById('ef_Shortname').value = UserData.shortname;
			document.getElementById('ef_Passwd').value = "";
			document.getElementById('ef_Passwd2').value = "";
			editorpage.setCode(UserData.page);

			document.getElementById('eF_Editor_User').innerHTML = UserData.editor;
			document.getElementById('eF_Timestamp_User').innerHTML = UserData.timestamp;
		} 
	}
}

function onClick_adm_loadUser(userId) {
	MyUserId=userId;
	http_request_Form = handle_request ();
	http_request_Form.onreadystatechange = response_getUser;
   	http_request_Form.open('GET', 'ajax/ajax.User.get.php?id=' + userId , true);
	http_request_Form.send(null);
}

function response_getUserList () {
	if (http_request_Form.readyState == 4) {
   		if (http_request_Form.status == 200) {
			//FormList=http_request_Menu.responseText.parseJSON();
			UserList=eval ('(' + http_request_Form.responseText +')');
			HTML ="<ul>";
			
			for (var i = 0; i < UserList.length ; i++ ) {
				HTML+='<li onclick="onClick_adm_loadUser(' + UserList[i].id  + ')">' + UserList[i].login + " </li>\n";
			}
			HTML+="</ul>";
			document.getElementById('ef_Userlist').innerHTML=HTML;
		} 
	}
}

function adm_getUserList () {
	http_request_Form = handle_request ();
	http_request_Form.onreadystatechange = response_getUserList;
   	http_request_Form.open('GET', 'ajax/ajax.User.getList.php' , true);
	http_request_Form.send(null);
}

function onClick_Userlist() {
	hide_all();
	
	document.getElementById("eF_MenueUser").style.display="block";
	document.getElementById("eF_div_User").style.display="block";
	document.getElementById("ef_Userlist").style.display="block";
	adm_getUserList () ;
}

function newUser() {
	MyUserId="";
	document.getElementById('ef_Username').value = "";
	document.getElementById('ef_Userlogin').value = "";
	document.getElementById('ef_Shortname').value = "";
	document.getElementById('ef_Passwd').value = "";
	document.getElementById('ef_Passwd2').value = "";
	editorpage.setCode("");
}

function response_delUser() {
	if (http_request_Form.readyState == 4) {
   		if (http_request_Form.status == 200) {
			if (http_request_Form.responseText == "1") {
					alert ("User wurde gelöscht");
					newUser();
					adm_getUserList ();
			} else {
				alert ("Beim Löschen ist ein Fehler aufgetreten:" + http_request_Form.responseText+"T");
			}
		}
	}
}

function delUser() {
	http_request_Form = handle_request ();
	http_request_Form.onreadystatechange = response_delUser;
   	http_request_Form.open('GET', 'ajax/ajax.User.del.php?userid='+ MyUserId, true);
	http_request_Form.send(null);
}
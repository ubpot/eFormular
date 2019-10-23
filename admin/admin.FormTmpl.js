var MyEFormId = "";

function response_saveFormData() {
	if (http_request_saveForm.readyState == 4) {
   		if (http_request_saveForm.status == 200) {
			if (! isNaN(http_request_saveForm.responseText)) {

				//document.getElementById('eF_prevVersion').href= "javascript:onClick_adm_loadForm(" + MyEFormId + ");";
				//document.getElementById('eF_nextVersion').href= "javascript:void(0);";
				//document.getElementById('eF_Editor').innerHTML = USER;
				formId = parseInt(http_request_saveForm.responseText);

				alert ("Formulartemplate wurde gespeichert");
				onClick_adm_loadFormTmpl (formId);

				adm_getFormTmplList ();
			} else {
				alert (http_request_saveForm.responseText);
			}
		}
	}
}



function saveFormTmpl() {
	Title = document.getElementById('eF_Title').value;
	Version = parseInt(document.getElementById('eF_Version').innerHTML) + 1;
	document.getElementById('eF_Version').innerHTML = Version;
	//var oEditor = CKEDITOR.instances.eF_HTMLText;
	//HTML = encodeURIComponent(oEditor.getData( ));
	//HTML = oEditor.getData( );
	HTML = editor.getCode();

	var params = 'formid=' + MyEFormId + '&title=' + Title  + '&version=' + Version  + '&editor='+ USER + '&html=' + encodeURIComponent(HTML);

	http_request_saveForm = handle_request ();
	http_request_saveForm.open('POST', 'ajax/ajax.FormTmpl.save.php', true);

	http_request_saveForm.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	http_request_saveForm.setRequestHeader("Content-length", params.length);
	http_request_saveForm.setRequestHeader("Connection", "close");

	http_request_saveForm.onreadystatechange = response_saveFormData;

	http_request_saveForm.send(params);
}

function response_getForm() {
	if (http_request_Form.readyState == 4) {
   		if (http_request_Form.status == 200) {

			var responseText = http_request_Form.responseText.trim().replace(/\\'/g,"'");
			responseText = responseText.replace(/\n/g,"\\n");
			//var responseText = http_request_Form.responseText;
			//alert(responseText);

			//var FormData = responseText.parseJSON();
			var FormData = JSON.parse(responseText);

			editor.setCode(FormData.html);

			//document.getElementById('eF_HTMLText').value=FormData.html;
			document.getElementById('eF_Title').value = FormData.title;
			document.getElementById('eF_Version').innerHTML = FormData.version;
			document.getElementById('eF_Editor').innerHTML = FormData.editor;
			if (FormData.prevVersion != "") document.getElementById('eF_prevVersion').href= "javascript:onClick_adm_loadFormTmpl(" + FormData.prevVersion + ");";
				else document.getElementById('eF_prevVersion').href="javascript:void(0);";
			if (FormData.nextVersion != "") {
				document.getElementById('eF_nextVersion').href= "javascript:onClick_adm_loadFormTmpl(" + FormData.nextVersion + ");";
				document.getElementById('ef_button_saveFormTmpl').disabled=true;
				document.getElementById('ef_button_hideFormTmpl').disabled=true;
			} else {
				document.getElementById('eF_nextVersion').href="javascript:void(0);";
				document.getElementById('ef_button_saveFormTmpl').disabled=false;
				document.getElementById('ef_button_hideFormTmpl').disabled=false;
			}
		}
	}
}


function onClick_adm_loadFormTmpl (formId) {
	hide_all();
	$("#ef_div_HTMLText").css("display","block");
	$("#eF_MenueForm").css("display","block");
	$("#ef_Formlist").css("display","block");

	MyEFormId=formId;
	http_request_Form = handle_request ();
	http_request_Form.onreadystatechange = response_getForm;
   	http_request_Form.open('GET', 'ajax/ajax.Form.get.php?id=' + formId , true);
	http_request_Form.send(null);
}

function response_getFormTmplList () {
	if (http_request_Form.readyState == 4) {
   		if (http_request_Form.status == 200) {
			//FormList=http_request_Menu.responseText.parseJSON();
			FormList=eval ('(' + http_request_Form.responseText +')');
			HTML ="<ul>";

			for (var i = 0; i < FormList.length ; i++ ) {
				HTML+='<li onclick="onClick_adm_loadFormTmpl(' + FormList[i].formid  + ')">' + FormList[i].title + " </li>\n";
			}
			HTML+="</ul>";
			document.getElementById('ef_Formlist').innerHTML=HTML;
		}
	}
}

function adm_getFormTmplList () {
	http_request_Form = handle_request ();
	http_request_Form.onreadystatechange = response_getFormTmplList;
   	http_request_Form.open('GET', 'ajax/ajax.FormTmpl.getList.php' , true);
	http_request_Form.send(null);
}

function onClick_adm_getFormTmplList () {
	hide_all();
	$("#ef_div_HTMLText").css("display","block");
	$("#eF_MenueForm").css("display","block");
	$("#ef_Formlist").css("display","block");
	//document.getElementById("ef_div_HTMLText").style.display="block";
	//document.getElementById("eF_MenueForm").style.display="block";
	//document.getElementById("ef_Formlist").style.display="block";


	adm_getFormTmplList () ;
}



function onClick_newFormTmpl() {
	MyEFormId="";
	editor.setCode("");
	document.getElementById('eF_Title').value = "";
	document.getElementById('eF_Version').innerHTML = 0;
	document.getElementById('eF_Editor').innerHTML = "";
}


function response_hideForm() {
	if (http_request_Form.readyState == 4) {
   		if (http_request_Form.status == 200) {
			alert("Formulartemplate versteckt");
			adm_getFormTmplList ();
		}
	}
}

function hideFormTmpl() {
	if (confirm("Formulartemplate wirklich verstecken?")) {
		document.getElementById("ef_div_HTMLText").style.display="block";

		document.getElementById("eF_MenueForm").style.display="block";
		document.getElementById("eF_MenueSearchstring").style.display="none";

		document.getElementById("eF_div_Searchstring").style.display="none";

		http_request_Form = handle_request ();
		http_request_Form.onreadystatechange = response_hideForm;
		http_request_Form.open('GET', 'ajax/ajax.Form.hide.php?id=' + MyEFormId , true);
		http_request_Form.send(null);
	}
}
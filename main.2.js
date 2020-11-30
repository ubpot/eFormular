// JavaScript Document
/*

Autor: Paul Borchert
Date : Dez 2009

*/


var http_request_Form = false;
var http_request_saveForm = false;
var http_request_Menu = false;
var MyEFormId = "";
var MyEFormDataId = "";
var MyEFolderId = "";
var MyEFormValues = null;
var MyWatchlist = new Array();
var WorkFlowStepNode2Status = new Array();
var WorkFlowStepGroupNode2Status = new Array();

var Folder_selectedId = "";
var LastSearchURL = "";


function response_closeForm () {
	if (http_request_Form.readyState == 4) {
   		if (http_request_Form.status == 200) {

		}
	}
}

function closeForm() {
	if (MyEFormDataId) {
		http_request_Form = handle_request ();
		http_request_Form.onreadystatechange = response_closeForm;
	   	http_request_Form.open('GET', 'ajax/ajax.FormData.unblock.php?formdataid=' + MyEFormDataId , true);
		http_request_Form.send(null);
	}
	MyEFormDataId="";
	MyEFolderId = "";
	MyEFormId = "";
}

function loadForm(FormId,FormDataId) {
	closeForm();
	document.location = '?loadFormId=' + FormId + '&loadFormDataId=' + FormDataId ;
}

function loadFormWatchlist(FormId,FormDataId) {
	closeForm();
	document.location = '?loadFormId=' + FormId + '&loadFormDataId=' + FormDataId +'&watchlistlink=1';
}

function clear_wrap(){
	document.getElementById("ef_Formular").style.display="none";
	document.getElementById("ef_FormularHead").style.display="none";
	document.getElementById("main").style.display="none";
	document.getElementById('ef_Searchresult').style.display="none";
	document.getElementById('ef_Folder').style.display="none";
	document.getElementById('ef_button_saveFormData').disabled="true";
	document.getElementById('ef_button_saveFormData2').disabled="true";
	document.getElementById('ef_button_delFormData').disabled="true";
	document.getElementById('ef_button_delFolder').disabled="true";
	document.getElementById('ef_button_Print').disabled="true";
	document.getElementById('ef_button_addToWatchlist').disabled="true";
}

function response_saveFormData() {
	if (http_request_saveForm.readyState == 4) {
   		if (http_request_saveForm.status == 200) {
			if (! isNaN(http_request_saveForm.responseText)) {

				document.getElementById('eF_prevVersion').href= "?loadFormId=" + MyEFormId  + "&loadFormDataId=" + MyEFormDataId ;
				document.getElementById('eF_nextVersion').href= "javascript:void(0);";
				document.getElementById('eF_Editor').innerHTML = USER;
				MyEFormDataId = parseInt(http_request_saveForm.responseText);
				alert ("Formular wurde gespeichert");

			} else {
				console.log(http_request_saveForm.responseText);
			}
		}
else{
	alert("error");}
	}
}

function saveFormData(FolderId) {


	document.getElementById('ef_popup_saveFormData').style.visibility = "hidden";

	Title = document.getElementById('eF_Title').value;
	Version = parseInt(document.getElementById('eF_Version').innerHTML) + 1;
	for (var i = 0; i < document.getElementById('ef_Formular').childNodes.length ; i++) {
		if (document.getElementById('ef_Formular').childNodes[i].tagName == "FORM" && document.getElementById('ef_Formular').childNodes[i].className=="eFormular" ) {
				Formular = document.getElementById('ef_Formular').childNodes[i];
				break;
		}
	}
	FormElem = Formular.elements;


	if (FolderId) getFolder(FolderId);

	if (Title == "" && FolderId == "") {
		alert("Formular nicht gespeichert - Formulare müssen entweder einen Titel besitzen oder in einem Ordner abgelegt werden.");
		return;
	}

	sel = document.getElementById('eF_Tray');
	for (var k = 0; k <= sel.options.length -1 ; k++) {
		if (sel.options[k].selected == true ) {
			TrayId = sel.options[k].value;
		}
	}
	sel = document.getElementById('eF_Status');
	for (var k = 0; k < sel.options.length ; k++) {
		if (sel.options[k].selected ==  true) {
			Status = sel.options[k].value;
		}
	}

	Hinttext = document.getElementById('eF_Hinttext').value;

	document.getElementById('eF_Version').innerHTML = Version;
	MyElem = new Array();
	if (Formular.tagName == "FORM" && Formular.className=="eFormular") {
		for (var i = 0; i < FormElem.length ; i++ ) {

			MyElem[i] = new Object();
			MyElem[i].id=FormElem[i].id;
			Value = FormElem[i].value;
			// Sonderzeichen die Probleme machen
			Value = Value.replace(/%22/g, '"'); // URL Encoding
			Value = Value.replace(/%3A/g, ':'); // URL Encoding
			Value = Value.replace(/%7B/g, "{"); // URL Encoding
			Value = Value.replace(/%7D/g, "}"); // URL Encoding
			Value = Value.replace(/%5D/g, "]"); // URL Encoding
			Value = Value.replace(/%5B/g, "["); // URL Encoding
			Value = Value.replace(/%2C/g, ","); // URL Encoding


	//   Value = Value.replace(/\\/g,String.fromCharCode(92,92));
	  		Value = Value.replace(/\\/g,'\\\\');
      //Value = Value.replace(/\\/g, "\\"); // einfachen Backslash durch doppelte ersetzen
			Value = Value.replace(/\'/g,"\\u0027"); 			// Wird bei get Formdata wieder ersetzt
			Value = Value.replace(/\"/g,"\\u0022");
			Value = Value.replace(/}/g,"\\u007d");				// Wird bei save Formdata ersetzt
			Value = Value.replace(/&/g,"%26");					// URL encode
			Value = Value.replace(/\r?\n/g, '<br />');
			Value = Value.replace(/\t/g, '\\t');
			
			MyElem[i].value=Value;
			MyElem[i].checked=FormElem[i].checked;
			MyElem[i].tagName=FormElem[i].tagName;
			MyElem[i].title=FormElem[i].title;

		}

	}

	var params = 'formid=' + MyEFormId + '&dataid=' + MyEFormDataId  +  '&title=' + Title  + '&version=' + Version + '&hinttext=' + Hinttext ;
	params	+= '&editor='+ USER + '&editorid='+ USER_ID + '&trayid=' + TrayId + '&status='+ Status + '&folderid=' + FolderId + '&json=' + MyElem.toJSONString();

	http_request_saveForm = handle_request ();
	http_request_saveForm.open('POST', 'ajax/ajax.FormData.save.php', true);

	http_request_saveForm.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	// http_request_saveForm.setRequestHeader("Content-length", params.length);
	//http_request_saveForm.setRequestHeader("Connection", "close");

	http_request_saveForm.onreadystatechange = response_saveFormData;
	//console.log(params);
	http_request_saveForm.send(params);

}

function saveFormDataFolder()  {
	FolderId = "";
	sel = document.getElementById('ef_popup_SaveFormData_FolderList').firstChild;
	for (var k = 0; k <= sel.options.length -1 ; k++) {
		if (sel.options[k].selected == true ) {
			FolderId = sel.options[k].value;
		}
	}
	saveFormData(FolderId);
}

function response_getFolderFormDataList () {
	if (http_request_Form.readyState == 4) {
   		if (http_request_Form.status == 200) {

			FormDataList = http_request_Form.responseText.parseJSON();
			HTML = "";
			if (FormDataList.length == 0) {
				document.getElementById('ef_Formular').innerHTML="<h1> Dieser Ordner enthält keine Dokumente </h1>";
				return;
			}
			for (var i = 0; i < FormDataList.length ; i++) {
				if (FormDataList[i].formdataid == MyEFormDataId) {
					HTML += '<div class="ef_FolderFormListItemSelected">';
				} else {
					HTML += '<div class="ef_FolderFormListItem">';
				}
				HTML += '<a href="javascript:void(0)" onclick="loadForm(' + FormDataList[i].formid + ',' + FormDataList[i].formdataid + ')"  > '+ FormDataList[i].Formulartyptitle + '</a>';
				//HTML += '<a href="?loadFormId=' + FormDataList[i].formid + '&loadFormDataId='+ FormDataList[i].formdataid + '">' + FormDataList[i].Formulartyptitle + '</a>';
				HTML += '</div>';
			}
			document.getElementById('eF_FolderFormList').innerHTML= HTML;

		}
	}
}

function onClick_delFolder() {
	if (confirm("Ordner wirklich löschen")) {
		http_request_Form = handle_request ();
		http_request_Form.onreadystatechange = response_delFormData;
	   	http_request_Form.open('GET', 'ajax/ajax.Folder.del.php?folderid=' + MyEFolderId , true);
		http_request_Form.send(null);
	}
}



function response_delFormData () {
	if (http_request_Form.readyState == 4) {
   		if (http_request_Form.status == 200) {
			//http://info.ub.uni-potsdam.de/eFormular/index.2.php
			document.location = "?loadFolderId="+http_request_Form.responseText;
			//alert ( http_request_Form.responseText);
		}
	}
}

function onClick_delFormData() {
	if (confirm("Formular wirklich löschen")) {
		http_request_Form = handle_request ();
		http_request_Form.onreadystatechange = response_delFormData;
	   	http_request_Form.open('GET', 'ajax/ajax.FormData.del.php?formdataid=' + MyEFormDataId , true);
		http_request_Form.send(null);
	}
}


function getFolderFormDataList (folderId) {
	http_request_Form = handle_request ();
	http_request_Form.onreadystatechange = response_getFolderFormDataList;
   	http_request_Form.open('GET', 'ajax/ajax.Folder.FormDataList.get.php?folderid=' + folderId , true);
	http_request_Form.send(null);
}

function response_getFolder () {
	if (http_request_Form.readyState == 4) {
   		if (http_request_Form.status == 200) {
			//var Folder = http_request_Form.responseText.trim().parseJSON();
			var Folder = JSON.parse(http_request_Form.responseText.trim());
			document.getElementById('eF_Foldertitle').innerHTML = Folder.title;
			MyEFolderId = Folder.id;
			getFolderFormDataList (Folder.id);
		}
	}

}

function response_getFormvalues () {
	if (http_request_Form2.readyState == 4) {
   		if (http_request_Form2.status == 200) {
			MyEFormValues = http_request_Form2.responseText.parseJSON();
			if (typeof eF_API_onLoadFormular === "function") {
			    eF_API_onLoadFormular();			// Aufruf um die Daten zu übernehmen
		    }
		}
	}

}

var http_request_Form_2 = false;

function getFolder (folderId) {
	document.getElementById("ef_Folder").style.display="block";

	if (folderId > 0) {
		http_request_Form = handle_request ();
		http_request_Form.onreadystatechange = response_getFolder;
		http_request_Form.open('GET', 'ajax/ajax.Folder.get.php?folderid=' + folderId , true);
		http_request_Form.send(null);
		document.getElementById("ef_button_delFolder").disabled=false;

		http_request_Form2 = handle_request ();
		http_request_Form2.onreadystatechange = response_getFormvalues;
   		http_request_Form2.open('GET', 'ajax/ajax.Formvalues.get.php?folderid=' + folderId, true);
		http_request_Form2.send(null);

	} else {
		document.getElementById('eF_Foldertitle').innerHTML = "/";
		document.getElementById('eF_FolderFormList').innerHTML= "";
		document.getElementById("ef_button_delFolder").disabled=true;
	}
}

function setFormOnlyRead(){
	document.getElementById('ef_button_saveFormData').disabled=true;
	document.getElementById('ef_button_saveFormData2').disabled=true;
	document.getElementById('ef_button_delFormData').disabled=true;
	document.getElementById('ef_button_addToWatchlist').disabled=true;
	document.getElementById('ef_button_delFolder').disabled=true;
}

function response_getFormData() {
	if (http_request_Form.readyState == 4) {
   		if (http_request_Form.status == 200) {
			for (var i = 0; i < document.getElementById('ef_Formular').childNodes.length ; i++) {
				if (document.getElementById('ef_Formular').childNodes[i].tagName == "FORM" && document.getElementById('ef_Formular').childNodes[i].className=="eFormular" ) {
						Formular = document.getElementById('ef_Formular').childNodes[i];
						break;
				}
			}
			FormElem = Formular.elements;
			//Formular = document.getElementById('ef_Formular').firstChild;
			//response = eval("(" + http_request.responseText + ")");
			responseText = http_request_Form.responseText.trim().replace(/\n/g,"\\n").replace(/\t/g, "\\t");
			var FormData = responseText.parseJSON();
			var MyElem = FormData.json.parseJSON();

			MyEFolderId = FormData.id_Folder;

			document.getElementById('eF_Title').value = FormData.title;
			document.getElementById('eF_Version').innerHTML = FormData.version;
			document.getElementById('eF_Editor').innerHTML = FormData.editor;
			document.getElementById('eF_Editor').innerHTML = FormData.editor;
			document.getElementById('eF_Hinttext').innerHTML = FormData.hinttext;


			sel = document.getElementById('eF_Status');
			for (var k = 0; k < sel.options.length ; k++) {
				if (sel.options[k].value ==  FormData.status) {
					sel.options[k].selected = true;
				}
			}
			sel = document.getElementById('eF_Tray');
			for (var k = 0; k < sel.options.length ; k++) {
				if (sel.options[k].value ==  FormData.id_Tray) {
					sel.options[k].selected = true;
				}
			}
			if (FormData.nextVersion != "") setFormOnlyRead();
			if (FormData.block_begin != "" && FormData.block_id_User != USER_ID) {
				alert ("Dieses Formular ist im read-only Modus geöffnet, da es bereits seit " +FormData.block_begin + " von "+ FormData.block_User +" blockiert wird. ");
				setFormOnlyRead();

			}
			if (Formular.tagName == "FORM" && Formular.className=="eFormular") {

				if (FormData.prevVersion != "") document.getElementById('eF_prevVersion').onclick= function () {loadForm(MyEFormId ,FormData.prevVersion )};
					else document.getElementById('eF_prevVersion').href="javascript:void(0);";
				if (FormData.nextVersion != "") document.getElementById('eF_nextVersion').onclick= function () {loadForm(MyEFormId ,FormData.nextVersion )};
					else document.getElementById('eF_nextVersion').href="javascript:void(0);";
				for (var i = 0; i < MyElem.length ; i++ ) {

					FormElem[i].id=MyElem[i].id;
					Value = MyElem[i].value;
					Value = Value.replace(/\\u0027/g,"'");
					Value = Value.replace(/\\u0022/g,'"');
          Value = Value.replace(/<br \/>/g, "\n");
          if(true){
              Value = Value.replace(/\\\\/g,String.fromCharCode(92,92));

          }
					FormElem[i].value=Value;
					FormElem[i].checked=MyElem[i].checked;
					FormElem[i].title=MyElem[i].title;
					// FormElem[i].tagName=MyElem[i].tagName;
					// alert (FormElem[i].onchange + " - " + MyElem[i].onchange);

				}
			} else {
				alert ("Das geladene Formular hat nicht die Klasse eFormular oder ist kein <form>.")
			}


			getFolder (FormData.id_Folder);
			//document.getElementById('eF_Foldertitle').value = FormData.folderTitle;

		}
	}
}


function getFormData(formDataId) {
	http_request_Form = handle_request ();
	http_request_Form.onreadystatechange = response_getFormData;
   	http_request_Form.open('GET', 'ajax/ajax.FormData.get.php?dataid=' + formDataId +"&editorid="+USER_ID, true);
	http_request_Form.send(null);
}


// veraltet
/*function response_getForm() {
	if (http_request_Form.readyState == 4) {
   		if (http_request_Form.status == 200) {
			clear_wrap();
			document.getElementById("ef_Formular").style.display="block";
			document.getElementById("ef_FormularHead").style.display="block";
			var responseText = http_request_Form.responseText.replace(/\s/g," ");
			responseText = responseText.replace(/\n/g,"\\n");

			MyForm = eval ('(' + responseText +')');
			//MyForm = http_request_Form.responseText.parseJSON();

			document.getElementById("ef_Formular").innerHTML=MyForm.html;



			getFormData(MyEFormDataId);
		}
	}
}

// veraltet
function getForm(formId) {
	http_request_Form = handle_request ();
	http_request_Form.onreadystatechange = response_getForm;
   	http_request_Form.open('GET', 'ajax/ajax.Form.getHtml.php?id=' + formId , true);
	http_request_Form.send(null);
}*/

function newForm() {

	document.getElementById('eF_Version').innerHTML=0;
	document.getElementById('eF_Title').value="";
	document.getElementById('eF_Editor').innerHTML=USER;
	sel = document.getElementById('eF_Status');
	for (var k = 0; k < sel.options.length ; k++) {
		if (sel.options[k].value ==  "unerledigt") {
			sel.options[k].selected = true;
		}
	}
	sel = document.getElementById('eF_Tray');
	for (var k = 0; k < sel.options.length ; k++) {
		if (sel.options[k].value ==  "") {
			sel.options[k].selected = true;
		}
	}

}



function onload_Form(formId,formDataId,countWatchlis,folderID) {
	if (countWatchlis > 0) {
		alert ("Das Formular wurde " + countWatchlis+ " mal geändert. ");
	}
	MyEFormId = formId;
	MyEFormDataId = formDataId;
	MyEFolderId = folderID;
	if (formId > 0) {
		if (MyEFormDataId > 0) {
			getFormData(MyEFormDataId);
		} else {
			newForm();
		}
	} else {
		if (folderID > 0) {
			getFolder(folderID);
		}
	}
}

// veraltet
function onClick_loadForm(formId,formDataId) {
	MyEFormId = formId;
	MyEFormDataId = formDataId;
	getForm(formId);
}


function onClick_newForm() {
	id="";
	sel = document.getElementById('ef_popup_ForTmplList').firstChild;
	for (var k = 0; k < sel.options.length ; k++) {
		if (sel.options[k].selected ==  true) {
			id = sel.options[k].value;
		}
	}


	//getForm(id,"");
	document.location="?loadFormId="+id;
	document.getElementById('ef_popup_newTmpl').style.visibility = "hidden";
}

function response_getFormTmplList() {
	if (http_request_Menu.readyState == 4) {
   		if (http_request_Menu.status == 200) {
			FormList=http_request_Menu.responseText.parseJSON();
			HTML ="<select size=10>";
			for (var i = 0; i < FormList.length ; i++ ) {
				// HTML+='<li onclick="onClick_newForm(' + FormList[i].formid + ')">' + FormList[i].title + "</li>\n";
				HTML+='<option value="' + FormList[i].formid + '"> ' + FormList[i].title + " </option>\n";
			}
			HTML+="</select>";

			document.getElementById('ef_popup_ForTmplList').innerHTML=HTML;
			//alert (HTML);
		}
	}
}

function onClick_popup_newForm() {
	document.getElementById('ef_popup_newTmpl').style.visibility = "visible";
	document.getElementById('ef_popup_newTmpl').style.top = ((window.innerHeight - document.getElementById('ef_popup_newTmpl').offsetHeight) / 2) + "px";
	document.getElementById('ef_popup_newTmpl').style.left = ((window.innerWidth - document.getElementById('ef_popup_newTmpl').offsetWidth) / 2) + "px";
	http_request_Menu = handle_request ();
	http_request_Menu.onreadystatechange = response_getFormTmplList;
   	http_request_Menu.open('GET', 'ajax/ajax.FormTmpl.getList.php' , true);
	http_request_Menu.send(null);
}

function response_getFolderList() {
	if (http_request_Menu.readyState == 4) {
   		if (http_request_Menu.status == 200) {
			responseText = http_request_Menu.responseText.trim().replace(/\n/g,"\\n");
			FolderList=responseText.parseJSON();
			HTML ='<select size="10">';
			for (var i = 0; i < FolderList.length ; i++ ) {
				// HTML+='<li onclick="onClick_newForm(' + FormList[i].formid + ')">' + FormList[i].title + "</li>\n";
				selected_str = "";
				if (FolderList[i].folderid == Folder_selectedId) selected_str='selected="selected"';
				HTML+='<option value="' + FolderList[i].folderid + '" '+selected_str+'>  ' + FolderList[i].title + "  </option>\n";
			}
			HTML+="</select>";

			document.getElementById('ef_popup_SaveFormData_FolderList').innerHTML=HTML;
			document.getElementById('ef_popup_Folders_FolderList').innerHTML=HTML;

			//alert (HTML);
		}
	}
}

function onClick_popup_saveFormData () {
	document.getElementById('ef_popup_saveFormData').style.visibility = "visible";

	document.getElementById('ef_popup_saveFormData').style.top = ((window.innerHeight - document.getElementById('ef_popup_saveFormData').offsetHeight) / 2) + "px";
	document.getElementById('ef_popup_saveFormData').style.left = ((window.innerWidth - document.getElementById('ef_popup_saveFormData').offsetWidth) / 2) + "px";

	document.getElementsByName('ef_radio_onlyoutstanding')[0].checked=true;

	http_request_Menu = handle_request ();
	http_request_Menu.onreadystatechange = response_getFolderList;
   	http_request_Menu.open('GET', 'ajax/ajax.Folder.getList.php?onlyoutstanding=1' , true);
	http_request_Menu.send(null);
}

function response_getWatchlist() {
	if (http_request_Menu.readyState == 4) {
   		if (http_request_Menu.status == 200) {
			Watchlist=http_request_Menu.responseText.parseJSON();

			HTML = '<ul>';

			for (var i = 0; i < Watchlist.length ; i++ ) {
				//HTML += '<li> '+ MyWatchlist [i] +' </li>';

				if (Watchlist[i].foldertitle) Foldertitle = Watchlist[i].foldertitle + "/";  else Foldertitle = "";
				HTML+= '<li> <img src="img/button_del.png" onclick="rmForm2Watchlist('+ Watchlist[i].formdataid +');"/>';
				HTML+= '<b>  <a href="javascript:void();" onClick="loadFormWatchlist(' + Watchlist[i].formid + ',' + Watchlist[i].formdataid +')" class="ef_Link" > ';
				HTML+= Foldertitle + Watchlist[i].title + '</a>  </b>     </li>';
			}
			HTML += '</ul>';
			document.getElementById('watchlist').innerHTML=HTML;
		}
	}
}

function print_Watchlist(){

	http_request_Menu = handle_request ();
	http_request_Menu.onreadystatechange = response_getWatchlist;
   	http_request_Menu.open('GET', 'ajax/ajax.Watchlist.get.php' , true);
	http_request_Menu.send(null);
}

function rmForm2Watchlist(formdataid) {
	http_request_Menu = handle_request ();
	http_request_Menu.onreadystatechange = response_Watchlist;
   	http_request_Menu.open('GET', 'ajax/ajax.Watchlist.rmForm.php?formdataid[0]='+formdataid+ '&userid='+ USER_ID , true);
	http_request_Menu.send(null);
}

function response_Watchlist() {
	if (http_request_Menu.readyState == 4) {
   		if (http_request_Menu.status == 200) {

			print_Watchlist();
		}
	}
}

function add2Watchlist() {
	Checkboxes = document.getElementsByName("watchlist_add");


	DATA = "";

	count=0;
	for (var i = 0; i < Checkboxes.length ; i++ ) {
		if (Checkboxes[i].checked) {

			formdataid=Checkboxes[i].value;
			DATA += '&formdataid[' + count + ']='+formdataid;
			count++;

		}
	}
	DATA += '&userid='+ USER_ID;
	http_request_Menu = handle_request ();
	http_request_Menu.onreadystatechange = response_Watchlist;
   	http_request_Menu.open('GET', 'ajax/ajax.Watchlist.addForm.php?'+DATA , true);
	http_request_Menu.send(null);
	// print_Watchlist();
}

function onClick_addToWatchlist(){
	http_request_Menu = handle_request ();
	http_request_Menu.onreadystatechange = response_Watchlist;
   	http_request_Menu.open('GET', 'ajax/ajax.Watchlist.addForm.php?formdataid[0]='+MyEFormDataId + '&userid='+ USER_ID , true);
	http_request_Menu.send(null);
}

function response_listFormData() {
	if (http_request_Menu.readyState == 4) {
   		if (http_request_Menu.status == 200) {
			if (http_request_Menu.responseText == "\n]") {
				HTML = "Keine Treffer gefunden.";
			} else {
				closeForm();
				responseText = http_request_Menu.responseText.trim().replace(/\n/g,"\\n");
				FormListRep=JSON.parse(responseText);


				// FormListRep = FormList;

				FormList = FormListRep;



				HTML ="";
				for (var i = 0; i < FormList.length ; i++ ) {

					if (FormList[i].foldertitle) Folder = ""+FormList[i].foldertitle+"/"; else Folder = "";

					HTML+=' <div style="margin-top:10px; margin-bottom:10px;">';
					//HTML+= '<b> <a href="javascript:void(0);" class="ef_Link" onclick="onClick_loadForm(' + FormList[i].formid +',' + FormList[i].formdataid + ');"> '
					HTML+= '<div style="float:left; height: 45px;line-height: 45px; vertical-align:middle; text-align:center;padding-right: 10px; ">';
					HTML+= '   <input type="checkbox" name="watchlist_add" value="'+ FormList[i].formdataid + '"> ';
					HTML+= '</div> ';
					//HTML+= '<div style="height:45px;"> <b> <a href="?loadFormId=' + FormList[i].formid + '&loadFormDataId=' + FormList[i].formdataid + '" class="ef_Link" > '
					HTML+= '<div style="padding-left:40px;"> <b> '
					HTML+=	'<a href="javascript:void(0)" onclick="loadForm(' + FormList[i].formid + ',' + FormList[i].formdataid + ')" class="ef_Link" > '
					HTML+=  Folder + FormList[i].title + "</a> </b> "
					HTML+= " - "+ FormList[i].Formulartyptitle  + " <br />";
					HTML+= "<b>" + FormList[i].status + "</b> "
					if (FormList[i].ablage != "") HTML+= "&nbsp; - &nbsp; Ablage: " + FormList[i].ablage;
					HTML+= " - <b> "+FormList[i].date+"</b>\n";
					//HTML+= "<br> <span style='color:grey;'>" + FormList[i].hinttext + "</span> ";
					HTML+= "<br> <span style='color:grey;'>" + FormList[i].hinttext + "</span> ";
					HTML+="</div> </div>\n";

				}

				HTML+='<input type="button" onclick="add2Watchlist();" value="Markierte Formulare in die Merkliste übernehmen."';


			}

			document.getElementById('ef_Searchresultlist').innerHTML=HTML;
			clear_wrap();
			document.getElementById('ef_Searchresult').style.display="block";
			document.getElementById('ef_popup_Searchstring').style.visibility = "hidden";
			//alert (HTML);
		}
	}
}

function get_searchparam() {
	searchparam = "";
	if (document.getElementById('ef_radio_search_onlyoutstanding_1').checked == true) {
		searchparam += "&onlyoutstanding=1";
	} else {
		searchparam += "&onlyoutstanding=0";
	}
	if (document.getElementById('ef_radio_search_sort_1').checked == true) {
		searchparam += "&sort=name";
	} else if (document.getElementById('ef_radio_search_sort_2').checked == true) {
		searchparam += "&sort=date";
	} else if (document.getElementById('ef_radio_search_sort_3').checked == true) {
		searchparam += "&sort=dateasc";
	}
	return searchparam;
}

function onchange_searchparam() {
	searchparam =  get_searchparam() ;

	http_request_Menu = handle_request ();
	http_request_Menu.onreadystatechange = response_listFormData;
   	http_request_Menu.open('GET', LastSearchURL + searchparam, true);
	http_request_Menu.send(null);
}

function onClick_listFormData_akt() {
	searchparam =  get_searchparam() ;

	http_request_Menu = handle_request ();
	http_request_Menu.onreadystatechange = response_listFormData;
	LastSearchURL = 'ajax/ajax.FormData.getList.php?tem=0';
   	http_request_Menu.open('GET', LastSearchURL  + searchparam, true);
	http_request_Menu.send(null);
}

function handle_request () {
	http_request = false;

	if (window.XMLHttpRequest) { // Mozilla, Safari,...
    	http_request = new XMLHttpRequest();
		if (http_request.overrideMimeType) {
         		http_request.overrideMimeType('text/xml');
            		// zu dieser Zeile siehe weiter unten
        }
   	} else if (window.ActiveXObject) { // IE
	    try {
        	http_request = new ActiveXObject("Msxml2.XMLHTTP");
        	} catch (e) {
        	try {
            	http_request = new ActiveXObject("Microsoft.XMLHTTP");
				}catch (e) {}
            }
        }

    if (!http_request) {
        alert('Ende :( Kann keine XMLHTTP-Instanz erzeugen');
    	return false;
    }
	return http_request;
}

function search (sstr) {
	//alert(sstr.toString());
	searchparam =  get_searchparam();
	http_request_Menu = handle_request ();
	http_request_Menu.onreadystatechange = response_listFormData;
	LastSearchURL = 'ajax/ajax.Search.php?query=' + encodeURIComponent(sstr) ;
   	http_request_Menu.open('GET',  LastSearchURL + searchparam, true);
	http_request_Menu.send(null);
}

function onclick_search () {
	sstr = document.getElementById('searchString').value;
	search(sstr);
}

function onClick_Trays() {
	//clear_wrap();
	document.getElementById('ef_popup_Trays').style.visibility="visible";
	document.getElementById('ef_popup_Trays').style.top = ((window.innerHeight - document.getElementById('ef_popup_Trays').offsetHeight) / 2) + "px";
	document.getElementById('ef_popup_Trays').style.left = ((window.innerWidth - document.getElementById('ef_popup_Trays').offsetWidth) / 2) + "px";

}

function onClick_load_tray () {
	document.getElementById('ef_popup_Trays').style.visibility="hidden";

	sel = document.getElementById('ef_popup_Trays_TrayList').firstChild;
	for (var k = 0; k <= sel.options.length -1 ; k++) {
		if (sel.options[k].selected == true ) {
			id = sel.options[k].value;
		}
	}

	searchparam =  get_searchparam() ;

	http_request_Menu = handle_request ();
	http_request_Menu.onreadystatechange = response_listFormData;
	LastSearchURL = 'ajax/ajax.Search.php?tray=' + id;
   	http_request_Menu.open('GET', LastSearchURL + searchparam , true);
	http_request_Menu.send(null);
}

function response_getSearchstringList() {
	if (http_request_Menu.readyState == 4) {
   		if (http_request_Menu.status == 200) {
			SSList=http_request_Menu.responseText.trim().parseJSON();
			HTML ="<select size = 10>";
			for (var i = 0; i < SSList.length ; i++ ) {
				//var sstring = SSList[i].sstring.replace(/\"/g,"\\\"");

				HTML+='<option value="' + SSList[i].id + '">' + SSList[i].title + "</option>\n";
			}
			HTML+="</select>";


			document.getElementById('ef_popup_ForSearchstring').innerHTML=HTML;
			//alert (HTML);
		}
	}
}
function onClick_startSearch () {
	sel = document.getElementById('ef_popup_ForSearchstring').firstChild;
	id = "";
	for (var k = 0; k <= sel.options.length -1 ; k++) {
		if (sel.options[k].selected == true ) {
			id = sel.options[k].value;
		}
	}
	searchparam =  get_searchparam() ;
	http_request_Menu = handle_request ();
	http_request_Menu.onreadystatechange = response_listFormData;
	LastSearchURL = 'ajax/ajax.Search.php?sstringid=' + id ;
   	http_request_Menu.open('GET', LastSearchURL + searchparam, true);
	http_request_Menu.send(null);
}

function onClick_popup_Searchstring() {
	document.getElementById('ef_popup_Searchstring').style.visibility = "visible";
	document.getElementById('ef_popup_Searchstring').style.top = ((window.innerHeight - document.getElementById('ef_popup_Searchstring').offsetHeight) / 2) + "px";
	document.getElementById('ef_popup_Searchstring').style.left = ((window.innerWidth - document.getElementById('ef_popup_Searchstring').offsetWidth) / 2) + "px";
	http_request_Menu = handle_request ();
	http_request_Menu.onreadystatechange = response_getSearchstringList;
   	http_request_Menu.open('GET', 'ajax/ajax.Searchstring.getList.php' , true);
	http_request_Menu.send(null);
}

var SaveFolderTitle = "";

function response_saveFolder () {
	if (http_request_saveFolder.readyState == 4) {
   		if (http_request_saveFolder.status == 200) {
			if (! isNaN(http_request_saveFolder.responseText)) {
				Folder_selectedId = parseInt(http_request_saveFolder.responseText);
				/*HTML= document.getElementById('ef_popup_SaveFormData_FolderList').firstChild.innerHTML;
				HTML += '<option value="' + http_request_saveFolder.responseText + '">  ' + SaveFolderTitle + "  </option>\n";
				document.getElementById('ef_popup_SaveFormData_FolderList').firstChild.innerHTML = HTML;*/
				radios = document.getElementsByName('ef_radio_onlyoutstanding');
				var value = 0;
				for (var i = 0; i < radios.length; i++) {
					if (radios[i].checked == true) 	value=radios[i].value;
				}

				http_request_Menu = handle_request ();
				http_request_Menu.onreadystatechange = response_getFolderList;
				http_request_Menu.open('GET', 'ajax/ajax.Folder.getList.php?onlyoutstanding='+value , true);
				http_request_Menu.send(null);
			} else {
				alert (http_request_saveFolder.responseText);
			}


		}
	}
}


function onClick_newFolder() {
	var Foldername = prompt("Neuer Ordername:");
	if (Foldername != "") {
		//SaveFolderTitle = Foldername;
		http_request_saveFolder = handle_request ();
		http_request_saveFolder.onreadystatechange = response_saveFolder;
		http_request_saveFolder.open('GET', 'ajax/ajax.Folder.save.php?foldertitle='+ Foldername , true);
		http_request_saveFolder.send(null);
	}
}

function onClick_renameFolder() {
	folderid = document.getElementById('ef_popup_SaveFormData_FolderList').firstChild.value;
	if (folderid != null && folderid != ""){
		var Foldername = prompt("Neuer Ordername:");
		if (Foldername != "") {
			folderid = document.getElementById('ef_popup_SaveFormData_FolderList').firstChild.value;

			//SaveFolderTitle = Foldername;
			http_request_saveFolder = handle_request ();
			http_request_saveFolder.onreadystatechange = response_saveFolder;
			http_request_saveFolder.open('GET', 'ajax/ajax.Folder.save.php?id='+folderid+'&foldertitle='+ Foldername , true);
			http_request_saveFolder.send(null);
		}
	} else {
		alert ("Bitte einen Ordner auswählen")
	}
}

function onClick_Folders() {
	document.getElementById('ef_popup_Folders').style.visibility = "visible";
	document.getElementById('ef_popup_Folders').style.top = ((window.innerHeight - document.getElementById('ef_popup_Folders').offsetHeight) / 2) + "px";
	document.getElementById('ef_popup_Folders').style.left = ((window.innerWidth - document.getElementById('ef_popup_Folders').offsetWidth) / 2) + "px";
	document.getElementsByName('ef_radio_onlyoutstanding2')[0].checked=true;
	http_request_Menu = handle_request ();
	http_request_Menu.onreadystatechange = response_getFolderList;
   	http_request_Menu.open('GET', 'ajax/ajax.Folder.getList.php?onlyoutstanding=1' , true);
	http_request_Menu.send(null);
}

function onClick_open_Folder() {
	FolderID = document.getElementById('ef_popup_Folders_FolderList').firstChild.value;
	document.location = "?loadFolderId="+FolderID;
}

function onchange_onlyoutstanding(elem) {
	http_request_Menu = handle_request ();
	http_request_Menu.onreadystatechange = response_getFolderList;
   	http_request_Menu.open('GET', 'ajax/ajax.Folder.getList.php?onlyoutstanding='+elem.value , true);
	http_request_Menu.send(null);
}

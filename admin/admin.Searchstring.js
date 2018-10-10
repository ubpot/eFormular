var MySearchstringId = "";

function response_getSStringList () {
	if (http_request_Form.readyState == 4) {
   		if (http_request_Form.status == 200) {
			//FormList=http_request_Menu.responseText.parseJSON();
			SStringList=eval ('(' + http_request_Form.responseText +')');
			HTML ="<ul>";
			
			for (var i = 0; i < SStringList.length ; i++ ) {
				HTML+='<li onclick="onClick_adm_loadSearchstring(' + SStringList[i].id  + ')">' + SStringList[i].title + " </li>\n";
			}
			HTML+="</ul>";
			document.getElementById('ef_SStringlist').innerHTML=HTML;
		} 
	}
}

function adm_getSStringList () {
	http_request_Form = handle_request ();
	http_request_Form.onreadystatechange = response_getSStringList;
   	http_request_Form.open('GET', 'ajax/ajax.Searchstring.getList.php' , true);
	http_request_Form.send(null);
}

function onClick_adm_getSStringList () {
	hide_all();
	
	document.getElementById("eF_MenueSearchstring").style.display="block";
	document.getElementById("eF_div_Searchstring").style.display="block";
	document.getElementById("ef_SStringlist").style.display="block";
	adm_getSStringList () ;
}

function response_saveSearchstring() {
	if (http_request_Form.readyState == 4) {
   		if (http_request_Form.status == 200) {
			//alert(http_request_Form.responseText);
			if (! isNaN(http_request_Form.responseText)) {
				alert("Suchstring gespeichert");
				MySearchstringId = parseInt(http_request_Form.responseText);
			}
			adm_getSStringList();
		}
	}
}

function response_delSearchString() {
	if (http_request_Form.readyState == 4) {
   		if (http_request_Form.status == 200) {
			if (http_request_Form.responseText == "1") {
					alert ("Suchstring wurden gelöscht");
					newSearchString();
					adm_getSStringList();
			} else {
				alert ("Beim Löschen ist ein Fehler aufgetreten:" + http_request_Form.responseText);
			}
		}
	}
}

function delSearchString() {
	http_request_Form = handle_request ();
	http_request_Form.onreadystatechange = response_delSearchString;
   	http_request_Form.open('GET', 'ajax/ajax.Searchstring.del.php?sstringid='+ MySearchstringId, true);
	http_request_Form.send(null);
}

function saveSearchString() {
	Title = document.getElementById('eF_Title_Searchstring').value;
	sstring = document.getElementById('eF_Searchstring').value ;
	
	http_request_Form = handle_request ();
	http_request_Form.onreadystatechange = response_saveSearchstring;
   	http_request_Form.open('GET', 'ajax/ajax.Searchstring.save.php?sstringid=' + MySearchstringId + '&title=' + Title  + '&sstring=' + encodeURIComponent(sstring)  + '&editor=' + USER, true);
	http_request_Form.send(null);
}

function newSearchString(){
	MySearchstringId="";
	document.getElementById('eF_Searchstring').value="";
	document.getElementById('eF_Title_Searchstring').value = "";
	document.getElementById('eF_Editor_Searchstring').innerHTML = "";
	document.getElementById('eF_Timestamp_Searchstring').innerHTML = "";
}

function response_getSeachstring() {
	if (http_request_Form.readyState == 4) {
   		if (http_request_Form.status == 200) {
			//alert(http_request_Form.responseText);
			var FormData=eval ('(' + http_request_Form.responseText +')');
			//var FormData = http_request_Form.responseText.parseJSON();
			document.getElementById('eF_Searchstring').value=FormData.sstring;
			document.getElementById('eF_Title_Searchstring').value = FormData.title;
			document.getElementById('eF_Editor_Searchstring').innerHTML = FormData.editor;
			document.getElementById('eF_Timestamp_Searchstring').innerHTML = FormData.timestamp;
		} 
	}
}

function onClick_adm_loadSearchstring(searchstringId) {
	hide_all();
	document.getElementById("eF_MenueSearchstring").style.display="block";
	document.getElementById("eF_Searchstring").style.display="block";
	document.getElementById("eF_div_Searchstring").style.display="block";
	document.getElementById("ef_SStringlist").style.display="block";
	//eF_Searchstring
	
	MySearchstringId=searchstringId;
	http_request_Form = handle_request ();
	http_request_Form.onreadystatechange = response_getSeachstring;
   	http_request_Form.open('GET', 'ajax/ajax.Searchstring.get.php?id=' + searchstringId , true);
	http_request_Form.send(null);
}

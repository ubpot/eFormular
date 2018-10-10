// JavaScript Document
/*

Autor: Paul Borchert
Date : Apr 2010

*/

/* Die einzelnen Selects der Workflowkomponente 3s (3 Stadien)
	sollten in einer Baumstruktur verknüpft sein. Wir ein select geändert,
	so hat dies Auswirkungen auf seine Kinder und seine Eltern.
	
	Bei den Eltern wird der Status berechnet, in dem geprüft wird, welchen Status
	die Kinder haben. Sind alle Kinder erledigt oder übersprungen, so ist der
	Vater erledigt.
	Dies macht die Funktion onchangeWf3sSelectSetChilds.
	
	Fals ein Konten Kinder hat so wird gefragt, wie man sich bei den Kindern 
	verhalten soll. Die Kinder können alle auf unerledigt gesetzt werden oder
	die unerledigten auf übersprungen oder erledigt.
	Dies macht die Funktion onchangeWf3sSelect2.
*/
function onchangeWf3sSelectSetChilds(obj,mystatus) {
	var now = new Date();
	var MyElem = document.getElementsByName(obj.id);
	var setstatus;
	for (var i = 0; i < MyElem.length ; i++ ) {
		MyElem[i].title= "Bearbeiter: " + USER+"  "+ now.getFullYear() + "-" + (now.getMonth()+1) + "-" + now.getDate()+" ";
		MyElem[i].title += now.getHours()+":"+ ((now.getMinutes() < 10) ? "0" + now.getMinutes() : now.getMinutes());

		for (var k = 0; k <= MyElem[i].options.length -1 ; k++) {
			if (MyElem[i].options[k].selected == true ) {
				aktstatus = MyElem[i].options[k].text;	
			}
		}
		if (mystatus != "unerledigt" && aktstatus != "unerledigt") {
			setstatus = aktstatus;
		} else {
			setstatus = mystatus;
		}
		for (var k = 0; k <= MyElem[i].options.length -1 ; k++) {
			if (MyElem[i].options[k].text == setstatus) {
				MyElem[i].options[k].selected = true;
			}
		}
		if (document.getElementsByName(MyElem[i].id).length > 0) {
			onchangeWf3sSelectSetChilds(MyElem[i],mystatus);
		}
	}
}


function onchangeWf3sSelect2 (obj) {
	
	
	//if (first && document.getElementsByName(obj.id).length > 0) {
	
	
	status = "erledigt";
	if (obj.name != "") {
		MyElem = document.getElementsByName(obj.name);
		for (var i = 0; i < MyElem.length ; i++ ) {
			for (var k = 0; k <= MyElem[i].options.length -1 ; k++) {
				if (MyElem[i].options[k].selected == true && (MyElem[i].options[k].text == "unerledigt" || MyElem[i].options[k].text == "in Bearbeitung")) {
						status = "unerledigt";	
				}
			}
		}
	
		element = document.getElementById(obj.name);
		for (var k = 0; k <= element.options.length -1 ; k++) {
			if (element.options[k].text == status) {
				element.options[k].selected = true ;
			}
		}
		if (element.name == "") {
			// Wurzelknoten - eF_Status auch setzten
			ef_Status = document.getElementById('eF_Status');
			for (var k = 0; k < ef_Status.options.length ; k++) {
				if (ef_Status.options[k].text == status) {
					ef_Status.options[k].selected = true ;
				}
			}
		}
		element.title = "";
		onchangeWf3sSelect2 (element);
	} 
}

function onchangeWf3sSelect (obj) {
	var now = new Date();
	obj2 = obj;
	while (obj2) {
		
		if (obj2.className == "ef_WF_span_name") {
			obj2.innerHTML = " - " + SHORTNAME;
		}
		obj2=obj2.nextSibling;
	}
	obj.title= "Bearbeiter: " + USER+"  "+ now.getFullYear() + "-" + (now.getMonth()+1) + "-" + now.getDate()+" ";
	obj.title += now.getHours()+":"+ ((now.getMinutes() < 10) ? "0" + now.getMinutes() : now.getMinutes());

	if (document.getElementsByName(obj.id).length > 0){
		mystatus = obj.value;	
		if (obj.name == "") {
			// Wurzelknoten - eF_Status auch setzten
			ef_Status = document.getElementById('eF_Status');
			for (var k = 0; k < ef_Status.options.length ; k++) {
				if (ef_Status.options[k].text == mystatus) {
					ef_Status.options[k].selected = true ;
				}
			}
		}
		if (mystatus == "unerledigt" ) {
			var text = "Wollen sie alle Teilschritte auf den Status "+ mystatus + " setzten?"
		} else {
			var text = "Wollen sie alle unerledigten Teilschritte auf den Status " + mystatus + " setzten?"
		}
		if (confirm(text)){
			onchangeWf3sSelectSetChilds(obj,mystatus);
		}
	}
	onchangeWf3sSelect2 (obj,true);
	
}
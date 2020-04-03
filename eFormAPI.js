// JavaScript Document
/*

Autor: Paul Borchert
Date : Dez 2010

*/


function eF_API_getValueByFormulartyp(Formulartyp,htmlElementId) {
	if (! MyEFormValues[Formulartyp]) throw "Formulartyp in dem Ordner nicht gefunden";
	if (MyEFormValues[Formulartyp][htmlElementId]) {
		Value = MyEFormValues[Formulartyp][htmlElementId];
		Value = Value.replace(/\\u0027/g,"'"); 
		Value = Value.replace(/\\u0022/g,'"');
		return Value;
	} else {
		//throw "Id in dem Formulartyp nicht gefunden.";
		return null;
	}
}
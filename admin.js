// JavaScript Document
var http_request_Form=false;
var http_request_saveForm=false;

function hide_all() {
	$(".topMenue").css("display","none");
	$(".main").css("display","none"); 
	$(".ef_Formlist").css("display","none");
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


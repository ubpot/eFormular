<?php

/*
Die 3S (3 States) Serie bezieht sich auf die statuse unerledigt, erledigt und übersprungen.

Die zugehörigen javascriptfunktionen sind in workflow.js gespeichert.
*/
$Count = 0;
$Makros = array ('/%WF-3S-SELECT\((.*),(.*)\)%/' =>
					"\n <select id='$1' name='$2' onchange='onchangeWf3sSelect(this);'> \n "
					."\t <option selected='selected'> unerledigt </option> <option> in Bearbeitung </option> <option> &uuml;bersprungen </option> <option> erledigt </option> \n"
					."</select> \n"
				 , '/%WF-3S-SELECT-UB\((.*),(.*)\)%/' =>
					"\n <select id='$1' name='$2' onchange='onchangeWf3sSelect(this);'> \n "
					."\t <option > unerledigt </option> <option> in Bearbeitung </option> <option selected='selected'> &uuml;bersprungen </option> <option> erledigt </option> \n"
					."</select> \n"
				 , '/%WF-3S-SELECT-FORMULAR\((.*)\)%/' =>
				 	"\n <select id='$1' onchange='onchangeWf3sSelect(this);'> \n "
					."\t <option selected='selected'> unerledigt </option> <option> erledigt </option> \n"
					."</select> \n"
				 , '/%WF-3S-SELECT-USER\((.*),(.*)\)%/' =>
					"\n <select id='$1' name='$2' onchange='onchangeWf3sSelect(this);'> \n "
					."\t <option selected='selected'> unerledigt </option> <option> in Bearbeitung </option> <option> &uuml;bersprungen </option> <option> erledigt </option> \n"
					."</select><br><span class='ef_WF_span_name'>  </span>"
				 , '/%WF-3S-SELECT-USER-UB\((.*),(.*)\)%/' =>
					"\n <select id='$1' name='$2' onchange='onchangeWf3sSelect(this);'> \n "
					."\t <option > unerledigt </option> <option> in Bearbeitung </option> <option selected='selected'> &uuml;bersprungen </option> <option> erledigt </option> \n"
					."</select><br><span class='ef_WF_span_name'>  </span>"
				 );

function replaceMakros ($html) {

	global $Makros;
	global $Count;
	foreach ($Makros as $key => $val) {
		//$html_array = explode  ($key,$html);
		//print_r($html_array);
		//$html="";
		//for ($i = 0; $i < count($html_array) - 1; $i++)  {

			//$html.= $html_array [$i].str_replace("%eFormGenName%", "eFormGenName".$Count++, $val);
		//}
		//$html.=$html_array [count($html_array) - 1];
		//preg_match($key, $html, $treffer);
		//print_r ($treffer);
		$html = preg_replace($key, $val, $html);

		//$html=str_replace($key, $val, $html);
	}
	return $html;
}

?>
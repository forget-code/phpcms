<?php
function yp_urlrule_select($name, $fileext = 'html', $type = 'cat', $urlruleid = 0, $property = '')
{
	global $mod,$LANG;
	if(!$name) return true;
	include PHPCMS_ROOT."/yp/include/urlrule.inc.php";
	$string = "<select name=\"".$name."\" ".$property.">\n";
	for($i=0; $i<count($urlrule[$fileext][$type]); $i++)
	{
		$selected = $i==$urlruleid ? " selected=\"selected\"" : "";
		$string.="<option value=\"".$i."\"".$selected.">".$LANG['example'].":".$urlrule[$fileext][$type][$i]['example']."</option>\n";
	}
	$string.="</select>\n";
	return $string;
}

?>
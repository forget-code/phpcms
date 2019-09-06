<?php

function display_urlrule_select($name, $fileext = 'html', $type = 'item', $urlruleid = 0, $property = '')
{
	global $mod,$LANG;
	if(!$name) return true;
	include PHPCMS_ROOT."/$mod/include/urlrule.inc.php";
	$string = "<select name=\"".$name."\" ".$property.">\n";
	$dft = $displayrule[$fileext][$type];
	$cou = count($dft);
	for($i=0; $i<$cou; $i++)
	{
		$selected = $i==$urlruleid ? " selected=\"selected\"" : "";
		$example =  $displayrule[$fileext][$type][$i]['example'];
		$string.="<option value=\"".$i."\"".$selected.">".$LANG['example'].":".$example."</option>\n";
	}
	$string.="</select>\n";
	return $string;
}

function house_urlrule_select($name, $fileext = 'html', $type = 'item', $urlruleid = 0, $property = '')
{
	global $mod,$LANG;
	if(!$name) return true;
	include PHPCMS_ROOT."/$mod/include/urlrule.inc.php";
	$string = "<select name=\"".$name."\" ".$property.">\n";
	$dft = $urlrule[$fileext][$type];
	$cou = count($dft);
	for($i=0; $i<$cou; $i++)
	{
		$selected = $i==$urlruleid ? " selected=\"selected\"" : "";
		$example =  $urlrule[$fileext][$type][$i]['example'];
		$string.="<option value=\"".$i."\"".$selected.">".$LANG['example'].":".$example."</option>\n";
	}
	$string.="</select>\n";
	return $string;
}

function areaid_select($name = 'areaidselect',$onlyoptionlabel=1, $areaid_id = 0, $alt='', $property = '',$valuetype = 'name')
{
	global $areaidS;
	$areaidselect = '';
	foreach ($areaidS as $k=>$areaid)
	{
		$selected = $k == $areaid_id ? 'selected' : '';
		if($valuetype == 'name')		
		{
			$areaidselect .= "<option value='".$k."' ".$selected.">".$areaid."</option>\n";
		}
		else 
		{
			$areaidselect .= "<option value='".$k."' ".$selected.">".$areaid."</option>\n";
		}
	}
	if(!$onlyoptionlabel)
	{
		$areaidselect="<select name='".$name."' ".$property.">\n<option value=''>".$alt."</option>\n".$areaidselect.
					 "</select>";
	}
	return $areaidselect;
}

function infocat_select($name = 'infocatselect',$onlyoptionlabel=1, $typeid = 0, $alt='', $property = '',$valuetype = 'name')
{
	$INFO = array('1'=> '出租','2'=>'求租','3'=>'合租','4'=>'出售','5'=>'求购','6'=>'置换');
	$infocatselect = '';
	foreach ($INFO as $k=>$infocatname)
	{
		$selected = $k == $typeid ? 'selected' : '';
		if($valuetype == 'name')		
		{
			$infocatselect .= "<option value='".$k."' ".$selected.">".$infocatname."</option>\n";
		}
		else 
		{
			$rinfocatselect .= "<option value='".$k."' ".$selected.">".$infocatname."</option>\n";
		}
	}
	$infocatselect = "<option value='\$infocat' >\$infocat</option>\n".$infocatselect;
	if(!$onlyoptionlabel)
	{
		$infocatselect ="<select name='".$name."' ".$property.">\n<option value=''>".$alt."</option>\n".$infocatselect."</select>";
	}
	return $infocatselect;
}


?>
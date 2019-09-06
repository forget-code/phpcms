<?php

function brand_select($name = 'brandselect',$onlyoptionlabel=1, $brand_id = 0, $alt, $property = '',$valuetype = 'name')
{
	global $BRANDS;
	$brandselect = '';
	foreach ($BRANDS as $k=>$brand)
	{
		$selected = $k == $brand_id ? 'selected' : '';
		if($valuetype == 'name')		
		{
			$brandselect .= "<option value='".$brand['brand_name']."' ".$selected.">".$brand['brand_name']."</option>\n";
		}
		else 
		{
			$brandselect .= "<option value='".$brand['brand_id']."' ".$selected.">".$brand['brand_name']."</option>\n";
		}
	}
	if(!$onlyoptionlabel)
	{
		$brandselect="<select name='".$name."' ".$property.">\n<option value=''>".$alt."</option>\n".$brandselect.
					 "</select>";
	}
	return $brandselect;
}

function property_select($name = 'propertyselect', $alt, $property = '',$pro_id=0)
{
	global $db;
	$res=$db->query("SELECT pro_id,pro_name FROM ".TABLE_PRODUCT_PROPERTY." WHERE disabled=0 Order by pro_id desc");
	$propertyselect="";
	if(mysql_num_rows($res)>0)
	{
		while($r=$db->fetch_array($res))
		{
			$propertyselect.="<option value='".$r['pro_id']."' ";
			if($pro_id == $r['pro_id']) $propertyselect.=" selected ";
			$propertyselect.=">".$r['pro_name']."</option>\n";
		}
	}
	
	$propertyselect="<select name='".$name."' ".$property.">\n<option value='0'>".$alt."</option>\n".$propertyselect.
					 "</select>";	

	$db->free_result($res);
	return $propertyselect;
}


function product_urlrule_select($name, $fileext = 'html', $type = 'cat', $urlruleid = 0, $property = '')
{
	global $mod,$LANG;
	if(!$name) return true;
	include PHPCMS_ROOT."/$mod/include/urlrule.inc.php";
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
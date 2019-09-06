<?php 
defined('IN_PHPCMS') or exit('Access Denied');

function channel_select($module = '', $name = 'channelid', $defaultalt = '', $channelid = 0, $property = '')
{
	global $CHANNEL;
	$content = '';
	foreach($CHANNEL as $id=>$channel)
	{
		if(($module && $module != $channel['module']) || $channel['islink']) continue;
		$selected = $id == $channelid ? 'selected' : '';
		$content .= "<option value='".$id."' ".$selected.">".$channel['channelname']."</option>\n";
	}
	$content = "<select name='".$name."' ".$property.">\n<option value='0'>".$defaultalt."</option>\n".$content."</select>";
	return $content;
}

function category_select($name = 'catid', $defaultalt = '', $catid = 0, $property = '')
{
	global $tree,$CATEGORY;
	$content = '';
	if(is_array($CATEGORY)) 
	{
		$categorys = array();
		foreach($CATEGORY as $id=>$cat)
		{
			if($cat['islink']==0) $categorys[$id] = array('id'=>$id,'parentid'=>$cat['parentid'],'name'=>$cat['catname']);
		}
		$tree->tree($categorys);
		$content = $tree->get_tree(0,"<option value='\$id' \$selected>\$spacer\$name</option>",$catid);
	}
	$content = "<select name='".$name."' ".$property."><option value='0'>".$defaultalt."</option>".$content."</select>";
	return $content;
}

function special_select($keyid = 0, $name = 'specialid', $defaultalt, $specialid = 0, $property = '')
{
	global $db,$tree,$specials,$LANG;
	$defaultalt = $defaultalt ? $defaultalt : $LANG['select_specail'];
	if(!is_array($specials))
	{
		$specials = array();
		$result = $db->query("SELECT specialid,parentid,specialname FROM ".TABLE_SPECIAL." WHERE keyid='$keyid' AND closed=0 ORDER BY specialid DESC", "CACHE", 86400);
		while($r = $db->fetch_array($result))
		{
			$specials[$r['specialid']] = array('id'=>$r['specialid'],'parentid'=>$r['parentid'],'name'=>str_cut($r['specialname'], 30));
		}
	}
	$tree->tree($specials);
	$content = $tree->get_tree(0, "<option value='\$id' \$selected>\$spacer\$name</option>", $specialid);
	$content = "<select name='".$name."' ".$property."><option value='0'>".$defaultalt."</option>\n".$content."</select>";
	$db->free_result($result);
	return $content;
}

function page_select($keyid = 0, $property = '')
{
	global $db,$PHP_SITEURL,$LANG;
	$result = $db->query("select title,filepath,linkurl from ".TABLE_PAGE." where passed=1 and keyid='$keyid' ORDER BY listorder");
	$string = "<select name='page_select' ".$property."><option>".$LANG['select_list_mypage']."</option>";
	while($r = $db->fetch_array($result))
	{
		$url = $r['linkurl'] ? $r['linkurl'] : $PHP_SITEURL.$r['filepath'];
		$string .= "<option value='".$url."'>".$r['title']."</option>";
	}
	$string.="</select>";
	return $string;
}
function urlrule_select($name, $fileext = 'html', $type = 'cat', $urlruleid = 0, $property = '')
{
	global $LANG;
	if(!$name) return true;
	include PHPCMS_ROOT."/include/urlrule.inc.php";
	$string = "<select name=\"".$name."\" ".$property.">\n";
	for($i=0; $i<count($urlrule[$fileext][$type]); $i++)
	{
		$selected = $i==$urlruleid ? " selected=selected" : "";
		$string.="<option value=\"".$i."\"".$selected.">".$LANG['example'].$urlrule[$fileext][$type][$i]['example']."</option>\n";
	}
	$string.="</select>\n";
	return $string;
}

function type_select($name = 'typeid', $defaultalt, $typeid = 0, $property = '')
{
	global $TYPE,$LANG;
	$select = '';
	$defaultalt = $defaultalt ? $defaultalt : $LANG['type'];
	if($TYPE)
	{
		foreach($TYPE as $k => $v)
		{
			if($v['disabled']) continue;
			$selected = $k == $typeid ? 'selected' : '';
			$select .= "<option value='".$k."' $selected>".$v['name']."</option>"; 
		}
	}
	return "<select name='$name' $property>\n<option value='0'>$defaultalt</option>\n$select</select>";
}

function keyid_select($name = 'keyid', $defaultalt = '', $keyid = '', $property = '')
{
	global $MODULE,$CHANNEL;
	$keyid = strval($keyid);
	$select = $selected = '';
	foreach($MODULE as $module=>$m)
	{
		if($m['iscopy']) continue;
		$selected = $module == $keyid ? 'selected' : '';
		$select .= "<option value='".$module."' $selected>".$m['name']."</option>\n";
	}
	foreach($CHANNEL as $channelid=>$cha)
	{
		if($cha['islink']) continue;
		$selected = $channelid == $keyid ? 'selected' : '';
		$select .= "<option value='".$channelid."' $selected>".$cha['channelname']."</option>\n";
	}
	return "<select name='$name' $property>\n<option value=''>$defaultalt</option>\n$select</select>";
}

function pos_select($keyid = '', $name = 'posid', $defaultalt = '', $posid = 0, $property = '')
{
	global $db;
	$keyid = strval($keyid);
	$select = $selected = '';
	$sql = $keyid ? " WHERE keyid='' OR keyid='$keyid' " : '';
	$result = $db->query("SELECT * FROM ".TABLE_POSITION." $sql ORDER BY listorder");
	while($r = $db->fetch_array($result))
	{
		$selected = $r['posid'] == $posid ? 'selected' : '';
		$select .= "<option value='".$r['posid']."' $selected>".$r['name']."</option>"; 
	}
	$db->free_result($result);
	return "<select name='$name' $property>\n<option value='0'>$defaultalt</option>\n$select</select>";
}

function freelink_select($name, $defaultalt = '', $property = '')
{
	$content = '';
	$types = cache_read('freelink_type.php');
	foreach($types as $v)
	{
		$content .= "<option value='".$v['name']."'>".$v['name']."</option>\n";
	}
	$content = "<select name='".$name."' ".$property.">\n<option value='0'>".$defaultalt."</option>\n".$content."</select>";
	return $content;
}
?>
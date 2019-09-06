<?php 
defined('IN_PHPCMS') or exit('Access Denied');

function province()
{
	global $db;
	$provinces = array();
	$result = $db->query("SELECT province FROM ".TABLE_PROVINCE." ORDER BY provinceid");
	while($r = $db->fetch_array($result))
	{
		$provinces[] = $r['province'];
	}
	$db->free_result($result);
	return $provinces;
}

function city($province)
{
	global $db;
	$citys = array();
	$result = $db->query("SELECT DISTINCT city FROM ".TABLE_CITY." WHERE province='$province' ORDER BY cityid");
	while($r = $db->fetch_array($result))
	{
		$citys[] = $r['city'];
	}
	$db->free_result($result);
	return $citys;
}

function area($province, $city)
{
	global $db;
	$areas = array();
	$result = $db->query("SELECT area FROM ".TABLE_CITY." WHERE city='$city' AND province='$province' ORDER BY cityid");
	while($r = $db->fetch_array($result))
	{
		$areas[] = $r['area'];
	}
	$db->free_result($result);
	return $areas;
}

function area_select($name = 'areaid', $defaultalt = '', $areaid = 0, $property = '')
{
	global $tree,$AREA;
	$content = '';
	if(is_array($AREA)) 
	{
		$areas = array();
		foreach($AREA as $i=>$v)
		{
			$areas[$i] = array('id'=>$i,'parentid'=>$v['parentid'],'name'=>$v['areaname']);
		}
		$tree->tree($areas);
		$content = $tree->get_tree(0,"<option value='\$id' \$selected>\$spacer\$name</option>",$areaid);
	}
	$content = "<select name='".$name."' ".$property."><option value='0'>".$defaultalt."</option>".$content."</select>";
	return $content;
}

function ajax_area_select($name = 'areaid', $keyid, $areaid = 0)
{
	global $LANG;
	if(!$keyid) return;
	echo '<input name="'.$name.'" id="areaid" type="hidden" value="'.$areaid.'"><span id="load_area"></span> <a href="javascript:reload();">'.$LANG['re_select'].'</a>';
	echo '<script type="text/javascript">var area_keyid="'.$keyid.'";var area_path="'.PHPCMS_PATH.'";</script>';
	echo '<script type="text/javascript" src="'.PHPCMS_PATH.'include/js/area_ajax.js"></script>';
}

function cache_areas($keyid)
{
	global $db,$PHPCMS;
	$areaids = $data = array();
    $query = $db->query("SELECT keyid,areaid,areaname,linkurl,parentid,arrparentid,child,arrchildid,urlruleid FROM ".TABLE_AREA." WHERE keyid='$keyid' ORDER by listorder,areaid");
    while($r = $db->fetch_array($query))
	{
		$areaid = $r['areaid'];
        $data[$areaid] = $r;
		$areaids[] = $areaid;
    }
	cache_write('areas_'.$keyid.'.php', $data);
	return $areaids;
}

function cache_area($areaid)
{
	global $db,$PHPCMS;
	if(!$areaid) return FALSE;
    $data = $db->get_one("SELECT * FROM ".TABLE_AREA." WHERE areaid=$areaid");
	$setting = unserialize($data['setting']);
	unset($data['setting']);
	$data = is_array($setting) ? array_merge($data, $setting) : $data;
	cache_write('area_'.$areaid.'.php', $data);
	return $data;
}

function area_url($type, $areaid, $page = 0)
{
	global $AREA,$PHPCMS,$urlrule,$PHP_DOMAIN;
	if(!is_array($AREA)) return FALSE;
	$fileext = $PHPCMS['fileext'];
	$index = $PHPCMS['index'];
	$urlruleid = $AREA[$areaid]['urlruleid'];
	$html = 'php';
	$rule = $urlrule[$html]['area'][$urlruleid];
	$rule = $page == 0 ? $rule['index'] : $rule['page'];
    eval("\$url = \"$rule\";");
	return substr($url,1);
}

function subarea($keyid, $areaid = 0, $type = 'menu')
{
	global $AREA;
    if(!is_array($AREA)) $AREA = cache_read('areas_'.$keyid.'.php');;
	$subarea = array();
	foreach($AREA as $id=>$area)
	{
		if($area['parentid'] == $areaid)
		{
			$subarea[] = $area; 
		}
	}
	return $subarea;
}

function areapos($areaid, $s = ' &gt;&gt; ')
{
	global $MOD,$AREA;
	$keyid = $AREA[$areaid]['keyid'];
    $arrparentid = $AREA[$areaid]['arrparentid'];
	$arrparentid = explode(',', $arrparentid);
	if($areaid) $arrparentid[] = $areaid;
	$pos = '';
	foreach($arrparentid as $pareaid)
	{
		if($pareaid == 0 && !isset($AREA[$pareaid])) continue;
		$areaname = $AREA[$pareaid]['areaname'];
		$linkurl = $AREA[$pareaid]['linkurl'];
		$pos .= '<a href="'.$linkurl.'">'.$areaname.'</a>'.$s;
	}
	return $pos;
}

function get_area_id($keyid, $areaname)
{
	global $db;
	$r = $db->get_one("select areaid from ".TABLE_AREA." where areaname='$areaname' and keyid='$keyid' ");
	if($r)
	{
		return $r['areaid'];
	}
	else
	{
		return 0;
	}
}

function get_area_parentid($keyid, $areaid)
{
	if(!$areaid) return 0;
	global $AREA;
	if(!array_key_exists($areaid, $AREA))  return 0;
	if($AREA[$areaid]['parentid'] == 0)
	{
		return $areaid;
	}
	else
	{
		return get_area_parentid($keyid, $AREA[$areaid]['parentid']);
	}
}

function area_urlrule_select($name, $fileext = 'html', $type = 'cat', $urlruleid = 0, $property = '')
{
	include PHPCMS_ROOT.'/include/urlrule.inc.php';
	$string = "<select name=\"".$name."\" ".$property.">\n";
	for($i=0; $i<count($urlrule[$fileext][$type]); $i++)
	{
		$selected = $i==$urlruleid ? " selected=\"selected\"" : "";
		$string.="<option value=\"".$i."\"".$selected.">".$urlrule[$fileext][$type][$i]['example']."</option>\n";
	}
	$string.="</select>\n";
	return $string;
}
?>
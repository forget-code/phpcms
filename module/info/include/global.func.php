<?php 
defined('IN_PHPCMS') or exit('Access Denied');

function update_info_url($infoid)
{
	global $db, $channelid, $CHA;
	$infoid = intval($infoid);
	$channelid = intval($channelid);
	if(!$infoid || !$channelid) return FALSE;
	$info = $db->get_one("select * from ".channel_table('info', $channelid)." where infoid=$infoid ");
	if(empty($info))  return FALSE;
	$linkurl = item_url('url', $info['catid'], $info['ishtml'], $info['urlruleid'], $info['htmldir'], $info['prefix'], $infoid, $info['addtime']);
	$db->query("update ".channel_table('info', $channelid)." set linkurl='$linkurl' where infoid=$infoid ");
	return TRUE;
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

function ajax_area_select($name = 'areaid', $channelid, $areaid = 0)
{
	global $LANG;
	if(!$channelid) return;
	echo '<input name="'.$name.'" id="areaid" type="hidden" value="'.$areaid.'"><span id="load_area"></span>&nbsp;&nbsp;<a href="javascript:reload();">'.$LANG['re_select'].'</a>';
	echo '<script type="text/javascript">var area_channelid='.$channelid.';var area_path="'.PHPCMS_PATH.'";</script>';
	echo '<script type="text/javascript" src="'.PHPCMS_PATH.'module/info/include/js/area.js"></script>';
}

function cache_areas($channelid)
{
	global $db,$PHPCMS,$CHA;
	$sql = " channelid=$channelid ";
	$areaids = $data = array();
    $query = $db->query("SELECT channelid,areaid,areaname,linkurl,parentid,arrparentid,child,arrchildid,urlruleid FROM ".TABLE_INFO_AREA." WHERE $sql ORDER by listorder,areaid");
    while($r = $db->fetch_array($query))
	{
		$areaid = $r['areaid'];
        $data[$areaid] = $r;
		$areaids[] = $areaid;
    }
	cache_write('areas_'.$channelid.'.php', $data);
	return $areaids;
}

function cache_area($areaid)
{
	global $db,$PHPCMS;
	if(!$areaid) return FALSE;
    $data = $db->get_one("SELECT * FROM ".TABLE_INFO_AREA." WHERE areaid=$areaid");
	$setting = unserialize($data['setting']);
	unset($data['setting']);
	$data = is_array($setting) ? array_merge($data, $setting) : $data;
	cache_write('area_'.$areaid.'.php', $data);
	return $data;
}

function area_url($type, $areaid, $page = 0)
{
	global $CHA,$AREA,$PHPCMS,$urlrule,$PHP_DOMAIN;
	if(!is_array($CHA) || !is_array($AREA)) return FALSE;
	$fileext = $PHPCMS['fileext'];
	$index = $PHPCMS['index'];
	$urlruleid = $AREA[$areaid]['urlruleid'];
	$html = 'php';
	$rule = $urlrule[$html]['area'][$urlruleid];
	$rule = $page == 0 ? $rule['index'] : $rule['page'];
    eval("\$url = \"$rule\";");
	$parentid = get_area_parentid($CHA['channelid'], $areaid);
	return $CHA['linkurl'].substr($url,1);
}

function subarea($channelid, $areaid = 0, $type = 'menu')
{
	global $AREA;
    if(!is_array($AREA)) $AREA = cache_read('areas_'.$channelid.'.php');;
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
	global $MOD,$CHA,$AREA;
	$channelid = $AREA[$areaid]['channelid'];
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

function get_area_url($channelid, $areaid, $linkurl)
{
	global $AREA;
	$parentid = get_area_parentid($channelid, $areaid);
	return linkurl($linkurl);
}

function get_area_id($channelid, $areaname)
{
	global $db;
	$r = $db->get_one("select areaid from ".TABLE_INFO_AREA." where areaname='$areaname' and channelid=$channelid ");
	if($r['areaid'])
	{
		return $r['areaid'];
	}
	else
	{
		return 0;
	}
}

function get_area_parentid($channelid, $areaid)
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
		return get_area_parentid($channelid, $AREA[$areaid]['parentid']);
	}
}

function info_urlrule_select($name, $fileext = 'html', $type = 'cat', $urlruleid = 0, $property = '')
{
	global $mod;
	include PHPCMS_ROOT."/module/$mod/include/urlrule.inc.php";
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
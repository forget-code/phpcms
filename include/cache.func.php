<?php 
defined('IN_PHPCMS') or exit('Access Denied');

function cache_all()
{
	cache_table();
	require_once PHPCMS_CACHEDIR.'table.php'; 
	cache_common();
	cache_member_group();
	$modules = cache_module();
	$channelids = cache_channel(0);
	$keyids = array_merge($modules, $channelids);
	foreach($keyids as $keyid)
	{
		$catids = cache_categorys($keyid);
		if(is_array($catids))
		{
			foreach($catids as $catid)
			{
				cache_category($catid);
			}
		}
	}	
	cache_type(0);
	return TRUE;
}

function cache_common()
{
	global $db;
	$query = $db->query("SELECT module,name,iscore,iscopy,isshare,moduledir,moduledomain FROM ".TABLE_MODULE." WHERE disabled=0");
	while($r = $db->fetch_array($query))
	{
		$r['linkurl'] = '';
		if($r['module'] != 'phpcms' && $r['iscopy'] == 0) $r['linkurl'] = linkurl($r['moduledomain'] ? dir_path($r['moduledomain']) : $r['moduledir'].'/');
		unset($r['moduledomain']);
		$key = $r['module'];
		$data[$key] = $r;
	}
	$CACHE['module'] = $data;

	$data = array();
	$query = $db->query("SELECT channelid,module,channelname,channeldir,channeldomain,channelpic,introduce,style,islink,linkurl,cat_html_urlruleid,item_html_urlruleid,special_html_urlruleid,cat_php_urlruleid,item_php_urlruleid,special_php_urlruleid FROM ".TABLE_CHANNEL." WHERE disabled=0 ORDER by listorder");
	while($r = $db->fetch_array($query))
	{
		$r['linkurl'] = linkurl($r['linkurl']);
		$key = $r['channelid'];
		$data[$key] = $r;
	}
	$CACHE['channel'] = $data;

	$data = array();
    $r = $db->get_one("SELECT setting FROM ".TABLE_MODULE." WHERE module='phpcms'");
	$CACHE['phpcms'] = unserialize($r['setting']);

	$fields = array();
	$result = $db->query("SELECT * FROM ".TABLE_FIELD." ORDER BY fieldid");
    while($r = $db->fetch_array($result))
	{
		$tablename = $r['tablename'];
		$fields[$tablename] .= ','.$r['name'];
	}
	$CACHE['field'] = $fields;
	cache_write('common.php', $CACHE);
    return $CACHE;
}

function cache_update($action='')
{
	global $db;

	$data=array();

	switch($action)
	{
		case 'keylink';
			$query=$db->query("SELECT linktext,linkurl FROM ".TABLE_KEYLINK." where passed=1");
			while($r=$db->fetch_array($query)){
				  $data[]=$r;
			}
		break;

		case 'reword';
			$query = $db->query("SELECT word,replacement FROM ".TABLE_REWORD." where passed=1");
			while($r = $db->fetch_array($query))
			{
				$data[]=$r;
			}
		break;

		default:
			$actions = array('keylink','reword');
			array_map('cache_update', $actions);
			return TRUE;
	}
	cache_write('cache_'.$action.'.php', $data);
	return $data;
}

function cache_table()
{
	global $db,$CONFIG;
	$query = $db->query("SHOW TABLES FROM `".$CONFIG['dbname']."`");
	while($r = $db->fetch_row($query))
	{
		$table = $r[0];
		if(preg_match("/^".$CONFIG['tablepre']."/i", $table))
		{
			$tablename = str_replace($CONFIG['tablepre'], 'table_', $table);
			$data[$tablename] = $table;         
		}
	}
	$db->free_result($query);
	if(!is_dir(PHPCMS_CACHEDIR))
	{
		dir_create(PHPCMS_CACHEDIR);
		dir_create($CONFIG['templatescachedir']);
	}
	cache_write('table.php', $data , 'constant');
	return $data;
}

function cache_module($module = '')
{
	global $db;
	if($module)
	{
		$r = $db->get_one("SELECT setting,module,name,iscopy,moduledir,moduledomain FROM ".TABLE_MODULE." WHERE module='$module'");
		if($r['setting'])
		{
			$setting = unserialize($r['setting']);
		}
		$setting['name'] = $r['name'];
		$setting['moduledir'] = $r['moduledir'];
		$setting['moduledomain'] = $r['moduledomain'];
		$setting['linkurl'] = '';
		if($r['module'] != 'phpcms' && $r['iscopy'] == 0)
		{
			$setting['linkurl'] = linkurl($r['moduledomain'] ? dir_path($r['moduledomain']) : $r['moduledir'].'/');
            cache_categorys($module);
		}
		unset($r['moduledomain']);
		cache_write($module.'_setting.php', $setting);
		return $setting;
	}
	else
	{
		$query = $db->query("SELECT module FROM ".TABLE_MODULE." WHERE disabled=0 ORDER by moduleid");
		while($r = $db->fetch_array($query))
		{
			cache_module($r['module']);
			$modules[] = $r['module'];
        }
		return $modules;
	}
}

function cache_channel($channelid=0)
{
	global $db;
	if($channelid)
	{
		$data = $db->get_one("SELECT * FROM ".TABLE_CHANNEL." WHERE channelid=$channelid");
		if($data && !$data['islink'])
		{
			if($data['setting'])
			{
		        $setting = unserialize($data['setting']);
				unset($data['setting']);
				$data = is_array($setting) ? array_merge($data, $setting) : $data;
			}
			$data['linkurl'] = linkurl($data['linkurl']);
			cache_write('channel_'.$channelid.'.php', $data);
			cache_categorys($channelid);
			return $data;
		}
    }
	else
	{
		$query = $db->query("SELECT channelid FROM ".TABLE_CHANNEL." WHERE islink=0 AND disabled=0 ORDER by channelid");
		while($r = $db->fetch_array($query))
		{
			cache_channel($r['channelid']);
			$channelids[] = $r['channelid'];
		}
		return $channelids;
	}
}

function cache_categorys($keyid)
{
	global $db,$PHPCMS,$CHANNEL;
	$urlpre = '';
	if(is_numeric($keyid)) 
	{
		$keyid = intval($keyid);
		$module = $CHANNEL[$keyid]['module'];
        $sql = " channelid=$keyid ";
	}
	else
	{
        $sql = " module='$keyid' ";
	}
	$catids = $data = array();
    $query = $db->query("SELECT module,channelid,catid,catname,style,introduce,catpic,islink,catdir,linkurl,parentid,arrparentid,parentdir,child,arrchildid,items,itemordertype,itemtarget,ismenu,islist,ishtml,htmldir,prefix,urlruleid,item_prefix,item_html_urlruleid,item_php_urlruleid FROM ".TABLE_CATEGORY." WHERE $sql ORDER by listorder,catid");
    while($r = $db->fetch_array($query))
	{
		$r['linkurl'] = str_replace($PHPCMS['index'].'.'.$PHPCMS['fileext'], '', $r['linkurl']);
	    $r['linkurl'] = $urlpre ? preg_replace("|^".$urlpre."|", '', $r['linkurl']) : linkurl($r['linkurl']);
		$catid = $r['catid'];
        $data[$catid] = $r;
		$catids[] = $catid;
    }
	if($data) cache_write('categorys_'.$keyid.'.php', $data);
	return $catids;
}

function cache_category($catid)
{
	global $db,$PHPCMS;
	if(!$catid) return FALSE;
    $data = $db->get_one("SELECT * FROM ".TABLE_CATEGORY." WHERE catid=$catid");
	$setting = unserialize($data['setting']);
	unset($data['setting']);
	$data = is_array($setting) ? array_merge($data, $setting) : $data;
	$data['linkurl'] = linkurl(str_replace($PHPCMS['index'].'.'.$PHPCMS['fileext'], '', $data['linkurl']));
	cache_write('category_'.$catid.'.php', $data);
	return $data;
}

function cache_type($keyid=0)
{
	global $db;
	if($keyid)
	{
	    $result = $db->query("SELECT * FROM ".TABLE_TYPE." WHERE keyid='$keyid'");
	    $data = array();
	    while($r = $db->fetch_array($result))
	    {
			$r['introduce'] = $r['introduce']? $r['introduce']:'&nbsp;';
	    	$data[$r['typeid']] = $r;
	    }
	    if($data)
	    {
			cache_write('type_'.$keyid.'.php', $data);
	    }
		return $data;
	}
	else 
	{
		$modules = array();
		$query = $db->query("SELECT module FROM ".TABLE_MODULE." WHERE disabled=0 ORDER by moduleid");
		while($r = $db->fetch_array($query))
		{
			$modules[] = $r['module'];
        }		
		$channelids = array();
		$query = $db->query("SELECT channelid FROM ".TABLE_CHANNEL." WHERE islink=0 AND disabled=0 ORDER by channelid");
		while($r = $db->fetch_array($query))
		{
			$channelids[] = $r['channelid'];
		}
		$modulechannels = array_merge($modules,$channelids);
		foreach($modulechannels as $m)
		{
			$result = $db->query("SELECT * FROM ".TABLE_TYPE." WHERE keyid='$m'");
			$TYPE = array();
			while($r = $db->fetch_array($result))
			{
				$r['introduce'] = $r['introduce']? $r['introduce']:'&nbsp;';
				$TYPE[$r['typeid']] = $r;
			}
			cache_write('type_'.$m.'.php',$TYPE);
		}
		return $modulechannels;		
	}
}

function cache_member_group()
{
	global $db;
	$query = $db->query("SELECT * FROM ".TABLE_MEMBER_GROUP." ORDER BY groupid");
	while($r = $db->fetch_array($query))
	{
		$groupid = $r['groupid'];
		cache_write('member_group_'.$groupid.'.php', $r);
		$data[$groupid] = $r;
	}
	cache_write('member_group.php', $data);
	return $data;
}

function cache_banip()
{
	global $db,$PHP_TIME;
	$result = $db->query("SELECT ip,overtime FROM ".TABLE_BANIP." WHERE ifban=1 and overtime>=$PHP_TIME order by id desc ");
	while($r = $db->fetch_array($result))
	{
		$data[] = array('ip'=>$r['ip'],'overtime'=>$r['overtime']);
	}
	$db->free_result($result);
	cache_write('banip.php', $data);
	return $data;
}
?>

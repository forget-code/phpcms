<?php 
function cache_all()
{
	@set_time_limit(600);
	cache_common();
	cache_module();
	cache_model();
	cache_category();
	cache_area();
	cache_type();
	cache_member_group();
    cache_role();
	cache_author();
	cache_keyword();
	cache_copyfrom();
	cache_pos();
    cache_status();
	cache_workflow();
	tags_update();
	return TRUE;
}

function cache_common()
{
	global $db;
	$data = array();
	$result = $db->query("SELECT `module`,`name`,`path`,`url`,`iscore`,`version` FROM `".DB_PRE."module` WHERE `disabled`=0");
	while($r = $db->fetch_array($result))
	{
		if(!$r['path']) $r['path'] = $r['module'] == 'phpcms' ? '' : $r['module'].'/';
		if(!$r['url']) $r['url'] = $r['module'] == 'phpcms' ? '' : $r['module'].'/';
		$data[$r['module']] = $r;
	}
	$db->free_result($result);
	$CACHE['MODULE'] = $data;
	$data = array();
	$result = $db->query("SELECT * FROM `".DB_PRE."model` WHERE `disabled`=0");
	while($r = $db->fetch_array($result))
	{
		$data[$r['modelid']] = $r;
	}
	$db->free_result($result);
	$CACHE['MODEL'] = $data;
	$data = array();
	$result = $db->query("SELECT `catid`,`module`,`type`,`modelid`,`catname`,`style`,`image`,`catdir`,`url`,`parentid`,`arrparentid`,`parentdir`,`child`,`arrchildid`,`items`,`citems`,`pitems`,`ismenu`,`letter` FROM `".DB_PRE."category` WHERE 1 ORDER BY `listorder`,`catid`");
	while($r = $db->fetch_array($result))
	{
		$r['url'] = url($r['url']);
		$data[$r['catid']] = $r;
	}
	$db->free_result($result);
	$CACHE['CATEGORY'] = $data;
	$data = array();
	$result = $db->query("SELECT `typeid`,`modelid`,`module`,`name`,`style`,`typedir`,`url` FROM `".DB_PRE."type` WHERE 1 ORDER BY `listorder`,`typeid`");
	while($r = $db->fetch_array($result))
	{
		$data[$r['typeid']] = $r;
	}
	$db->free_result($result);
	$CACHE['TYPE'] = $data;
	$data = array();
	$result = $db->query("SELECT `areaid`,`name`,`style`,`parentid`,`arrparentid`,`child`,`arrchildid` FROM `".DB_PRE."area` WHERE 1 ORDER BY `listorder`,`areaid`");
	while($r = $db->fetch_array($result))
	{
		$data[$r['areaid']] = $r;
	}
	$db->free_result($result);
	$CACHE['AREA'] = $data;
	$data = array();
	$result = $db->query("SELECT `urlruleid`,`urlrule` FROM `".DB_PRE."urlrule` WHERE 1 ORDER BY `urlruleid`");
	while($r = $db->fetch_array($result))
	{
		$data[$r['urlruleid']] = $r['urlrule'];
	}
	$db->free_result($result);
	$CACHE['URLRULE'] = $data;
	$data = array();
    $r = $db->get_one("SELECT `setting` FROM `".DB_PRE."module` WHERE `module`='phpcms'");
	$setting = $r['setting'];
	eval("\$PHPCMS = $setting;");
	if($PHPCMS['siteurl'] =='') $PHPCMS['siteurl'] = SITE_URL;
	$CACHE['PHPCMS'] = $PHPCMS;
	cache_write('common.php', $CACHE);
    return $CACHE;
}

function cache_module()
{
	global $db;
	$data = array();
	$result = $db->query("SELECT `module`,`name`,`path`,`url`,`iscore`,`version`,`publishdate`,`installdate`,`updatedate`,`setting` FROM `".DB_PRE."module` WHERE `disabled`=0");
	while($r = $db->fetch_array($result))
	{
		if(!$r['path']) $r['path'] = $r['module'] == 'phpcms' ? '' : $r['module'].'/';
		if(!$r['url'])
		{
			$r['url'] = $r['module'] == 'phpcms' ? '' : $r['module'].'/';
			$db->query("UPDATE `".DB_PRE."module` SET `url`='$r[url]' WHERE module='$r[module]' LIMIT 1");
		}

		if($r['setting'])
		{
			$setting = $r['setting'];
			eval("\$setting = $setting;"); 
			unset($r['setting']);
			if(is_array($setting)) $r = array_merge($r, $setting);
        }
		cache_write('module_'.$r['module'].'.php', $r);
	}
	$db->free_result($result);
}

function cache_model()
{
	cache_table(DB_PRE.'model', '*', '', '', 'modelid', 1);
}

function cache_category()
{
	cache_table(DB_PRE.'category', '*', '', '', 'listorder,catid', 1);
}

function cache_type()
{
	cache_table(DB_PRE.'type', '*', '', '', 'listorder,typeid', 1);
}

function cache_area()
{
	cache_table(DB_PRE.'area', '*', '', '', 'listorder,areaid', 1);
}

function cache_member_group()
{
	cache_table(DB_PRE.'member_group', '*', '', '', 'groupid', 1);
	cache_table(DB_PRE.'member_group', '*', 'name', '', 'groupid', 0);
}

function cache_role()
{
	cache_table(DB_PRE.'role', '*', 'name', '', 'listorder,roleid');
}

function cache_author()
{
	cache_table(DB_PRE.'author', '*', 'name', '', 'listorder,authorid', 0, 100);
}

function cache_keyword()
{
	cache_table(DB_PRE.'keyword', '*', 'tag', '', 'listorder,usetimes', 0, 100);
}

function cache_copyfrom()
{
	cache_table(DB_PRE.'copyfrom', '*', '', '', 'listorder,usetimes', 0, 100);
}

function cache_pos()
{
	cache_table(DB_PRE.'position', '*', 'name', '', 'listorder,posid', 0);
}

function cache_status()
{
	global $db;
	$array = array();
	$result = $db->query("SELECT * FROM `".DB_PRE."status` ORDER BY `status` ASC");
	while($r = $db->fetch_array($result))
	{
		$array[$r['status']] = $r['name'];
	}
	cache_write('status.php', $array);
	return $array;
}

function cache_workflow()
{
	global $db;
	$array = array();
	$result = $db->query("SELECT * FROM `".DB_PRE."workflow` ORDER BY `workflowid` ASC");
	while($r = $db->fetch_array($result))
	{
		$array[$r['workflowid']] = $r['name'];
	}
	cache_write('workflow.php', $array);
	return $array;
}

function cache_formguid()
{
	cache_table(DB_PRE.'formguide', '*', '', '', 0);
}

function cache_table($table, $fields = '*', $valfield = '', $where = '', $order = '', $iscacheline = 0, $number = 0)
{
	global $db;
	$keyfield = $db->get_primary($table);
	$data = array();
	if($where) $where = " WHERE $where";
	if(!$order) $order = $keyfield;
	$limit = $number ? "LIMIT 0,$number" : '';
	$result = $db->query("SELECT $fields FROM `$table` $where ORDER BY $order $limit");
	$table = preg_replace("/^".DB_PRE."(.*)$/", "\\1", $table);
	while($r = $db->fetch_array($result))
	{
		if(isset($r['setting']) && !empty($r['setting']))
		{
			$setting = $r['setting'];
			eval("\$setting = $setting;"); 
			unset($r['setting']);
			if(is_array($setting)) $r = array_merge($r, $setting);
        }
		$key = $r[$keyfield];
		$value = $valfield ? $r[$valfield] : $r;
		$data[$key] = $value;
		if($iscacheline) cache_write($table.'_'.$key.'.php', $value);
	}
	$db->free_result($result);
	cache_write($table.'.php', $data);
}

?>
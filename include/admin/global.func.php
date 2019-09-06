<?php
function set_config($config)
{
	if(!is_array($config)) return FALSE;
	$configfile = PHPCMS_ROOT.'include/config.inc.php';
	if(!is_writable($configfile)) showmessage('Please chmod ./include/config.inc.php to 0777 !');
	$pattern = $replacement = array();
	foreach($config as $k=>$v)
	{
		$pattern[$k] = "/define\(\s*['\"]".strtoupper($k)."['\"]\s*,\s*([']?)[^']*([']?)\s*\)/is";
        $replacement[$k] = "define('".$k."', \${1}".$v."\${2})";
	}
	$str = file_get_contents($configfile);
	$str = preg_replace($pattern, $replacement, $str);
	return file_put_contents($configfile, $str);
}

function module_setting($module, $setting)
{
	global $db,$MODULE;
	if(!is_array($setting) || !array_key_exists($module, $MODULE)) return FALSE;
	if(isset($setting['url']))
	{
		$url = $setting['url'];
		if($setting['url'] && substr($url, -1) != '/')
		{
			$url .= '/';
		}
        $db->query("UPDATE ".DB_PRE."module SET url='$url' WHERE module='$module'");
		unset($setting['url']);
	}
	$setting = new_stripslashes($setting);
	$setting = addslashes(var_export($setting, TRUE));
    $db->query("UPDATE ".DB_PRE."module SET setting='$setting' WHERE module='$module'");
	cache_module();
	cache_common();
	return TRUE;
}

function filter_write($filter_word)
{
	$filter_word = array_map('trim', explode("\n", str_replace('*', '.*', $filter_word)));
    return cache_write('filter_word.php', $filter_word);
}

function file_select($textid, $catid = 0, $isimage = 0)
{
	return "<input type='button' value='浏览...' style='cursor:pointer;' onclick=\"file_select('$textid', $catid, $isimage)\">";
}

function ip_access($ip, $accesslist)
{
	$regx = str_replace(array("\r\n", "\n", ' '), array('|', '|', ''), preg_quote($accesslist, '/'));
	return preg_match("/^".$regx."/", $ip) ? false : true;
}

function admin_template($module = 'phpcms', $template = 'index', $istag = 0)
{
	require_once 'template_edit.func.php';
	$compiledtplfile = TPL_CACHEPATH.$module.'_'.$template.'.edit.php';
	template_edit_compile($module, $template, $istag);
	return $compiledtplfile;
}

function admin_tpl($file = 'index', $module = '')
{
	global $mod,$MODULE,$CONFIG,$PHPCMS;
	if(!$module) $module = $mod;
	return PHPCMS_ROOT.$MODULE[$module]['path'].'admin/templates/'.$file.'.tpl.php';
}

function admin_menu($menuname, $submenu = array())
{
	global $mod,$file,$action;
    $menu = $s = '';
    foreach($submenu as $m)
	{
		$title = isset($m[2]) ? "title='".$m[2]."'" : "";
		$menu .= $s."<a href='".$m[1]."' ".$title.">".$m[0]."</a>";
        $s = ' | ';
	}
	return include PHPCMS_ROOT.'admin/templates/admin_menu.tpl.php';
}

function admin_log()
{
	global $db,$mod,$file,$action,$modelid,$catid,$specialid,$contentid,$_userid;
	$querystring = addslashes(QUERY_STRING);
	return $db->query("INSERT INTO `".DB_PRE."admin_log`(`module`,`file`,`action`,`catid`,`specialid`,`contentid`,`querystring`,`userid`,`updatetime`,`ip`) VALUES('$mod','$file','$action','$catid','$specialid','$contentid','$querystring','$_userid','".TIME."','".IP."')");
}

function fetch_table_struct($tablename, $result = 'FIELD')
{
	global $db;
	$datas = array();
	$query = $db->query("DESCRIBE ".DB_PRE."$tablename");
	while($data = $db->fetch_array($query))
	{
		$datas[$data['Field']] = $result == 'FIELD' ? $data['Field'] : $data;
	}
	return $datas;
}

function sql_execute($sql)
{
	global $db;
    $sqls = sql_split($sql);
	if(is_array($sqls))
    {
		foreach($sqls as $sql)
		{
			if(trim($sql) != '')
			{
				$db->query($sql);
			}
		}
	}
	else
	{
		$db->query($sqls);
	}
	return true;
}

function sql_split($sql)
{
	global $db;
	if($db->version() > '4.1' && DB_CHARSET)
	{
		$sql = preg_replace("/TYPE=(InnoDB|MyISAM|MEMORY)( DEFAULT CHARSET=[^; ]+)?/", "TYPE=\\1 DEFAULT CHARSET=".DB_CHARSET,$sql);
	}
	if(DB_PRE != "phpcms_") $sql = str_replace("phpcms_", DB_PRE, $sql);
	$sql = str_replace("\r", "\n", $sql);
	$ret = array();
	$num = 0;
	$queriesarray = explode(";\n", trim($sql));
	unset($sql);
	foreach($queriesarray as $query)
	{
		$ret[$num] = '';
		$queries = explode("\n", trim($query));
		$queries = array_filter($queries);
		foreach($queries as $query)
		{
			$str1 = substr($query, 0, 1);
			if($str1 != '#' && $str1 != '-') $ret[$num] .= $query;
		}
		$num++;
	}
	return($ret);
}

function sql_dumptable($table, $startfrom = 0, $currsize = 0)
{
	global $db, $sizelimit, $startrow, $sqlcompat, $sqlcharset, $dumpcharset;
	if(!isset($tabledump)) $tabledump = '';
	$offset = 100;
	if(!$startfrom)
	{
		$tabledump = "DROP TABLE IF EXISTS $table;\n";
		$createtable = $db->query("SHOW CREATE TABLE $table");
		$create = $db->fetch_row($createtable);
		$tabledump .= $create[1].";\n\n";
		if($sqlcompat == 'MYSQL41' && $db->version() < '4.1')
		{
			$tabledump = preg_replace("/TYPE\=([a-zA-Z0-9]+)/", "ENGINE=\\1 DEFAULT CHARSET=".$dumpcharset, $tabledump);
		}
		if($db->version() > '4.1' && $sqlcharset)
		{
			$tabledump = preg_replace("/(DEFAULT)*\s*CHARSET=[a-zA-Z0-9]+/", "DEFAULT CHARSET=".$sqlcharset, $tabledump);
		}
	}
	$tabledumped = 0;
	$numrows = $offset;
	while($currsize + strlen($tabledump) < $sizelimit * 1000 && $numrows == $offset)
	{
		$tabledumped = 1;
		$rows = $db->query("SELECT * FROM $table LIMIT $startfrom, $offset");
		$numfields = $db->num_fields($rows);
		$numrows = $db->num_rows($rows);
		while ($row = $db->fetch_row($rows))
		{
			$comma = "";
			$tabledump .= "INSERT INTO $table VALUES(";
			for($i = 0; $i < $numfields; $i++)
			{
				$tabledump .= $comma."'".mysql_escape_string($row[$i])."'";
				$comma = ",";
			}
			$tabledump .= ");\n";
		}
		$startfrom += $offset;
	}
	$startrow = $startfrom;
	$tabledump .= "\n";
	return $tabledump;
}

function tags_update($modules = array())
{
	global $MODULE;
    $html = $tags = array();
    if(!$modules) $modules = array_keys($MODULE);
	foreach($modules as $module)
	{
		$tags_config = @include TPL_ROOT.TPL_NAME.'/'.$module.'/tag_config.inc.php';
		if(empty($tags_config) || !isset($tags_config) || !is_array($tags_config)) continue;
		foreach($tags_config as $tagname=>$tag)
		{
			if($tag['tagcode'])
			{
				$tags[$tagname] = $tag['tagcode'];
			}
			else
			{
				foreach ($tag['var_name'] as $k=>$v)
				{
					$r['var'][$v] = $tag['var_value'][$k];
					$setting = $r['var'];
				}
				$setting = str_replace("\n", '', var_export($setting, true));
				$tags[$tagname] = "tag('$module', '$template', \"$sql\", $page, $number, $setting)";
			}
		}
	}
	cache_write('tag.inc.php', $tags, TPL_ROOT.TPL_NAME.'/');
}

function tag_update($modules = array())
{
	global $MODULE;
	if(!$modules) $modules = array_keys($MODULE);
	require_once 'admin/tag.class.php';
	if(!file_exists(TPL_ROOT.TPL_NAME.'/tag.inc.php')) return false;
	foreach($modules as $module)
	{
		$tags_config = @include TPL_ROOT.TPL_NAME.'/'.$module.'/tag_config.inc.php';
		$tag = new tag($module);
		foreach($tags_config as $tagname=>$tag_config)
		{
			$tag->update($tagname, $tag_config, $setting = array());
		}
	}
	return true;
}

function tag_types()
{
	global $db, $MODULE;
	foreach($MODULE as $mod)
	{
		$r = $db->get_one("SELECT `tagtypes` FROM `".DB_PRE."module` WHERE module='$mod[module]'");
		if(!empty($r['tagtypes']))
		{
			$tag = $r['tagtypes'];
			eval("\$tag=$tag;");
			$tagtypes = empty($tagtypes) ? $tag : array_merge($tagtypes, $tag);;
		}
	}
	return $tagtypes;
}

function phpcms_tm($templateid = 0)
{
	global $setting;
	$qqs = $msns = $skypes = $taobaos = $alibabas = array();
    if($setting['qq']) $qqs = explode(',', $setting['qq']);
    if($setting['msn']) $msns = explode(',', $setting['msn']);
    if($setting['skype']) $skypes = explode(',', $setting['skype']);
    if($setting['taobao']) $taobaos = explode(',', $setting['taobao']);
    if($setting['alibaba']) $alibabas = explode(',', $setting['alibaba']);
	ob_start();
	include template('phpcms', 'phpcms_tm');
	$data = ob_get_contents();
	ob_clean();
	file_put_contents(CACHE_PATH.'tm.html', $data);
}
?>
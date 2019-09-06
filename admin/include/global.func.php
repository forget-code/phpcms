<?php 
function set_config($config)
{
	if(!is_array($config)) return FALSE;
	if(!is_writable(PHPCMS_ROOT.'/config.inc.php')) showmessage('Please chmod ./config.inc.php to 0777 !');
	$configstr = file_get_contents(PHPCMS_ROOT.'/config.inc.php');
	foreach($config as $k=>$v)
	{
	    $configstr = preg_replace("/[$]CONFIG\['$k'\]\s*\=\s*[\"'].*?[\"']/is", "\$CONFIG['$k'] = '$v'", $configstr);
	}
	return file_put_contents(PHPCMS_ROOT.'/config.inc.php', $configstr);
}

function ip_access($ip, $accesslist)
{
	return preg_match("/^(".str_replace(array("\r\n", "\n", ' '), array('|', '|', ''), preg_quote($accesslist, '/')).")/", $ip);
}

function admintpl($file = 'index', $module = '')
{
	global $module_dir,$CONFIG,$PHPCMS;
	if($module) $module_dir = moduledir($module);
	return PHPCMS_ROOT.'/'.$module_dir.'/admin/templates/'.$file.'.tpl.php';
}

function adminmenu($menuname, $submenu=array())
{
	global $mod,$file,$action;
    $menu = $s = '';
    foreach($submenu as $m)
	{
		$title = isset($m[2]) ? "title='".$m[2]."'" : "";
		$menu .= $s."<a href='".$m[1]."' ".$title.">".$m[0]."</a>";
        $s = ' | ';
	}
	return include PHPCMS_ROOT.'/admin/templates/adminmenu.tpl.php';
}

function showgroup($type = 'select', $name = 'groupid', $checked = '', $perline = 5)
{
    global $db,$LANG;
	$checked = $checked ? explode(',',$checked) : array();
	$i = 0;
	$select = $type == 'select' ? 1 : 0;
	$data = $select ? "<option value='0'>".$LANG['select_user_group']."</option>\n" : "";
	$result = $db->query("SELECT groupid,groupname FROM ".TABLE_MEMBER_GROUP." ORDER BY groupid");
	while($r = $db->fetch_array($result))
	{
		if($select)
		{
			$selected = in_array($r['groupid'],$checked) ? 'selected' : '';
			$data .= "<option value='".$r['groupid']."' $selected>".$r['groupname']."</option>\n";
		}
		else
		{
			$selected = in_array($r['groupid'],$checked) ? 'checked' : '';
            if($i%$perline == 0) $data .= "<tr>\n";
            $data .= "<td><input type='".$type."' name='".$name."' value='".$r['groupid']."' $selected>".$r['groupname']."</td>\n";
            if($i%$perline == ($perline-1)) $data .= "</tr>\n";
		}
		$i++;
	}
	$data = $select ? "<select name='".$name."'>".$data."</select>" : "<table width='100%'>".$data."</table>";
	return $data;
}

function showtpl($module = 'phpcms', $type = 'index', $name = 'templateid', $templateid = 0, $property = '')
{
	global $CONFIG,$LANG;
    $templatedir = PHPCMS_ROOT."/templates/".$CONFIG['defaulttemplate']."/".$module."/";
	include $templatedir."templatenames.php";
    $content = "";
	$files = glob($templatedir."/*.html");
	foreach($files as $tplfile)
	{
		$tplfile = basename($tplfile);
		$tpl = str_replace(".html","",$tplfile);
		if($type==$tpl || preg_match("/^".$type."-(.*)/i",$tpl))
		{
			$selected = ($templateid && $tpl==$templateid) ? 'selected' : '';
            $templatename = (isset($templatenames[$tplfile]) && $templatenames[$tplfile]) ? $templatenames[$tplfile] : $tpl;
			$content .= "<option value='".$tpl."' ".$selected.">".$templatename."</option>\n";
		}
	}
	$content = "<select name='".$name."' ".$property."><option value='0'>".$LANG['system_default_template']."</option>\n".$content."</select>";
	return $content;
}

function showskin($name = 'skinid', $skinid = '', $property = '')
{
	global $CONFIG,$LANG;
    $skindir = PHPCMS_ROOT.'/templates/'.$CONFIG['defaulttemplate'].'/skins/';
	@include $skindir.'skinnames.php';
    $content = '';
	$dirs = glob($skindir.'/*');
	if(is_array($dirs))
	{
		foreach($dirs as $skin)
		{
			if(is_file($skin)) continue;
			$skin = basename($skin);
			$selected = ($skinid && $skin == $skinid) ? 'selected' : '';
			$skinname = (isset($skinnames[$skin]) && $skinnames[$skin]) ? $skinnames[$skin] : $skin;
			$content .= "<option value='".$skin."' ".$selected.">".$skinname."</option>\n";
		}
	}
	$content = "<select name='".$name."' ".$property.">\n<option value='0'>".$LANG['system_default_style']."</option>\n".$content."</select>";
	return $content;
}

function adminlog()
{
	global $db,$PHP_QUERYSTRING,$mod,$file,$action,$channelid,$_username,$PHP_IP,$PHP_TIME;
	$querystring = addslashes($PHP_QUERYSTRING);
	$channelid = $channelid>0 ? $channelid : 0;
	$db->query("INSERT INTO ".TABLE_LOG."(`mod`,`file`,`action`,`channelid`,`querystring`,`username`,`addtime`,`ip`) VALUES('$mod','$file','$action','$channelid','$querystring','$_username','$PHP_TIME','$PHP_IP')");
}

function admin_list($field = '', $search = '', $grade = -1)
{
	global $db;
    $sql = '';
	if($field && $search) $sql .= " AND $field like '%,$search,%' ";
	if($grade > -1) $sql .= " AND grade=$grade ";
	$admins = array();
	$result = $db->query("SELECT userid,username,grade FROM ".TABLE_ADMIN." WHERE disabled=0 $sql ORDER BY grade,userid");
	while($r = $db->fetch_array($result))
	{
		$admins[] = $r;
	}
	$db->free_result($result);
	return $admins;
}

function admin_users($field = '', $search = '', $grade = -1)
{
	global $grades;
	$users = admin_list($field, $search, $grade);
	$arr = array();
	foreach($users as $k=>$u)
	{
		$arr[] = "<a href='?mod=phpcms&file=admin&action=view&userid={$u['userid']}' title='{$grades[$u['grade']]}'>{$u['username']}</a>";
	}
	return implode(' , ', $arr);
}

function module_setting($module, $setting)
{
	global $db,$MODULE,$LANG;
	if(!is_array($setting) || !array_key_exists($module,$MODULE)) return FALSE;
	if(isset($setting['moduledomain']))
	{
		$moduledomain = $setting['moduledomain'];
        $db->query("UPDATE ".TABLE_MODULE." SET moduledomain='$moduledomain' WHERE module='$module'");
		unset($setting['moduledomain']);
	}
	$setting = addslashes(serialize(new_stripslashes($setting)));
    $db->query("UPDATE ".TABLE_MODULE." SET setting='$setting' WHERE module='$module'");
	cache_module($module);
	cache_common();
	return TRUE;
}

function dir_copy($fromdir, $todir)
{
	$fromdir = dir_path($fromdir);
	$todir = dir_path($todir);
	if(!is_dir($fromdir)) return FALSE;
	if(!is_dir($todir)) dir_create($todir);
	$list = glob($fromdir.'*');
	foreach($list as $v)
	{
		$path = $todir.basename($v);
		if(file_exists($path) && !is_writable($path)) dir_chmod($path);
		if(is_dir($v))
		{
		    dir_copy($v, $path);
		}
		else
		{
			copy($v, $path);
			chmod($path, 0777);
		}
	}
    return TRUE;
}

function dir_chmod($dir, $mode = 777, $require = 0)
{
    global $PHPCMS, $ftp;
    if(!$PHPCMS['enableftp']) return FALSE;
    if(!is_object($ftp)) require_once PHPCMS_ROOT.'/include/ftp.inc.php';
	if(!$require) $require = substr($dir, -1) == '*' ? 2 : 0;
	if($require)
	{
		if($require == 2) $dir = substr($dir, 0, -1);
	    $dir = dir_path($dir);
		$list = glob($dir.'*');
		$files = array();
		foreach($list as $v)
		{
			if(is_dir($v))
			{
				dir_chmod($v, $mode, 1);
			}
			else
			{
				$files[] = basename($v);
			}
		}
		if($files)
		{
			$ftp->set_dir($dir);
			foreach($files as $file)
			{
				$ftp->chmod($file, $mode);
			}
		}
	}
	if(is_dir($dir))
	{
		$ftp->chmod($dir, $mode);
	}
	else
	{
		$ftp->set_dir(dirname($dir).'/');
		$ftp->chmod(basename($dir), $mode);
	}
}

function dir_delete($dir)
{
	$dir = dir_path($dir);
	if(!is_dir($dir)) return FALSE;
	$systemdirs = array(PHPCMS_ROOT.'/admin/',PHPCMS_ROOT.'/admin/include/',PHPCMS_ROOT.'/include/',PHPCMS_ROOT.'/data/',PHPCMS_ROOT.'/module/',PHPCMS_ROOT.'/member/',PHPCMS_ROOT.'/templates/',PHPCMS_ROOT.'/images/');
	if(substr($dir, 0, 1) == '.' || in_array($dir, $systemdirs)) exit("Cannot remove system dir $dir !");
	$list = glob($dir.'*');
	foreach($list as $v)
	{
		is_dir($v) ? dir_delete($v) : @unlink($v);
	}
    return @rmdir($dir);
}

function sql_split($sql)
{
	global $CONFIG, $db;
	if($db->version() > '4.1' && $CONFIG['dbcharset'])
	{
		$sql = preg_replace("/TYPE=(InnoDB|MyISAM)( DEFAULT CHARSET=[^; ]+)?/", "TYPE=\\1 DEFAULT CHARSET=".$CONFIG['dbcharset'],$sql);
	}
	if($CONFIG['tablepre'] != "phpcms_") $sql = str_replace("phpcms_", $CONFIG['tablepre'], $sql);
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

function array_save($array, $arrayname, $file)
{
	$data = var_export($array,TRUE);
	$data = "<?php\n".$arrayname." = ".$data.";\n?>";
	return file_put_contents($file,$data);
}

function tags_update($modules = array())
{
	global $CONFIG, $MODULE;
    $html = $tags = array();
    if(!$modules) $modules = array_keys($MODULE);
	foreach($modules as $module)
	{
		if(!@include PHPCMS_ROOT.'/templates/'.$CONFIG['defaulttemplate'].'/'.$module.'/tags_config.php') continue;
		foreach($tags_config as $tagname=>$tag)
		{
			$tags[$tagname] = $tag['longtag'];
			$newtag = str_replace(array('$channelid','$keyid','$mod'), '', $tags[$tagname]);
			if(strpos($newtag, '$') === FALSE)
			{
				if($MODULE[$module]['iscopy'])
				{
					if(strpos($tags[$tagname], '$channelid') === FALSE)
					{
						preg_match("/\([^,]+,([0-9]+),/i", $tags[$tagname], $matchs);
						$keyid = $matchs[1];
					}
					else
					{
						$keyid = '$channelid';
					}
				}
				else
				{
					$keyid = "'$module'";
				}
				$html[$tagname] = "$keyid, '$tagname'";
			}
		}
	}
	array_save($tags, "\$tags", PHPCMS_ROOT.'/templates/'.$CONFIG['defaulttemplate'].'/tags.php');
	array_save($html, "\$html", PHPCMS_ROOT.'/templates/'.$CONFIG['defaulttemplate'].'/html.php');
}

function admin_catpos($catid, $s = ' >> ')
{
	global $CATEGORY,$mod,$file,$action,$channelid,$job,$LANG;
	$channelidpar = $channelid ? "&channelid=$channelid" : "";
	$pos = "<a href=\"?mod=$mod&file=$file&action=$action&job=$job&catid=0{$channelidpar}\">".$LANG['all_category']."</a>";
	if(!$catid) return $pos;
    $arrparentid = $CATEGORY[$catid]['arrparentid'];
	$arrparentid = explode(',', $arrparentid);
	$arrparentid[] = $catid;
	foreach($arrparentid as $pcatid)
	{
		if($pcatid > 0)
		{
			$catname = $CATEGORY[$pcatid]['catname'];
			$pos .= $s."<a href=\"?mod=$mod&file=$file&action=$action&job=$job&catid=$pcatid{$channelidpar}\">$catname</a>";
		}
	}
	return $pos;
}

function bytes2x($size)
{
	$result = '';
	if($size < 1024)
	{
		$result = round($size, 2).' B';
	}
	elseif($size < 1024*1024)
	{
		$result = round($size/1024, 2).' KB';
	}
	elseif($size < 1024*1024*1024)
	{
		$result = round($size/1024/1024, 2).' MB';
	}
	elseif($size < 1024*1024*1024*1024)
	{
		$result = round($size/1024/1024/1024, 2).' GB';
	}
	else
	{
		$result = round($size/1024/1024/1024/1024, 2).' TB';
	}
	return $result;
}

function add_freelink($type, $arr = array())
{
	$types = cache_read('freelink_type.php');
	if(!array_key_exists($type, $types)) return;
	$freelinks = cache_read('freelink_'.urlencode($type).'.php');
	foreach($freelinks as $v)
	{
		if($v['title'] == $arr['title']) return;
	}
	$number = $types[$type]['number'];
	$arr['order'] = 0;
	$newlinks = array();
	$newlinks[0] = $arr;
	$max = $number > count($freelinks) ? count($freelinks) : $number-1;

	for($i = 1; $i <= $max; $i++)
	{
		$freelinks[$i-1]['order'] += 1;
		$newlinks[$i] = $freelinks[$i-1];
	}
	cache_write('freelink_'.urlencode($type).'.php', $newlinks);
	update_freelink($type);
}

function update_freelink($type)
{
	$types = cache_read('freelink_type.php');
    $freelinks = cache_read('freelink_'.urlencode($type).'.php');
	foreach($freelinks as $k=>$freelink)
	{
		$freelinks[$k]['image'] = linkurl($freelink['image']);
	}
	if($types[$type]['showtype'] == 'freelink_slide' || $types[$type]['showtype'] == 'freelink_slide-3d')
	{
		$flash_pics = '';
		$flash_links = '';
		$flash_texts = '';
		foreach($freelinks as $k=>$freelink)
		{
			$s = $k ? '|' : '';
			$flash_pics .= $s.$freelink['image'];
			$flash_links .= $s.$freelink['url'];
			$flash_texts .= $s.$freelink['title'];
		}
	}
	$imgwidth = $types[$type]['width'];
	$imgheight = $types[$type]['height'];
	ob_start();
	include template('phpcms', $types[$type]['showtype']);
	$data = ob_get_contents();
	ob_clean();
	$filename = PHPCMS_ROOT.'/data/freelink/'.urlencode($type).'.html';
	file_put_contents($filename, $data);
	chmod($filename, 0777);
	require PHPCMS_ROOT.'/admin/include/tag.class.php';
	$tag = new tag('phpcms');
	$tag_config = array('type'=> $type, 'func' => 'phpcms_freelink','keyid' => 'phpcms');
	$tag->update($type, $tag_config, 'phpcms_freelink($type)');
}
?>
<?php
defined('IN_PHPCMS') or exit('Access Denied');

$importdir = PHPCMS_ROOT.'/data/import/article/';

$submenu = array (
	array($LANG['manage_article_data_config'], '?mod='.$mod.'&file='.$file.'&action=manage&channelid='.$channelid),
	array($LANG['add_article_data_config'], '?mod='.$mod.'&file='.$file.'&action=setting&channelid='.$channelid),
	array($LANG['load_data_config'], '?mod='.$mod.'&file='.$file.'&action=upload&channelid='.$channelid)
);
$menu = adminmenu($LANG['manage_article_data'], $submenu);

switch($action)
{
	case 'import':
		include $importdir.$name.'.php';
		$setting = $settings[$name];

        if($setting['timelimit']) set_time_limit($setting['timelimit']);

		$sameserver = 0;
        if($setting['dbfrom'])
	    {
			if($setting['database'] == 'mssql')
			{
				if(!extension_loaded('mssql')) showmessage($LANG['mssql_extension_do_not_loaded']);
				
				include PHPCMS_ROOT.'/include/db_'.$setting['database'].'.class.php';

				$sqldb = new db_mssql;
				$sqldb->connect($setting['dbhost'], $setting['dbuser'], $setting['dbpw'], $setting['dbname']);
			}
			elseif($setting['database'] == 'access')
			{
				include PHPCMS_ROOT.'/include/db_'.$setting['database'].'.class.php';

				$sqldb = new db_access;
				$sqldb->connect($setting['dbhost'], $setting['dbuser'], $setting['dbpw'], $setting['dbname']);
			}
			else
			{
				require PHPCMS_ROOT.'/config.inc.php';
				if($CONFIG['dbhost'] == $setting['dbhost'] && $CONFIG['dbuser'] == $setting['dbuser'] && $CONFIG['dbpw'] == $setting['dbpw'])
				{
					$sameserver = 1;
					$sqldb = &$db;
				}
				else
				{
					$sqldb = new db_mysql;
					$sqldb->connect($setting['dbhost'], $setting['dbuser'], $setting['dbpw'], $setting['dbname']);
				}
			}
		}
		else
	    {
			$sqldb = &$db;
		}

		$table = trim($setting['table']);
		$firsttable = '';
		$pos = strpos($table, ',');
		if($pos)
	    {
		    $startpos = intval(strpos($table, ' '));
            $firsttable = trim(substr($table, $startpos, $pos-$startpos));
		}

		include MOD_ROOT.'/include/import_fields.inc.php';
		include MOD_ROOT.'/include/import_funcs.func.php';

        $selectfields = $insertfields = $insertvalues = '';
        foreach($fields as $field=>$v)
        {
			if($field == 'articleid' && $setting['isuseoldid'] == 0) continue;
			$oldfield = trim($setting[$field]['field']);
			$defaultvalue = trim($setting[$field]['value']);
			$func = trim($setting[$field]['func']);

			if($oldfield)
			{
				$oldfields[$oldfield] = $field;
			}
			if($oldfield || $defaultvalue)
			{
				if($field == 'content') continue;
				$insertfields .= ",$field";
				if($defaultvalue)
				{
				    $insertvalues .= ",'".$defaultvalue."'";
				}
				elseif($oldfield && $func)
				{
					$insertvalues .= ",'\".".$func."(\$$field).\"'";
				}
				else
				{
				    $insertvalues .= ",'\$$field'";
				}
			}
        }
        $insertfields = substr($insertfields, 1);
        $insertvalues = substr($insertvalues, 1);

		$offset = isset($offset) ? $offset : 0;
		$number = $setting['number'];

        $limit = '';
		if($number) $limit = " LIMIT $offset,$number";
		$maxid = intval($setting['maxid']);
		$idfield = $setting['articleid']['field'];
		$condition = str_replace('$maxid', $maxid, $setting['condition']);
        if($condition) $condition = " WHERE $condition";

		if($offset == 0)
	    {
			if($sameserver) $sqldb->select_db($setting['dbname']);
			$r = $sqldb->get_one("SELECT count(*) AS total FROM $table $condition");
			$total = $r['total'];
		}

		$idfield = $setting['articleid']['field'];
		$orderby = $firsttable ? $firsttable.'.'.$idfield : $idfield;

		$selectfield = $setting['selectfield'] ? $setting['selectfield'] : '*';

		if($sameserver) $sqldb->select_db($setting['dbname']);
		$result = $sqldb->query("SELECT $selectfield FROM $table $condition ORDER BY $orderby $limit");
		$importnum = $sqldb->num_rows($result);
		while($r = $sqldb->fetch_array($result))
		{
			$r = new_addslashes($r,1);
			foreach($r as $k=>$v)
			{
				if(isset($oldfields[$k]))
				{
					$k = $oldfields[$k];
					$r[$k] = $v;
				}
			}
			$maxid = max($maxid, $r[$idfield]);
			extract($r);
			eval("\$values = \"$insertvalues\";");
			if($sameserver) $db->select_db($CONFIG['dbname']);
			$db->query("INSERT INTO ".channel_table('article', $channelid)."($insertfields) VALUES($values)");
			$articleid = $db->insert_id();
			//文章数据存储模式
			if($MOD['storage_mode'] < 3) $db->query("INSERT INTO ".channel_table('article_data', $channelid)."(articleid,content) VALUES('$articleid','$content')");
			if($MOD['storage_mode'] > 1) txt_update($channelid, $articleid, $content);
			if($MOD['storage_mode'] == 3) $db->query("INSERT INTO ".channel_table('article_data', $channelid)."(articleid,content) VALUES('$articleid','')");
		}
		$sqldb->free_result($result);
		$sqldb->close();

 		$name = $setting['name'];

        $finished = 0;
		if($number && ($importnum < $number))
	    {
			$finished = 1;
			$setting['maxid'] = $maxid;
			$setting['importtime'] = $PHP_TIME;
			array_save($setting , '$settings[\''.$name.'\']', $importdir.$name.'.php');
		}

		$newoffset = $offset + $number;

		$start = $offset+1;
		$end = $finished ? ($offset + $importnum) : $newoffset;

        $forward = $finished ? "?mod=$mod&file=$file&action=manage&channelid=$channelid" : "?mod=$mod&file=$file&action=$action&channelid=$channelid&name=$name&offset=$newoffset&total=$total";
        showmessage($LANG['total_import'].$total.$LANG['record'].'<br />'.$LANG['from'].$start.$LANG['to'].$end.$LANG['load_data_success'], $forward);
        break;

	case 'setting':

		if($dosubmit)
		{
			if(empty($setting['name']) || !preg_match('/^[a-zA-Z][0-9a-zA-Z]*$/i',$setting['name']))
			{
				showmessage($LANG['invalid_name']);
			}
			
			$setting['edittime'] = $PHP_TIME;
			array_save($setting , '$settings[\''.$setting['name'].'\']', $importdir.$setting['name'].'.php');
			showmessage($LANG['data_config_load_save_success'], "?mod=$mod&file=$file&action=manage&channelid=$channelid");
		}
		else
		{
			include PHPCMS_ROOT.'/config.inc.php';
			include MOD_ROOT.'/include/import_fields.inc.php';

			$GROUPS = cache_read('article_group.php');

			if(isset($name))
			{
				include $importdir.$name.'.php';
				$setting = $settings[$name];
			}

			if(!isset($setting))
			{
				$setting['name'] = '';
				$setting['introduce'] = '';
				$setting['table'] = '';
				$setting['condition'] = '';
				$setting['settype'] = 0 ;
				$setting['dbfrom'] = 0 ;
				$setting['database'] = 'mysql';
				$setting['dbport'] = '3306';
				$setting['dbhost'] = $CONFIG['dbhost'];
				$setting['dbuser'] = $CONFIG['dbuser'];
				$setting['dbpw'] = $CONFIG['dbpw'];
				$setting['dbname'] = $CONFIG['dbname'];
				$setting['dbport'] = 3306;
				$setting['selectfield'] = '*';
				$setting['timelimit'] = 600;
				$setting['number'] = 1000;
				$setting['articlecheck'] = 1;
				$setting['maxid'] = 0;
			}
			$defaultcatid = isset($setting['defaultcatid']) ? $setting['defaultcatid'] : 0;

			require_once PHPCMS_ROOT.'/include/tree.class.php';
			$tree = new tree;

            $category_select = category_select('setting[defaultcatid]', $LANG['please_select'], $defaultcatid);

			include admintpl('import_setting');
		}

	break;

	case 'delete':
		if(!isset($name)) showmessage($LANG['error_parameters']);

		unlink($importdir.$name.'.php');

		showmessage($LANG['delete_data_success'], '?mod=article&file=import&action=manage');
    break;

	case 'down':
		if(!isset($name)) showmessage($LANG['error_parameters']);

		file_down($importdir.$name.'.php', $name.'.txt');
    break;

	case 'upload':
		if($dosubmit)
		{
			if(!isset($_FILES['uploadfile'])) showmessage($LANG['please_upload_file']);

		    require_once PHPCMS_ROOT.'/include/upload.class.php';

	        $fileArr = array('file'=>$_FILES['uploadfile']['tmp_name'],'name'=>$_FILES['uploadfile']['name'],'size'=>$_FILES['uploadfile']['size'],'type'=>$_FILES['uploadfile']['type'],'error'=>$_FILES['uploadfile']['error']);
			$savename = str_replace('.txt', '.php', $_FILES['uploadfile']['name']);
			$upload = new upload($fileArr, $savename, 'data/import/article/', 'txt', 1, 2048000);
			if(!$upload->up())
			{
				showmessage($upload->errmsg(), $forward);
			}
			showmessage($LANG['config_file_load_success'], $forward);
		}
		else
		{
			include admintpl('import_upload');
		}
    break;

	default:
		$files = glob($importdir.'*.php');
	    $settings = array();
		if(is_array($files))
		{
			foreach($files as $f)
			{
				require $f;
			}
		}
		include admintpl('import_manage');
}
?>
<?php
defined('IN_PHPCMS') or exit('Access Denied');

$importdir = PHPCMS_ROOT.'/data/import/member/';

$submenu = array (
	array($LANG['manage_member_load_setting'], '?mod='.$mod.'&file='.$file.'&action=manage'),
	array($LANG['add_member_load_setting'], '?mod='.$mod.'&file='.$file.'&action=setting'),
	array($LANG['load_setting'], '?mod='.$mod.'&file='.$file.'&action=upload')
);
$menu = adminmenu($LANG['member_data_load_manage'], $submenu);

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
				if(!extension_loaded('mssql')) showmessage($LANG['cannot_load_mssql_externsion']);
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

		$memberfields = array('userid','username','password','question','answer','email','showemail','groupid','arrgroupid','regip','regtime','lastloginip','lastlogintime','logintimes','domain','chargetype','begindate','enddate','money','payment','point','credit','hits','items','authstr');

		include MOD_ROOT.'/include/import_fields.inc.php';
		include MOD_ROOT.'/include/import_funcs.func.php';

        $member_insertfields = $member_insertvalues = $memberinfo_insertfields = $memberinfo_insertvalues = $insertfields = $insertvalues = '';
        foreach($fields as $field=>$v)
        {
			if($field == 'userid' && $setting['isuseoldid'] == 0) continue;
			$oldfield = trim($setting[$field]['field']);
			$defaultvalue = trim($setting[$field]['value']);
			$func = trim($setting[$field]['func']);

			if($oldfield)
			{
				$oldfields[$oldfield] = $field;
			}
			if($oldfield || $defaultvalue)
			{
				$insertfields = ",$field";
				if($defaultvalue)
				{
				    $insertvalues = ",'".$defaultvalue."'";
				}
				elseif($oldfield && $func)
				{
					$insertvalues = ",'\".".$func."(\$$field).\"'";
				}
				else
				{
				    $insertvalues = ",'\$$field'";
				}
				if(in_array($field, $memberfields))
				{
					$member_insertfields .= $insertfields;
					$member_insertvalues .= $insertvalues;
				}
				else
				{
					$memberinfo_insertfields .= $insertfields;
					$memberinfo_insertvalues .= $insertvalues;
				}
			}
        }
        $member_insertfields = substr($member_insertfields, 1);
        $member_insertvalues = substr($member_insertvalues, 1);
        $memberinfo_insertfields = substr($memberinfo_insertfields, 1);
        $memberinfo_insertvalues = substr($memberinfo_insertvalues, 1);

		$offset = isset($offset) ? $offset : 0;
		$number = $setting['number'];

        $limit = '';
		if($number) $limit = " LIMIT $offset,$number";
		$maxid = intval($setting['maxid']);
		$idfield = $setting['userid']['field'];
		$condition = str_replace('$maxid', $maxid, $setting['condition']);
        if($condition) $condition = " WHERE $condition";

		if($offset == 0)
	    {
			if($sameserver) $sqldb->select_db($setting['dbname']);
			$r = $sqldb->get_one("SELECT count(*) AS total FROM $table $condition");
			$total = $r['total'];
		}

		$idfield = $setting['userid']['field'];
		$orderby = $firsttable ? $firsttable.'.'.$idfield : $idfield;
		if($sameserver) $sqldb->select_db($setting['dbname']);
		$result = $sqldb->query("SELECT * FROM $table $condition ORDER BY $orderby $limit");
		$importnum = $sqldb->num_rows($result);
		while($r = $sqldb->fetch_array($result))
		{
			$r = new_addslashes($r, 1);
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

			if($sameserver) $db->select_db($CONFIG['dbname']);
			$memberexists = $db->get_one("SELECT userid FROM ".TABLE_MEMBER." WHERE username='$username'");
			if($memberexists) continue;

			eval("\$values = \"$member_insertvalues\";");
			$db->query("INSERT INTO ".TABLE_MEMBER."($member_insertfields) VALUES($values)");
			$userid = $db->insert_id();
			eval("\$values = \"$memberinfo_insertvalues\";");
			$db->query("INSERT INTO ".TABLE_MEMBER_INFO."(userid,$memberinfo_insertfields) VALUES('$userid',$values)");
			if($groupid == 1)
			{
				$db->query("INSERT INTO ".TABLE_ADMIN."(userid,username,grade) VALUES('$userid','$username',0)");
			}
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
        showmessage($LANG['total_amount'].' '.$total.' '.$LANG['item_no'].' '.$start.' '.$LANG['to'].' '.$end.' '.$LANG['load_success'], $forward);

        break;

	case 'setting':

		if($dosubmit)
		{
			if(empty($setting['name']) || !preg_match('/^[a-zA-Z][0-9a-zA-Z]*$/i',$setting['name']))
			{
				showmessage($LANG['setting_name_not_null']);
			}
			
			$setting['edittime'] = $PHP_TIME;
			array_save($setting , '$settings[\''.$setting['name'].'\']', $importdir.$setting['name'].'.php');
			
			$forward = "?mod=$mod&file=$file&action=manage&channelid=$channelid";
			showmessage($LANG['data_load_setting_save_success'], $forward);
		}
		else
		{
			include PHPCMS_ROOT.'/config.inc.php';
			include MOD_ROOT.'/include/import_fields.inc.php';

			$GROUPS = cache_read('member_group.php');

			if(isset($name))
			{
				include $importdir.$name.'.php';
				$setting = $settings[$name];
			}

			if(!isset($setting))
			{
				$setting['name'] = '';
				$setting['note'] = '';
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
				$setting['timelimit'] = 600;
				$setting['number'] = 1000;
				$setting['membercheck'] = 1;
			}
			$groupid = isset($setting['defaultgroupid']) ? $setting['defaultgroupid'] : 6;
            $groupid_select = showgroup('select','setting[defaultgroupid]', $groupid);
			include admintpl('import_setting');
		}

	break;

	case 'delete':
		if(!isset($name)) showmessage($LANG['illegal_parameters']);

		@unlink($importdir.$name.'.php');

        $forward = "?mod=$mod&file=$file&action=manage&channelid=$channelid";
		showmessage($LANG['setting_file_delete_success'], $forward);
    break;

	case 'down':
		if(!isset($name)) showmessage($LANG['illegal_parameters']);

		file_down($importdir.$name.'.php', $name.'.txt');
    break;

	case 'upload':
		if($dosubmit)
		{
			if(!isset($_FILES['uploadfile'])) showmessage($LANG['sorry_no_upload_file']);

		    require_once PHPCMS_ROOT.'/include/upload.class.php';

	        $fileArr = array('file'=>$_FILES['uploadfile']['tmp_name'],'name'=>$_FILES['uploadfile']['name'],'size'=>$_FILES['uploadfile']['size'],'type'=>$_FILES['uploadfile']['type'],'error'=>$_FILES['uploadfile']['error']);
			$savename = str_replace('.txt', '.php', $_FILES['uploadfile']['name']);
			$upload = new upload($fileArr, $savename, 'data/import/member/', 'txt', 1, 2048000);
			if(!$upload->up())
			{
				showmessage($upload->errmsg(), $forward);
			}
			showmessage($LANG['setting_file_load_success'], $forward);
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
				require_once $f;
			}
		}
		include admintpl('import_manage');
}
?>
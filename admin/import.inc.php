<?php
defined('IN_PHPCMS') or exit('Access Denied');
define('CACHE_IMPORT_PATH', PHPCMS_ROOT.'data/cache_import/');
require 'admin/import_funcs.inc.php';
if(!class_exists('import'))
{
	require 'admin/import.class.php';
}
$import = new import();

if(!class_exists('member_api'))
{
	require PHPCMS_ROOT.'member/api/member_api.class.php';
}
$member_api = new member_api();

if(!class_exists('attachment'))
{
	require 'attachment.class.php';
}
$attachment = new attachment($mod);

if(!$action) $action = 'manage';
switch ($action)
{
	case 'import':
		$sameserver = 0;
		$import_info = $import->view($name, $type);
		if($import_info['expire']) set_time_limit($import_info['expire']);
		$name = $import_info['name'];
	    $number = $import_info['number'];
	    $offset = isset($offset) ? intval($offset) : 0 ;
		if($type == 'content')
		{
			if(!class_exists('content'))
			{
				require 'admin/content.class.php';
			}
			$content = new content();
			$result = $import->add_content($import_info, $offset);
		}
		elseif ($type == 'member')
		{
			if(!class_exists('member_api'))
			{
				require 'member_api.class.php';
			}
			if(!class_exists('member_input'))
			{
				require CACHE_MODEL_PATH.'member_input.class.php';
			}
			if(!class_exists('member_update'))
			{
				require CACHE_MODEL_PATH.'member_update.class.php';
			}
			$result = $import->add_member($import_info, $offset);
		}
		if(!$result) showmessage($import->msg());
	    list($finished, $total) = explode('-', $result);
		$newoffset = $offset + $number;
		$start = $offset + 1;
		$end = $finished ? ($offset + $importnum) : $newoffset;
		$forward = $finished ? "?mod=$mod&file=$file&action=manage&type=$type" : "?mod=$mod&file=$file&action=$action&name=$name&type=$type&offset=$newoffset&total=$total";
		showmessage($LANG['total_import'].$total.$LANG['record'].'<br />'.$LANG['from'].$start.$LANG['to'].$end.$LANG['load_data_success'], $forward);
		break;
	case 'choice':
		$import_info = $import->view($name, $type);
		@extract($import_info);
		include admin_tpl('import_choice');
		break;
	case 'setting':
		if ($dosubmit)
		{
			if(empty($setting['name']))
			{
				showmessage($LANG['invalid_name']);
			}
			$import->setting($setting, $type);
			showmessage('操作成功', $forward.'&type='.$type);
		}
		else
		{
			if(!$type) showmessage('请选择类型');
			if('content' == $type)
			{
				$modelid = $contentmodelid;
			}
			elseif('member' == $type)
			{
				$modelid = $membermodelid;
			}
			if(!$modelid) showmessage('请选择模型');
			
			$fields = cache_read($modelid.'_fields.inc.php', CACHE_MODEL_PATH);
			if('content' == $type)
			{
				foreach ($CATEGORY as $cat)
				{
					if($modelid == $cat['modelid'] && $cat['arrchildid'] == $cat['catid'])
					{
						$arr_cat[$cat['catid']] = $cat['catname'];
					}
				}
			}
			elseif('member' == $type)
			{
				$memberfields = include 'admin/import_fields.inc.php';
				$fields = array_merge($memberfields, $fields);
			}
			$setting = $import->view($name, $type);
			$setting['modelid'] = $modelid;
			include admin_tpl('import_'.$type.'_setting');
		}
		break;
	case 'add':
		$TYPES = array(''=>'请选择', 'member'=>'用户', 'content'=>'文章');
		include admin_tpl('import_add_setting');
		break;
	case 'manage':
		$info = $import->manage($type);
		include admin_tpl('import_manage');
		break;
	case 'down':
		if(!isset($name)) showmessage($LANG['illegal_parameters']);
		file_down(CACHE_IMPORT_PATH.$name.'.php', $name.'.txt');
		break;
	case 'delete':
		$import->delete($name, $type);
		showmessage('操作成功');
		break;
	case 'test':
		$r = $import->connect_db($dbtype, $dbhost, $dbuser, $dbpw, $dbname);
		if ($r) {
			echo 'OK';
		}
		break;
		
	case 'get_database':
			if (empty($dbhost) || empty($dbuser) || empty($dbtype) || empty($dbpw)) 
			{
				exit();
			}
			$this_db = $import->connect_db($dbtype, $dbhost, $dbuser, $dbpw, '', $charset);
			$r = $this_db->query("SHOW DATABASES");
			$database = '';
			while ($s = $this_db->fetch_array($r)) 
			{
				$database .= "<option value='".$s['Database']."'>".$s['Database']."</option>";
			}
			echo $database;
		break;
		
	case 'get_tables':
			if (empty($dbhost) || empty($dbuser) || empty($dbtype) || empty($dbpw) || empty($dbname) || empty($charset)) 
			{
				exit();
			}
			$this_db = $import->connect_db($dbtype, $dbhost, $dbuser, $dbpw, $dbname, $charset);
			
			$r = $this_db->query("SHOW TABLES");
			$database = '<select id="tables" onchange="in_tables(this.value)">';
			while ($s = $this_db->fetch_array($r))
			{
				$database .= "<option value='".$s['Tables_in_'.$dbname]."'>".$s['Tables_in_'.$dbname]."</option>";
			}
			echo $database."</select>";
		break;
		
	case 'get_fields':
			if (empty($dbhost) || empty($dbuser) || empty($dbtype) || empty($dbpw) || empty($dbname) || empty($charset) || empty($tables)) 
			{
				exit();
			}
			$db_table = explode(',', $tables);
			$this_db = $import->connect_db($dbtype, $dbhost, $dbuser, $dbpw, $dbname, $charset);
			foreach ($db_table as $key=>$val)
			{
				$r[$val] = $this_db->get_fields($val);
			}
			$html = '<select onchange="if(this.value!=\'\'){put_fields(this.value)}"><option value="">请选择</option>';
			foreach ($r as $key=>$val)
			{
				foreach ($val as $v)
				{
					$html .= '<option value="'.$v.'">'.$key.'.'.$v.'</option>';
				}
			}
			echo $html.'</select>';
		break;
	case 'test_func':
		if(!function_exists($value))
		{
			echo $value.'该函数不存在';
		}
		else
		{
			exit('success');
		}
		break;
}
?>
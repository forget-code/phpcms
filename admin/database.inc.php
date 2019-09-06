<?php
defined('IN_PHPCMS') or exit('Access Denied');
if(!EXECUTION_SQL && ('export' != $action && 'repair' != $action))
{
    $message = "<font color=\"red\">对不起，出于系统安全考虑，管理员关闭了该功能，如需要打开请自行修改 config.inc.php 文件内对应的相关安全配置信息。<br />（将define('EXECUTION_SQL', '0');替换为define('EXECUTION_SQL', '1');）</font>";
    include admin_tpl('message');
    exit();
}
@set_time_limit(0);

if(!isset($forward)) $forward = '?mod=phpcms&file=database&action=export';

$action = $action ? $action : 'export' ;

require_once 'admin/database.class.php';
$database = new database();
require_once 'admin/strreplace.class.php';
$strreplace = new strreplace();
switch($action)
{
	case 'export':
		if($dosubmit)
		{
			$database->export($tables,$sqlcompat,$sqlcharset,$sizelimit,$action,$fileid,$random,$tableid,$startfrom,$tabletype);
		}
		else
		{
			$alltables=$database->status();
			include admin_tpl('database_export');
		}
	break;

	case 'import':
		if($dosubmit)
		{
			$database->import($pre);
		}
		else
		{
			$others = array();
			$sqlfiles = glob(PHPCMS_ROOT.'/data/bakup/*.sql');
			if(is_array($sqlfiles))
			{
				$prepre = '';
				$info = $infos = $other = $others = array();
				foreach($sqlfiles as $id=>$sqlfile)
				{
					if(preg_match("/(phpcmstables_[0-9]{8}_[0-9a-z]{4}_)([0-9]+)\.sql/i",basename($sqlfile),$num))
					{
						$info['filename'] = basename($sqlfile);
						$info['filesize'] = round(filesize($sqlfile)/(1024*1024), 2);
						$info['maketime'] = date('Y-m-d H:i:s', filemtime($sqlfile));
						$info['pre'] = $num[1];
						$info['number'] = $num[2];
						if(!$id) $prebgcolor = '#CFEFFF';
						if($info['pre'] == $prepre)
						{
						 $info['bgcolor'] = $prebgcolor;
						}
						else
						{
						 $info['bgcolor'] = $prebgcolor == '#CFEFFF' ? '#F1F3F5' : '#CFEFFF';
						}
						$prebgcolor = $info['bgcolor'];
						$prepre = $info['pre'];
						$infos[] = $info;
					}
					else
					{
						$other['filename'] = basename($sqlfile);
						$other['filesize'] = round(filesize($sqlfile)/(1024*1024),2);
						$other['maketime'] = date('Y-m-d H:i:s',filemtime($sqlfile));
						$others[] = $other;
					}
				}
			}
			include admin_tpl('database_import');
		}
	break;

	case 'repair':
		if($dosubmit)
		{
			if(empty($tables))
			{
				showmessage('请选择要修复优化的表');
			}
			$database->repair($tables,$operation);
		}
		else
		{
			$tables = array();
			$query = $db->query("SHOW TABLES FROM `".DB_NAME."`");
			while($r = $db->fetch_row($query))
			{
				$tables[] = $r[0];
			}
			include admin_tpl('database_repair');
		}
	break;

	case 'executesql':
		if($dosubmit)
		{
			$result=$database->executesql($operation, $sql);
			if($result === true)
            {
				showmessage($LANG['operation_success'], $forward);
            }
			elseif($result === false)
            {
				showmessage($LANG['operation_failure'], $forward);
            }
			else
            {
                if(is_array($result) && !empty($result))
                {
                    $data = array();
                    $data = $result;
                    include admin_tpl('database_executesql');
                }
			}
		}
		else
		{
		  include admin_tpl('database_executesql');
		}
	break;

	case 'uploadsql':
		$database->uploadsql();
	break;

	case 'changecharset':
		$database->changecharset($tocharset,$filenames);
	break;

	case 'delete':
		$database->delete($filenames,'import');
	break;

	case 'down':
		$database->down($filename);
	break;

	case 'replace':
		if($job=='getfields')
		{
			$fields = '';
			if(!$tablename) $message=$LANG['illegal_parameters'];
			else
			{
				$result = $db->get_fields($tablename);
				foreach($result as $fields)
				{
					echo "<option value=$fields>$fields</option>";
				}
			}
			exit;
		}
		if($dosubmit)
		{
			$strreplace->replaceall($fromtable,$fromfield1,$condition,$type,$search,$replace,$addstr);
		}
		else
		{
			$query = $db->query("SHOW TABLES FROM `".DB_NAME."`");
			$tables ='';
			while($r = $db->fetch_row($query))
			{
				$table = $r[0];
				if(preg_match("/^".$CONFIG['tablepre']."/i", $table))
				{
					$tables.= "<option value='$table'>$table</option>";
				}
			}
			$referer = urlencode('?mod='.$mod.'&file='.$file.'&action='.$action);
			$type = '1';
			include admin_tpl('database_replace');
		}
	break;
}
?>

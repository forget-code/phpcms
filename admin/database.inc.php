<?php
defined('IN_PHPCMS') or exit('Access Denied');

if($_grade >0 ) showmessage($LANG['you_have_no_permission']);

@set_time_limit(0);

$submenu = array
(
	array($LANG['database_bak'], '?mod='.$mod.'&file='.$file.'&action=export'),
	array($LANG['database_recover'], '?mod='.$mod.'&file='.$file.'&action=import'),
	array($LANG['database_repair'], '?mod='.$mod.'&file='.$file.'&action=repair'),
	array($LANG['execute_sql'], '?mod='.$mod.'&file='.$file.'&action=executesql')
);
$menu = adminmenu($LANG['database_admin'], $submenu);

if(!isset($forward)) $forward = '?mod=phpcms&file=database&action=export';

$action = $action ? $action : 'export' ;

switch($action)
{
	case 'export':
		if($dosubmit)
		{
			$fileid = isset($fileid) ? $fileid : 1;
			if($fileid==1 && $tables) 
			{
				if(!isset($tables) || !is_array($tables)) showmessage($LANG['select_bak_table']);
			    $random = mt_rand(1000, 9999);
			    cache_write('bakup_tables.php', $tables);
			}
			else
			{
			    if(!$tables = cache_read('bakup_tables.php')) showmessage($LANG['select_bak_table']);
			}
			$dumpcharset = $sqlcharset ? $sqlcharset : str_replace('-', '', $CONFIG['charset']);
			$setnames = ($sqlcharset && $db->version() > '4.1' && (!$sqlcompat || $sqlcompat == 'MYSQL41')) ? "SET NAMES '$dumpcharset';\n\n" : '';
			if($db->version() > '4.1')
			{
				if($sqlcharset)
				{
					$db->query("SET NAMES '".$sqlcharset."';\n\n");
				}
				if($sqlcompat == 'MYSQL40')
				{
					$db->query("SET SQL_MODE='MYSQL40'");
				}
				elseif($sqlcompat == 'MYSQL41')
				{
					$db->query("SET SQL_MODE=''");
				}
			}
			$sqldump = '';
			$tableid = isset($tableid) ? $tableid - 1 : 0;
			$startfrom = isset($startfrom) ? intval($startfrom) : 0;
			$tablenumber = count($tables);
			for($i = $tableid; $i < $tablenumber && strlen($sqldump) < $sizelimit * 1000; $i++)
			{
				$sqldump .= sql_dumptable($tables[$i], $startfrom, strlen($sqldump));
				$startfrom = 0;
			}
			if(trim($sqldump))
			{
				$sqldump = "# phpcms bakfile\n# version:".PHPCMS_VERSION."\n# time:".date('Y-m-d H:i:s')."\n# type:phpcms\n# phpcms:http://www.phpcms.cn\n# --------------------------------------------------------\n\n\n".$sqldump;
				$tableid = $i;
				$filename = $CONFIG['dbname'].'_'.date('Ymd').'_'.$random.'_'.$fileid.'.sql';
				$fileid++;

				$bakfile = PHPCMS_ROOT.'/data/bakup/'.$filename;
				if(!is_writable(PHPCMS_ROOT.'/data/bakup/')) showmessage($LANG['data_cannot_bak_to_server'], $forward);
				file_put_contents($bakfile, $sqldump);
				@chmod($bakfile, 0777);
				showmessage($LANG['bak_file']." $filename ".$LANG['write_success'], '?mod='.$mod.'&file='.$file.'&action='.$action.'&sizelimit='.$sizelimit.'&sqlcompat='.$sqlcompat.'&sqlcharset='.$sqlcharset.'&tableid='.$tableid.'&fileid='.$fileid.'&startfrom='.$startrow.'&random='.$random.'&dosubmit=1');
			}
			else
			{
			   cache_delete('bakup_tables.php');
			   showmessage($LANG['database_bak_success']);
			}
		}
		else
		{
			$phpcmstables = $phpcmsresults = $othertables = $otherresults = array();
			$k = 0;
			$query = $db->query("SHOW TABLES FROM `".$CONFIG['dbname']."`");
			while($r = $db->fetch_row($query))
			{
				$tables[$k] = $r[0];
				$count = $db->get_one("SELECT count(*) as number FROM $r[0] WHERE 1");
				$results[$k] = $count['number'];
				if(preg_match('/^'.$CONFIG['tablepre'].'/',$r[0]))
				{
					$phpcmstables[$k] = $r[0];
					$phpcmsresults[$k] = $count['number'];
				}
				else
				{
					$othertables[$k] = $r[0];
					$otherresults[$k] = $count['number'];
				}
				$k++;
			}
			include admintpl('database_export');
		}
	break;

	case 'import':
	 if($dosubmit)
	 {
		if($filename && fileext($filename)=='sql')
		{
			$filepath = PHPCMS_ROOT.'/data/bakup/'.$filename;
			if(!file_exists($filepath)) showmessage($LANG['sorry']." $filepath ".$LANG['not_exist']);
			$sql = file_get_contents($filepath);
			sql_execute($sql);
			showmessage("$filename ".$LANG['data_have_load_to_database']);
		}
		else
		{
			$fileid = $fileid ? $fileid : 1;
			$filename = $pre.$fileid.'.sql';
			$filepath = PHPCMS_ROOT.'/data/bakup/'.$filename;
			if(file_exists($filepath))
			{
				$sql = file_get_contents($filepath);
				sql_execute($sql);
				$fileid++;
				showmessage($LANG['data_file']." $filename ".$LANG['load_success'],"?mod=".$mod."&file=".$file."&action=".$action."&pre=".$pre."&fileid=".$fileid."&dosubmit=1");
			}
			else
			{
				showmessage($LANG['database_recover_success']);
			}
		}
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
				 if(preg_match("/([a-z0-9_]+_[0-9]{8}_[0-9a-z]{4}_)([0-9]+)\.sql/i",basename($sqlfile),$num))
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

		 include admintpl('database_import');
	 }
	 break;

	case 'repair':
	 if($dosubmit)
	 {
		 $tables = is_array($tables) ? implode(',',$tables) : $tables;
		 if($tables && in_array($operation,array('repair','optimize')) ) $db->query("$operation TABLE $tables");
		 showmessage($LANG['operation_success'], $PHP_REFERER);
	 }
	 else
	 {
		$tables = array();
		$query = $db->query("SHOW TABLES FROM `".$CONFIG['dbname']."`");
		while($r = $db->fetch_row($query))
		{
			$tables[] = $r[0];
		}
		include admintpl('database_repair');
	 }
	 break;

	case 'executesql':
	 if($dosubmit)
	 {
		if($operation == 'file')
		{
	        require_once PHPCMS_ROOT.'/include/upload.class.php';

	        $fileArr = array('file'=>$_FILES['uploadfile']['tmp_name'],'name'=>$_FILES['uploadfile']['name'],'size'=>$_FILES['uploadfile']['size'],'type'=>$_FILES['uploadfile']['type'],'error'=>$_FILES['uploadfile']['error']);
			$savepath = 'data/bakup/';
			$upload = new upload($fileArr,'',$savepath,'sql',1,'4096000');
			if(!$upload->up())
			{
				showmessage($upload->errmsg(), $PHP_REFERER);
			}
			$sql = file_get_contents($upload->saveto);
			@unlink($upload->saveto);
		}
		else
		{
			$sql = stripslashes($sql);
		}
		if(trim($sql) != '') sql_execute($sql);
		showmessage($LANG['operation_success'], $forward);
	 }
	 else
	 {
		  include admintpl('database_executesql');
	 }
	 break;

	case 'uploadsql':
	require_once PHPCMS_ROOT.'/include/upload.class.php';

	$fileArr = array('file'=>$_FILES['uploadfile']['tmp_name'],'name'=>$_FILES['uploadfile']['name'],'size'=>$_FILES['uploadfile']['size'],'type'=>$_FILES['uploadfile']['type'],'error'=>$_FILES['uploadfile']['error']);
	$savepath = 'data/bakup/';
	$upload = new upload($fileArr,$uploadfile_name,$savepath,'sql',1,'4096000');
	if($upload->up())
	{
		showmessage($LANG['operation_success'], $PHP_REFERER);
	}
	else
	{
		showmessage($upload->errmsg(), $PHP_REFERER);
	}
	break;

	case 'changecharset':
	 include_once PHPCMS_ROOT.'/include/charset.func.php';
	 if(empty($tocharset)) showmessage($LANG['select_charset_convert_type']);

	 $charsets = explode('2',$tocharset);
	 $from = $charsets[0];
	 $to = $charsets[1];

	 if(is_array($filenames))
	 {
		 foreach($filenames as $filename)
		 {
			 if(fileext($filename)=='sql')
			 {
				 $str = file_get_contents(PHPCMS_ROOT.'/data/bakup/'.$filename);
				 $str = convert_encoding($from, $to, $str);
				 file_put_contents(PHPCMS_ROOT.'/data/bakup/'.$to.$filename,$str);
				 chmod(PHPCMS_ROOT.'/data/bakup/'.$to.$filename, 0777);
			 }
		 }
	 }
	 else
	 {
		 if(fileext($filenames)=='sql')
		 {
			 $str = file_get_contents(PHPCMS_ROOT.'/data/bakup/'.$filenames);
			 $str = convert_encoding($from, $to, $str);
			 file_put_contents(PHPCMS_ROOT.'/data/bakup/'.$to.$filenames, $str);
			 chmod(PHPCMS_ROOT.'/data/bakup/'.$to.$filenames, 0777);
		 }
	 }
	 showmessage($LANG['operation_success'], $PHP_REFERER);
	 break;

	case 'delete':
	 if(is_array($filenames))
	 {
		 foreach($filenames as $filename)
		 {
			 if(fileext($filename)=='sql')
			 {
				 @unlink(PHPCMS_ROOT.'/data/bakup/'.$filename);
			 }
		 }
	 }
	 else
	 {
		 if(fileext($filenames)=='sql')
		 {
			 @unlink(PHPCMS_ROOT.'/data/bakup/'.$filenames);
		 }
	 }
	 showmessage($LANG['operation_success'], $PHP_REFERER);
	 break;

	case 'down':
	 $fileext = fileext($filename);
	 if($fileext != 'sql')
	 {
		 showmessage($LANG['sorry_only_download_sql_file']);
	 }
	 file_down(PHPCMS_ROOT.'/data/bakup/'.$filename);
	 break;
}
?>

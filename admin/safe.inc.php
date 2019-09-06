<?php 
defined('IN_PHPCMS') or exit('Access Denied');
if(empty($action)) $action = "start";
$safe = cache_read('safe.php');
$filecheck = load('filecheck.class.php');
if(empty($safe))
{
	$safe = array (
  'file_type' => 'php|js',
  'code' => '',
  'func' => 'com|system|exec|eval|escapeshell|cmd|passthru|base64_decode|gzuncompress',
  'dir' => $filecheck->checked_dirs()
	);
}
switch ($action)
{
	case 'start':
		$dir_list = $filecheck->dirs();
		$pagetitle = '病毒查杀';
		$md5_file = $filecheck->md5_files();
		include(admin_tpl('safe'));
	break;
	
	case 'setting':
		$data['file_type'] = $file_type;
		$data['code'] = html_entity_decode(stripcslashes($code));
		$data['func'] = html_entity_decode(stripcslashes($func));
		$data['md5_file'] = $md5_file;
		$data['dir'] = $dir;
		cache_write('safe.php',$data);
		echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8".CHARSET."\"><script type=\"text/javascript\">parent.setting();</script>";
	break;
	
	case 'scan_file_type':
		$file_type = explode('|', $safe['file_type']);
		foreach ($safe['dir'] as $key=>$val)
		{
			$files = $filecheck->scan_dir($val, $file_type);
			foreach ($files as $key=>$val)
			{
				$file_list[$key] = $val;
			}
		}
		cache_write('scan_safe_file.php', $file_list);
		echo 'ok';
	break;
	
	case 'scan_file_md5':
		$file_list = cache_read('scan_safe_file.php');
		$file_md5 = file(PHPCMS_ROOT.'data/md5_file/'.$safe['md5_file']);
		foreach($file_md5 as $val)
		{
			$val = trim($val);
			$key = substr($val, 0, 32);
			$file = substr($val, 33);
			if($file_list[$file] == $key)
			{
				unset($file_list[$file]);
			}
		}
		cache_write('scan_safe_file.php', $file_list);
		echo 'ok';
	break;
	
	case 'scan_func':
		@set_time_limit(600);
		$file_list = cache_read('scan_safe_file.php');
		if($safe['func'])
		{
			foreach ($file_list as $key=>$val)
			{
				$html = file_get_contents(PHPCMS_ROOT.$key);
				if(stristr($key,'.php.') != false || preg_match_all('/[^a-z]?('.$safe['func'].')\s*\(/i', $html, $state, PREG_SET_ORDER))
	            {
					$badfiles[$key]['func'] = $state;
	            }
			}
		}
		if(!isset($badfiles)) $badfiles = array();
		cache_write('scan_backdoor.php', $badfiles);
		echo 'ok';
	break;
	
	case 'scan_code':
		@set_time_limit(600);
		$file_list = cache_read('scan_safe_file.php');
		$badfiles = cache_read('scan_backdoor.php');
		if ($safe['code'])
		{
			foreach ($file_list as $key=>$val)
			{
				$html = file_get_contents(PHPCMS_ROOT.$key);
				if(stristr($key, '.php.') != false || preg_match_all('/[^a-z]?('.$safe['code'].')/i', $html, $state, PREG_SET_ORDER))
	            {
					$badfiles[$key]['code'] = $state;
	            }
	            if(strtolower(substr($key, -4)) == '.php' && function_exists('zend_loader_file_encoded') && zend_loader_file_encoded(PHPCMS_ROOT.$key))
	            {
	            	$badfiles[$key]['zend'] = 'zend encoded';
	            }
			}
		}
		if(!isset($badfiles))$badfiles='';
		cache_write('scan_backdoor.php', $badfiles);
		echo 'ok';
	break;
	
	case 'scan_table':
		$file_list = cache_read('scan_backdoor.php');
		$pagetitle = '扫描报表';
		include(admin_tpl('scan_table'));
	break;
	
	case 'see_code':
		$file_path = urldecode($files);
		if (empty($file_path)) 
		{
			showmessage('请选择文件');
		}
		$file_list = cache_read('scan_backdoor.php');
		$html = file_get_contents(PHPCMS_ROOT.$file_path);
		foreach ($file_list[$file_path]['func'] as $key=>$val)
		{
			$func[$key] = strtolower($val[1]);
		}
		foreach ($file_list[$file_path]['code'] as $key=>$val)
		{
			$code[$key] = strtolower($val[1]);
		}
		$func = array_unique($func);
		$code = array_unique($code);
		$pagetitle = '查看代码';
		include(admin_tpl('scan_see_code'));
	break;
	
	case 'del_file':
		$file_path = urldecode($files);
		if (empty($file_path)) 
		{
			showmessage('请选择文件');
		}
		$file_list = cache_read('scan_backdoor.php');
		unset($file_list[$file_path]);
		cache_write('scan_backdoor.php',$file_list);
		@unlink(PHPCMS_ROOT.$file_path);
		showmessage('文件删除成功！', '?mod=phpcms&file=safe&action=scan_table');
	break;
	
	case 'replace':
		if (isset($dosubmit)) 
		{
			$file_list = cache_read('scan_replace.php');
			$html = stripcslashes($html);
			$replace = stripcslashes($replace);
			foreach ($file_list as $key=>$val)
			{
				file_put_contents(PHPCMS_ROOT.$val, str_replace($html, $replace, file_get_contents(PHPCMS_ROOT.$val)));
			}
			showmessage('替换成功！', '?mod=phpcms&file=safe&action=scan_table');
		}
		else 
		{
			cache_write('scan_replace.php',$id);
			include(admin_tpl('scan_replace'));
		}
	break;
}
?>
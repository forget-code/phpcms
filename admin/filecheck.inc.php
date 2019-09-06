<?php
defined('IN_PHPCMS') or exit('Access Denied');

$filecheck = load('filecheck.class.php');

switch($action)
{
    case 'make':
		if($dosubmit)
		{
			$filecheck->set();
			$filecheck->make(PHPCMS_ROOT, $exts);
			showmessage('操作成功！', $forward);
		}
		else 
		{
			$dirs = $filecheck->dirs();
			$checked_dirs = $filecheck->checked_dirs();
			$make = true;
			include admin_tpl('filecheck_make');
		}
		break;

    default:
		if($dosubmit)
	    {
		    $files = array('edited'=>array(), 'unknow'=>array());
			$filecheck->set($md5_file);
			foreach($dirs as $dir)
			{
				$array = $dir == '' ? $filecheck->check(PHPCMS_ROOT, $exts, 0) : $filecheck->check(PHPCMS_ROOT.$dir.'/', $exts, 1);
				if($array['edited']) $files['edited'] = array_merge($files['edited'], $array['edited']);
				if($array['unknow']) $files['unknow'] = array_merge($files['unknow'], $array['unknow']);
			}
			include admin_tpl('filecheck');
		}
		else
	    {
			$md5_files = $filecheck->md5_files();
			$dirs = $filecheck->dirs();
			$checked_dirs = $filecheck->checked_dirs();
			include admin_tpl('filecheck_setting');
		}
}
?>
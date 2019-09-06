<?php
defined('IN_PHPCMS') or exit('Access Denied');

if($dosubmit)
{
	$content = array($content);
	cache_write('yp_announce.php',$content);
	showmessage('保存成功',$forward);
}
else
{
	if(file_exists(CACHE_PATH.'yp_announce.php'))
	{
		$content = cache_read('yp_announce.php');
		$content = $content[0];
		$edittime = filemtime(CACHE_PATH.'yp_announce.php');
		$edittime = date('Y-m-d H:i:s',$edittime);
	}
	include admin_tpl('announce_edit');
}
?>
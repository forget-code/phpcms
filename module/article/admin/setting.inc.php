<?php
defined('IN_PHPCMS') or exit('Access Denied');
if($dosubmit)
{
	$olddir = PHPCMS_ROOT.'/data/'.$old_dir.'/';
	if(!is_dir($olddir))
	{
		dir_create($olddir);
		file_put_contents($olddir.'index.html', ' ');
	}
	$newdir = PHPCMS_ROOT.'/data/'.$setting['storage_dir'].'/';
	if($olddir != $newdir) rename($olddir, $newdir);
	module_setting($mod, $setting);
	showmessage($LANG['save_setting_success'],$PHP_REFERER);
}
else
{
	@extract(new_htmlspecialchars($MOD));	
    include admintpl('setting');
}
?>
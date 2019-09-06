<?php
defined('IN_PHPCMS') or exit('Access Denied');
if($dosubmit)
{
	if($up_dir != $setting['upload_dir'])
	{
		foreach($CHANNEL as $cha)
		{
			if($cha['module'] != 'picture' || $cha['islink']) continue;
			$olddir = PHPCMS_ROOT.'/'.$cha['channeldir'].'/'.$up_dir.'/';
			$newdir = PHPCMS_ROOT.'/'.$cha['channeldir'].'/'.$setting['upload_dir'].'/';
			rename($olddir, $newdir);
		}
	}
	module_setting($mod, $setting);
	showmessage($LANG['save_setting_success'], $PHP_REFERER);
}
else
{
	@extract(new_htmlspecialchars($MOD));	
    include admintpl('setting');
}
?>
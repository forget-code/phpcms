<?php
defined('IN_PHPCMS') or exit('Access Denied');

if($_grade == 2)
{
	if(!in_array($file, array('left','info','special','createhtml','uppic'))) showmessage($LANG['you_have_no_permission']);
}
elseif($_grade >= 3)
{
	if(!in_array($file, array('left','info','uppic'))) showmessage($LANG['you_have_no_permission']);
	if($file == 'createhtml' && $_grade != 3)  showmessage($LANG['you_have_no_permission']);
	if($catid && !in_array($catid, $_catids)) showmessage($LANG['no_permission_this_category']);
	if($file == 'info')
	{
		if(!in_array($action, array('left','main','add','edit','manage', 'action', 'sendback','preview','checktitle'))) showmessage($LANG['you_have_no_permission']);
        if($_grade == 4)
		{			
			if(!in_array($action, array('left','main','add','edit','manage','checktitle'))) showmessage($LANG['you_have_no_permission']);
			if($job && !in_array($job, array('myitem'))) showmessage($LANG['you_have_no_permission']);
			if($action == 'manage' && !$job) $job = 'myitem';
		}
		else if($_grade > 4)
		{
			if(!in_array($action, array('left','main','manage','action','sendback','preview'))) showmessage($LANG['you_have_no_permission']);
			if($job && !in_array($job, array('check', 'status'))) showmessage($LANG['you_have_no_permission']);
			if($action == 'manage' && !$job) $job = 'check';
		}
	}
}
?>
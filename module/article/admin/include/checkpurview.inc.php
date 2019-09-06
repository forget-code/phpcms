<?php
defined('IN_PHPCMS') or exit('Access Denied');
if($_grade == 2)
{
	if(!in_array($file, array('left','article','special','createhtml','uppic'))) showmessage($LANG['not_authorized']);
}
elseif($_grade >= 3)
{
	if(!in_array($file, array('left','article','uppic'))) showmessage($LANG['not_authorized']);
	if($file == 'createhtml' && $_grade != 3)  showmessage($LANG['not_authorized']);
	if($catid && !in_array($catid, $_catids)) showmessage($LANG['not_authorized']);
	if($file == 'article')
	{
		if(!in_array($action, array('left','main','add','edit','manage', 'action', 'sendback','preview','checktitle'))) showmessage($LANG['you_have_no_permission']);
        if($_grade == 4)
		{			
			if(!in_array($action, array('left','main','add','edit','manage','checktitle'))) showmessage($LANG['not_authorized']);
			if($job && !in_array($job, array('myitem'))) showmessage($LANG['not_authorized']);
			if($action == 'manage' && !$job) $job = 'myitem';
		}
		else if($_grade > 4)
		{
			if(!in_array($action, array('left','main','manage','action','sendback','preview'))) showmessage($LANG['not_authorized']);
			if($job && !in_array($job, array('check', 'status'))) showmessage($LANG['not_authorized']);
			if($action == 'manage' && !$job) $job = 'check';
		}
	}
}
?>
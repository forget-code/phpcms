<?php
defined('IN_PHPCMS') or exit('Access Denied');
isset($job) && isset($value) or showmessage($LANG['invalid_parameters'],'goback');
if($pic->action($job, $value, $pictureids))
{
	if($value == 3)
	{
		foreach($pictureids as $pictureid)
		{
			createhtml('show');
		}
		createhtml('index');
		createhtml('index', PHPCMS_ROOT);
	}
	showmessage($LANG['operation_success'],$referer);
}
else
{
	showmessage($LANG['operation_failure'],'goback');
}
?>
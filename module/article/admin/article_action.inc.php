<?php
defined('IN_PHPCMS') or exit('Access Denied');
(($job=='status' or $job=='elite') and isset($value)) or showmessage($LANG['invalid_parameters'],'goback');
if($art->action($job, $value, $articleids))
{
	showmessage($LANG['operation_success'],$referer);
}
else
{
	showmessage($LANG['operation_failure'],'goback');
}
?>
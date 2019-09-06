<?php
defined('IN_PHPCMS') or exit('Access Denied');
(($job=='disabled' or $job=='posid') and isset($value)) or showmessage($LANG['illegal_parameters'],'goback');
if($pdtcls->action($job, $value, $productids,$isrecycle))
{
	showmessage($LANG['operation_success'],$referer);
}
else
{
	showmessage($LANG['operation_failure'],'goback');
}
?>
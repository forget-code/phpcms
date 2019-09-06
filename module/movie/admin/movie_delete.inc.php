<?php
defined('IN_PHPCMS') or exit('Access Denied');
require PHPCMS_ROOT.'/admin/include/position.class.php';
$pos = new position($channelid);

if(!isset($movieids)) $movieids = '';

if($d->delete($movieids))
{
	showmessage($LANG['delete_success'], $referer);
}
else
{
	showmessage($LANG['failure_to_delete'], 'goback');
}
?>
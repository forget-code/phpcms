<?php
defined('IN_PHPCMS') or exit('Access Denied');
require PHPCMS_ROOT.'/admin/include/position.class.php';
$pos = new position($channelid);

if(!isset($infoids)) $infoids = '';
if($inf->delete($infoids))
{
	showmessage($LANG['delete_info_success'],$referer);
}
else
{
	showmessage($LANG['delete_info_fail'],'goback');
}
?>
<?php
defined('IN_PHPCMS') or exit('Access Denied');
require PHPCMS_ROOT.'/admin/include/position.class.php';
$pos = new position($channelid);

if(!isset($pictureids)) $pictureids = '';
if($pic->delete($pictureids))
{
	showmessage($LANG['delete_picture_success'],$referer);
}
else
{
	showmessage($LANG['delete_picture_fail'],'goback');
}
?>
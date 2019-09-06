<?php
defined('IN_PHPCMS') or exit('Access Denied');

require PHPCMS_ROOT.'/admin/include/position.class.php';
$pos = new position($channelid);

if(!isset($articleids)) $articleids = '';

if($art->delete($articleids))
{
	showmessage($LANG['delete_article_success'], $referer);
}
else
{
	showmessage($LANG['delete_article_failure'], 'goback');
}
?>
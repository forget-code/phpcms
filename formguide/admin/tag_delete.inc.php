<?php 
defined('IN_PHPCMS') or exit('Access Denied');
if(!$tag->exists($tagname)) showmessage($LANG['label']." $tagname ".$LANG['not_exist'], "goback");
$tag->update($tagname , '');
showmessage($LANG['operation_success'], $referer);
?>
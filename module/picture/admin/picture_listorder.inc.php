<?php
defined('IN_PHPCMS') or exit('Access Denied');
if($pic->listorder($listorders))
{
	showmessage($LANG['picture_listorder_update_success'],$referer);
}
else
{
	showmessage($LANG['picture_listorder_update_fail'],'goback');
}
?>
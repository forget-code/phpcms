<?php
defined('IN_PHPCMS') or exit('Access Denied');
if($inf->listorder($listorders))
{
	showmessage($LANG['info_listorder_update_success'],$referer);
}
else
{
	showmessage($LANG['info_listorder_update_fail'],'goback');
}
?>
<?php
defined('IN_PHPCMS') or exit('Access Denied');
if($pdtcls->listorder($listorders))
{
	showmessage($LANG['product_sorting_update_success'],$referer);
}
else
{
	showmessage($LANG['product_sorting_update_fail'],'goback');
}
?>
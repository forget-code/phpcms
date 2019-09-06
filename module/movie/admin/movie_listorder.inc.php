<?php
defined('IN_PHPCMS') or exit('Access Denied');
if($d->listorder($listorders))
{
	showmessage($LANG['sorting_success'],$referer);
}
else
{
	showmessage($LANG['sorting_failure'],'goback');
}
?>
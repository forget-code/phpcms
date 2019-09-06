<?php
defined('IN_PHPCMS') or exit('Access Denied');
if($art->listorder($listorders))
{
	showmessage($LANG['order_the_article_list_success'],$referer);
}
else
{
	showmessage($LANG['order_the_article_list_failure'],'goback');
}
?>
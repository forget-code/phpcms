<?php
defined('IN_PHPCMS') or exit('Access Denied');
require_once MOD_ROOT.'include/html.class.php';
$chtml = new html();
$chtml->index();
$type =subtype('link');
foreach($type as $key=>$value)
{
	$chtml->type($value['typeid']);
}
showmessage($LANG['update_success'],'?mod=link&file=link&action=manage');
?>
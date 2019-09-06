<?php
defined('IN_PHPCMS') or exit('Access Denied');

if(!$forward) $forward = HTTP_REFERER;
if($dosubmit)
{
	$priv_role->update('module', $mod, $priv_roleid);
	showmessage($LANG['save_setting_success'], $forward);
}
else
{
	$privs = include 'priv.inc.php';
    include admin_tpl('priv');
}
?>
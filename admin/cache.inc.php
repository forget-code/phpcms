<?php
defined('IN_PHPCMS') or exit('Access Denied');

require_once PHPCMS_ROOT."/include/template.func.php";

$action = $action ? $action : "update";
switch($action)
{
	case 'update':
		cache_all();
        template_cache();
		showmessage($LANG['all_cache_update_success']);
		break;
}
?>
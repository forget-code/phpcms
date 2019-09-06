<?php
defined('IN_PHPCMS') or exit('Access Denied');

switch($action)
{
	case 'main':
        $upgrade = load('upgrade.class.php');
	    $notice_url = $upgrade->notice();

		$stat = load('stat.class.php');
		if($MODULE['message'])
		{
			$message_api = load('message_api.class.php', 'message', 'api');
			$msg_new = $message_api->count_message($_userid, 'new');
			$msg_inbox = $message_api->count_message($_userid, 'inbox');
		}
		require_once PHPCMS_ROOT.'member/include/member.class.php';
		$member = new member();
		$member_info = $member->get($_userid, '*', 1);
		@extract(new_htmlspecialchars($member_info));

        $pagetitle = '后台首页';

		include admin_tpl('index_main');
	break;

	case 'get_msg':
		echo $_message ? 1 : 0;
		break;

	default:
		require_once 'menu.class.php';
		$m = new menu();
		$menus = $m->listinfo('parentid = 1', 'menuid, name');
		$menu = array();
		foreach ($menus as $key=>$val)
		{
			$menu[$key]['name'] = $val['name'];
			$menu[$key]['menuid'] = $val['menuid'];
			$menu[$key]['child'] = $m->get_childs($val['menuid'], 'menuid, name, url, isfolder, target');
		}
		include admin_tpl('index');
}
?>

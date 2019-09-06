<?php
require './include/common.inc.php';
if($_userid != intval($userid)) showmessage('请登录后再进行操作', $MODULE['member']['linkurl'].'login.php?forward='.urlencode(URL));
switch ($action) 
{
	case 'edit':
			$space->edit_block($userid, $blockid);
		break;
	case 'del':
			$space->del_block($userid, $blockid);
		break;
	case 'editspacename':
			if(CHARSET != 'utf-8')
			{
				$spacename = iconv('utf-8', CHARSET, $spacename);
			}
			$info['spacename'] = $spacename;
			$space->edit($_userid, $info);
		break;
	default:
		$spaceinfo = $space->get_space($userid);
		@extract(new_htmlspecialchars($spaceinfo));
		unset($spaceinfo);
		$block = new_htmlspecialchars($space->block_pannel($_userid));
		include template($mod, 'block');
		break;
}
?>
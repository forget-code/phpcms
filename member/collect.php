<?php
require './include/common.inc.php';
if(!$_userid) showmessage($LANG['please_login'], $M['url'].'login.php?forward='.urlencode(URL));

switch($action)
{
	case 'add':
		$contentid = intval($contentid);
		if(!$contentid) showmessage('缺少信息id，请重新选择要收藏的信息！', HTTP_REFERER);
		require_once 'admin/content.class.php';
		$c = new content();
		$r = $c->get($contentid);
		if(!$r || $r['status'] != 99) showmessage('您要查看的信息不存在或者还未通过审批！');
		$c = $db->get_one("SELECT id FROM ".DB_PRE."collect WHERE `contentid`='$contentid' AND `userid`='$_userid'");
		if($c['id']) showmessage('此信息您已经收藏！', HTTP_REFERER);
		$info = array('contentid'=>$contentid, 'userid'=>$_userid, 'addtime'=>TIME);
		$db->insert(DB_PRE.'collect', $info);
		if($db->insert_id()) showmessage('收藏成功！', HTTP_REFERER);
	break;

	case 'delete':
		$id = intval($id);
		if(!$id) showmessage('非法操作！', HTTP_REFERER);
		$db->query("DELETE FROM ".DB_PRE."collect WHERE `userid`='$_userid' AND `id`='$id'");
		showmessage('删除成功！', HTTP_REFERER);
	break;

	default:
		$space = load('space.class.php', 'space');
		if(!$forward) $forward = HTTP_REFERER;
		$is_host = 1;
		$memberinfo = $member->get($_userid, '*', 1);
		$avatar = avatar($_userid);
		$data = $space->get_collect($page);
		include template($mod, 'collect');
	break;
}
?>
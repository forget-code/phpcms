<?php
defined('IN_PHPCMS') or exit('Access Denied');
$submenu = array(
	array($LANG['all_comment'],'?mod=phpcms&file=setting&tab=5'),
	);
$menu = admin_menu($LANG['comment_content_manage'],$submenu);
require_once MOD_ROOT.'admin/include/comment.class.php';
$comment = new comment();
$forward = $forward ? $forward : HTTP_REFERER;
$action = $action ? $action : 'manage';
$filearray = array('delete', 'manage', 'pass');
in_array($action,$filearray) or showmessage($LANG['illegal_action'],$referer);
switch ($action)
{
	case 'manage':
		$condition = array();
        if (!empty($userid))         {$userid = intval($userid);$condition[] = " `userid` = '$userid' ";}
		if (isset($keyid))  		$condition[] = " `keyid` = '$keyid' ";
		if ($status == '0' || $status == '1')  		$condition[] = " `status` = '$status' ";
		if(isset($ip)) 				$condition[] = " `ip` = '$ip'";
        if($srchfrom)               {$time = TIME; $timeid = TIME - $timeid*24*60*60; $condition[] = " `addtime` >= '$timeid' AND `addtime` <= '$time'";}
		if(!empty($keywords)) 		{$keywords = trim($keywords);$condition [] = " `username` LIKE '%$keywords%' OR `content` LIKE '%$keywords%' " ;}
		$pagesize	= $PHPCMS['pagesize'] ? $PHPCMS['pagesize'] : 20;
		$page		= isset($page) ? intval($page) : '1' ;
		$comments = $comment->get_list($condition, $page, $pagesize);
		$pages = $comments['pages'];
		include admin_tpl('comment_manage');
	break;
	case 'pass':
		if( empty( $cid ) ){
			showmessage('请选择要删除的评论','?mod=comment&file=comment&action=manage&status=0');
		}
		if ( isset($cid) && $comment->pass( $cid, $status) ) {
			showmessage($LANG['operation_success'], '?mod=comment&file=comment&action=manage');
		}
		showmessage($LANG['operation_failure']);
	break;
	case 'delete':
		if( empty( $cid ) )
        {
			showmessage('请选择要删除的评论');
		}
		if ( $comment->drop($cid) )
        {
			showmessage($LANG['operation_success'], '?mod=comment&file=comment&action=manage');
		}
        else
        {
			showmessage($LANG['operation_failure']);
		}
	break;
}
?>
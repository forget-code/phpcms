<?php 
defined('IN_PHPCMS') or exit('Access Denied');
$submenu = array(
	array($LANG['guestbook_manage'],"?file=$file&action=manage"),
);
require PHPCMS_ROOT.'/admin/include/global.func.php';
$menu = adminmenu($LANG['guestbook_manage'],$submenu);
$action = isset($action) ? $action : 'manage';
switch($action)
{
	case 'manage':
		$ordertype = isset($ordertype) ? intval($ordertype) : 0;
		$pagesize = $PHPCMS['pagesize'];
		$page = isset($page) ? intval($page) : 1;
		$offset = ($page-1)*$pagesize;
		
		$condition = '';
		$keywords = !empty($keywords) ? trim($keywords) : '';
		if($keywords)
		{
			$keywords = trim($keywords);
			$keywords = str_replace(' ','%',$keywords);
			$keywords = str_replace('*','%',$keywords);
			$condition .= " AND ".$searchtype." LIKE '%$keywords%' ";
		}		
		$r = $db->get_one("SELECT COUNT(gid) AS num FROM ".TABLE_YP_GUESTBOOK." WHERE companyid='$companyid' $condition");
		$number = $r['num'];
		$pages = phppages($number,$page,$pagesize);
		$guestbooks = array();
		$result = $db->query("SELECT * FROM ".TABLE_YP_GUESTBOOK." WHERE companyid='$companyid' $condition ORDER BY gid DESC LIMIT $offset,$pagesize");		
		while($r = $db->fetch_array($result))
		{
			$r['addtime'] = date('Y-m-d H:i',$r['addtime']);
			$r['content'] = str_cut($r['content'],300,"<font style=\"BACKGROUND-COLOR: #3399CC\">more...</font>");
			$guestbooks[] = $r;
		}
	break;

	case 'view':
		$gid = isset($gid) ? intval($gid) : showmessage($LANG['illegal_parameters']);
		$db->query("UPDATE ".TABLE_YP_GUESTBOOK." SET status=1 WHERE gid=$gid AND companyid=$companyid");
		extract($db->get_one("SELECT * FROM ".TABLE_YP_GUESTBOOK." WHERE gid=$gid AND companyid=$companyid"));
		if($label=='product')
		{
			$table = TABLE_YP_PRODUCT;
		}
		elseif($label=='sales')
		{
			$table = TABLE_YP_SALES;
		}
		elseif($label=='buy')
		{
			$table = TABLE_YP_BUY;
		}
		if($label) extract($db->get_one("SELECT title,linkurl FROM $table WHERE productid=$itemid"));
		$qq=  $qq ? $qq: '';
	break;

	case 'delete':
		if(empty($gid))
		{
			showmessage($LANG['illegal_parameters']);
		}
		$gids = is_array($gid) ? implode(',',$gid) : $gid;
		$db->query("DELETE FROM ".TABLE_YP_GUESTBOOK." WHERE gid IN ($gids) AND companyid=$companyid");
		if($db->affected_rows()>0)
		{
			showmessage($LANG['operation_success'],$forward);
		}
		else
		{
			showmessage($LANG['operation_failure']);
		}
	break;
}

include managetpl('guestbook_'.$action);

?>
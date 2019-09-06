<?php 
defined('IN_PHPCMS') or exit('Access Denied');

require_once 'attachment.class.php';
require_once PHPCMS_ROOT.'member/include/member.class.php';
require_once 'admin/category.class.php';
$m = new member();
$a = new attachment();
$c = new category();

function isimage($fileext)
{
	global $a;
	return in_array($fileext, $a->imageexts);
}

function itemurl($module,$catid,$contentid)
{
	return "content.php?module=$module&catid=$catid&contentid=$contentid";
}

if(!$action) $action = 'manage';

switch($action)
{
	case 'manage':
			$where = '1';
			if(!empty($username))
			{
				$userid = $m->get_userid($username);
				$where = $where . " AND `userid` = '$userid'";
			}
			if(!empty($module)){
				$where .= " AND `module` = '$module'";
			}
			if(!empty($catid) && $catid != 0)
			{
				$where .= " AND `catid` = '$catid'";
			}
			if(!empty($contentid))
			{
				$where .= " AND `contentid` = '$contentid'";
			}
			if(!empty($field))
			{
				$where .= " AND `field` = '$field'";
			}
			if(!empty($fileext)){
				$where .= " AND `fileext` = '$fileext'";
			}
			$listorderby = $listorderby ? $listorderby : 'aid DESC';
			$atts = $a->listinfo($where, '*', $listorderby, $page, 20);
			include admin_tpl('attachment');
			break;
	case 'delete':
			if(is_array($aid))
			{
				$where = "aid in (".implode(',',$aid).")";
			}
			else
			{
				$aid = intval($aid);
				if($aid < 1) return false;
				$where = "aid = $aid";
			}

			if($a->delete($where))
			{
				showmessage("删除成功！");
			}
			else
			{
				showmessage("发生错误，未删除成功！");
			}
			break;
	default:
}

?>
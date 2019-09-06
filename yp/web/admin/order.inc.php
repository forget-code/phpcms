<?php 
defined('IN_PHPCMS') or exit('Access Denied');
$submenu = array(
	array('订单管理',"?file=$file&action=manage"),
);
require PHPCMS_ROOT.'/admin/include/global.func.php';
$menu = adminmenu('订单管理',$submenu);
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
		$r = $db->get_one("SELECT COUNT(orderid) AS num FROM ".TABLE_YP_ORDER." WHERE companyid='$companyid' $condition");
		$number = $r['num'];
		$pages = phppages($number,$page,$pagesize);
		$orders = array();
		$result = $db->query("SELECT * FROM ".TABLE_YP_ORDER." WHERE companyid='$companyid' $condition ORDER BY orderid DESC LIMIT $offset,$pagesize");		
		while($r = $db->fetch_array($result))
		{
			if($r['label']=='product')
			{
				$table = TABLE_YP_PRODUCT;
			}
			elseif($r['label']=='sales')
			{
				$table = TABLE_YP_SALES;
			}
			@extract($db->get_one("SELECT title,linkurl FROM $table WHERE productid='$r[itemid]'"));
			$r['title'] = $title;
			$r['linkurl'] = $linkurl;
			$r['addtime'] = date('Y-m-d H:i',$r['addtime']);
			$orders[] = $r;
		}
	break;

	case 'view':
		$orderid = isset($orderid) ? intval($orderid) : showmessage($LANG['illegal_parameters']);
		$db->query("UPDATE ".TABLE_YP_ORDER." SET status=1 WHERE orderid=$orderid AND companyid=$companyid");
		extract($db->get_one("SELECT * FROM ".TABLE_YP_ORDER." WHERE orderid=$orderid AND companyid=$companyid"));
		if($label=='product')
		{
			$table = TABLE_YP_PRODUCT;
		}
		elseif($label=='sales')
		{
			$table = TABLE_YP_SALES;
		}
		extract($db->get_one("SELECT title,linkurl,price FROM $table WHERE productid=$itemid"));
		$totalprice = $number*$price;
		$qq = $qq ? $qq : '';
	break;

	case 'delete':
		if(empty($orderid))
		{
			showmessage($LANG['illegal_parameters']);
		}
		$orderids = is_array($orderid) ? implode(',',$orderid) : $orderid;
		$db->query("DELETE FROM ".TABLE_YP_ORDER." WHERE orderid IN ($orderids) AND companyid=$companyid");
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

include managetpl('order_'.$action);

?>
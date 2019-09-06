<?php 
defined('IN_PHPCMS') or exit('Access Denied');
require PHPCMS_ROOT.'/admin/include/global.func.php';
require_once PHPCMS_ROOT.'/include/formselect.func.php';
$job = isset($job) ? $job : 'manage';
$submenu = array(
	array("<font color='#ff0000'>".$LANG['publish_sales_info']."</font>","?file=$file&action=add"),
	array($LANG['manage_sales'],"?file=$file&action=manage&job=manage&label=4"),
	array($LANG['waiting_check'],"?file=$file&action=manage&job=check"),
	array($LANG['recycle'],"?file=$file&action=manage&job=recycle"),
);
$menu = adminmenu($LANG['manage_sales'],$submenu);
$TRADE = cache_read('trades_sales.php');

$arrgroupidview_post = explode(',',$MOD['arrgroupidview_post']);
$arrgroupidpost = FALSE;
if(in_array($_groupid,$arrgroupidview_post)) $arrgroupidpost = TRUE;
require_once PHPCMS_ROOT.'/include/tree.class.php';
$module = $mod;
$tree = new tree;
require_once PHPCMS_ROOT.'/yp/include/trade.func.php';
require PHPCMS_ROOT.'/include/field.class.php';
$field = new field($CONFIG['tablepre'].'yp_sales');
require_once PHPCMS_ROOT.'/include/formselect.func.php';
$username = $_username;
switch($action)
{
	case 'add':
		if($dosubmit)
		{
			$field->check_form();
			$product['title'] = htmlspecialchars($product['title']);
			$product['keywords'] = htmlspecialchars($product['keywords']);
			$product['period'] = strtotime($product['period']);
			$catid = $product['catid'];
			$product['state'] = empty($product['state']) ? '' : strip_tags($product['state']);
			$product['introduce'] = str_safe($product['introduce']);
			$product['username'] = $product['editor'] = $_username;
			$product['addtime'] = $product['edittime'] = $product['checktime'] = $PHP_TIME;
			$sql1 = $sql2 = $s = "";
			foreach($product as $key=>$value)
			{
				$sql1 .= $s.$key;
				$sql2 .= $s."'".$value."'";
				$s = ",";
			}
			$sql = "INSERT INTO ".TABLE_YP_SALES." ($sql1) VALUES($sql2)";
			$result = $db->query($sql);
			if($db->affected_rows($result))
			$productid = $db->insert_id();
			$field->update("productid=$productid");
			$enterprise = '';
			if($MOD['enableSecondDomain'])
			{
				$linkurl = $mydomain.'/sales.php?item-'.$productid.'.html';
			}
			else
			{
				$linkurl = $MODULE['yp']['linkurl'].'web/sales.php?enterprise-'.$domainName.'/item-'.$productid.'.html';
				
			}
			$db->query("UPDATE ".TABLE_YP_SALES." SET linkurl='$linkurl' WHERE productid=$productid ");
			$product['introduce'] = stripslashes($product['introduce']);
			createhtml('sales',PHPCMS_ROOT.'/yp/web');
			createhtml('index',PHPCMS_ROOT.'/yp/web');
			showmessage($LANG['add_success'],$forward);
		}
		else
		{
			if($MOD['ischeck'] && $companystatus!=3) showmessage($LANG['watting_checked']);
			if($vip && $PHP_TIME>$vip) showmessage($LANG['please_buy_vip']);
			$totime = $PHP_TIME+86400*60;
			$totime = date('Y-m-d',$totime);
			$style_edit = style_edit('product[style]','');
			$fields = $field->get_form('<tr><td class="tablerow">$title</td><td class="tablerow">$input $tool $note</td></tr>');
			extract($db->get_one("SELECT companyid,address,telephone,email FROM ".TABLE_MEMBER_COMPANY." WHERE username='$_username'"));
			include managetpl('sales_add');
		}
	break;
	case 'manage':
		if($job == 'manage')
		{
			$status = 'status>=3';
		}
		elseif($job == 'recycle')
		{
			$status = 'status=-1';
		}
		else
		{
			$status = 'status=1';
		}
		$pagesize = $PHPCMS['pagesize'];
		$page = isset($page) ? intval($page) : 1;
		$offset = ($page-1)*$pagesize;
		$srchtype = isset($srchtype) ? intval($srchtype) : 0;
		$typeid = isset($typeid) ? intval($typeid) : 0;
		$orders = array('productid DESC', 'productid ASC', 'edittime DESC', 'edittime ASC', 'hits DESC', 'hits ASC');
		$ordertype = isset($ordertype) ? intval($ordertype) : 0;
		$order = $orders[$ordertype];
		$condition = '';
		$condition .= $catid ? 'AND catid='.$catid.' ' : '';
		$condition .= $typeid ? 'AND typeid='.$typeid.' ' : '';
		if(isset($keyword))
		{
			$keyword = trim($keyword);
			$keyword = str_replace(' ','%',$keyword);
			$keyword = str_replace('*','%',$keyword);
			if($srchtype)
			{
				$condition .= " AND username = '$keyword' ";
			}
			else
			{
				$condition .= " AND title LIKE '%$keyword%' ";
			}
		}
		$condition .= " AND username='$_username'";
		$r = $db->get_one("SELECT COUNT(companyid) AS num FROM ".TABLE_YP_SALES." WHERE $status $condition");
		$number = $r['num'];
		$pages = phppages($number,$page,$pagesize);
		$products = array();
		$result = $db->query("SELECT * FROM ".TABLE_YP_SALES." WHERE $status $condition ORDER BY $order LIMIT $offset,$pagesize");		
		while($r = $db->fetch_array($result))
		{
			$r['addtime'] = date('Y-m-d',$r['addtime']);
			$r['edittime'] = date('Y-m-d H:i:s',$r['edittime']);
			$r['checktime'] = date('Y-m-d H:i:s',$r['checktime']);
			extract($db->get_one("SELECT companyname,sitedomain FROM ".TABLE_MEMBER_COMPANY." WHERE companyid=$r[companyid]"));
			$r['companyname'] = $companyname;
			if($MOD['enableSecondDomain'])
			{
				$r['domain'] = 'http://'.$sitedomain.'.'.$MOD['secondDomain'];
			}
			else
			{
				@extract($db->get_one("SELECT userid FROM ".TABLE_MEMBER." WHERE username = '$r[username]'"));
				$r['domain'] = $PHPCMS['siteurl']."yp/web/?".$userid."/";
			}
			$products[] = $r;
		}
		include managetpl('sales_'.$job);
	break;

	case 'status':
		if(empty($productid))
		{
			showmessage($LANG['illegal_parameters']);
		}
		$productids=is_array($productid) ? implode(',',$productid) : $productid;
		$db->query("UPDATE ".TABLE_YP_SALES." SET status=$status WHERE productid IN ($productids) AND username='$_username'");
		if($db->affected_rows()>0)
		{
			showmessage($LANG['operation_success'],$forward);
		}
		else
		{
			showmessage($LANG['operation_failure']);
		}		
		break;

	case 'edit':
		if($dosubmit)
		{
			$field->check_form();
			$product['period'] = strtotime($product['period']);
			$product['title'] = htmlspecialchars($product['title']);
			$product['keywords'] = htmlspecialchars($product['keywords']);
			$product['state'] = isset($product['state']) ? htmlspecialchars($product['state']) : '';
			$sql = $s = "";
			foreach($product as $key=>$value)
			{
				$sql .= $s.$key."='".$value."'";
				$s = ",";
			}
			$db->query("UPDATE ".TABLE_YP_SALES." SET $sql WHERE productid='$productid'");
			$field->update("productid=$productid");
			$product['introduce'] = stripslashes($product['introduce']);
			createhtml('sales',PHPCMS_ROOT.'/yp/web');
			createhtml('index',PHPCMS_ROOT.'/yp/web');
			showmessage($LANG['operation_success'],$forward);
		}
		else
		{			
			@extract($db->get_one("SELECT * FROM ".TABLE_YP_SALES." WHERE productid='$productid'"),EXTR_OVERWRITE);
			$totime = date('Y-m-d',$period);
			$fields = $field->get_form('<tr><td class="tablerow">$title</td><td class="tablerow">$input $tool $note</td></tr>');
			$style_edit = style_edit("product[style]", $style);
			include managetpl('sales_edit');
		}
		break;

		case 'delete':
		if(empty($productid))
		{
			showmessage($LANG['illegal_parameters']);
		}
		$productids = is_array($productid) ? implode(',',$productid) : $productid;
		$db->query("DELETE FROM ".TABLE_YP_SALES." WHERE productid IN ($productids)");
		if($db->affected_rows()>0)
		{
			createhtml('index',PHPCMS_ROOT.'/yp/web');
			showmessage($LANG['operation_success'],$forward);
		}
		else
		{
			showmessage($LANG['operation_failure']);
		}
	break;
		case 'truncate':
		$db->query("DELETE FROM ".TABLE_YP_SALES." WHERE status=-1");
		if($db->affected_rows()>0)
		{
			createhtml('index',PHPCMS_ROOT.'/yp/web');
			showmessage($LANG['operation_success'],$forward);
		}
		else
		{
			showmessage($LANG['operation_failure']);
		}
	break;
}
?>
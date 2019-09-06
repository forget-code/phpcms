<?php 
defined('IN_PHPCMS') or exit('Access Denied');
require PHPCMS_ROOT.'/admin/include/global.func.php';
require_once PHPCMS_ROOT.'/include/formselect.func.php';
$job = isset($job) ? $job : 'manage';
$submenu = array(
	array("<font color='#ff0000'>".$LANG['publish_product']."</font>","?file=$file&action=add"),
	array($LANG['manage_product'],"?file=$file&action=manage&job=manage&label=4"),
	array($LANG['waiting_check'],"?file=$file&action=manage&job=check"),
	array($LANG['recycle'],"?file=$file&action=manage&job=recycle"),
);
$menu = adminmenu($LANG['publish_product'],$submenu);
$CAT = cache_read('categorys_yp.php');

$arrgroupidview_post = explode(',',$MOD['arrgroupidview_post']);
$arrgroupidpost = FALSE;
if(in_array($_groupid,$arrgroupidview_post)) $arrgroupidpost = TRUE;
require_once PHPCMS_ROOT.'/include/tree.class.php';
$module = $mod;
$tree = new tree;

require PHPCMS_ROOT.'/include/field.class.php';
$field = new field($CONFIG['tablepre'].'yp_product');
require_once PHPCMS_ROOT.'/include/formselect.func.php';
$username = $_username;
switch($action)
{
	case 'add':
		if($dosubmit)
		{
			$field->check_form();
			$catid = $product['catid'];
			extract($db->get_one("SELECT setting FROM ".TABLE_CATEGORY." WHERE catid=$catid"));
			$setting = unserialize($setting);
			$enableadd = $setting['enableadd'];
			if($CAT[$catid]['islink'] || $CAT[$catid]['child'] && !$enableadd) showmessage($LANG['no_allow_add']);
			$product['title'] = htmlspecialchars($product['title']);
			$product['thumb'] = htmlspecialchars($product['thumb']);
			$product['keywords'] = htmlspecialchars($product['keywords']);
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
			$sql = "INSERT INTO ".TABLE_YP_PRODUCT." ($sql1) VALUES($sql2)";
			$result = $db->query($sql);
			if($db->affected_rows($result))
			$productid = $db->insert_id();
			$field->update("productid=$productid");
			$enterprise = '';
			if($MOD['enableSecondDomain'])
			{
				$linkurl = $mydomain.'/product.php?item-'.$productid.'.html';
			}
			else
			{
				$linkurl = $MODULE['yp']['linkurl'].'web/product.php?enterprise-'.$domainName.'/item-'.$productid.'.html';
				
			}
			$db->query("UPDATE ".TABLE_YP_PRODUCT." SET linkurl='$linkurl' WHERE productid=$productid ");
			$product['introduce'] = stripslashes($product['introduce']);
			createhtml('header',PHPCMS_ROOT.'/yp/web');
			createhtml('product',PHPCMS_ROOT.'/yp/web');
			createhtml('index',PHPCMS_ROOT.'/yp/web');
			showmessage($LANG['add_success'],$forward);
		}
		else
		{
			if($MOD['ischeck'] && $companystatus!=3) showmessage($LANG['watting_checked']);
			if($vip && $PHP_TIME>$vip) showmessage($LANG['please_buy_vip']);
			$style_edit = style_edit('product[style]','');
			$fields = $field->get_form('<tr><td class="tablerow">$title</td><td class="tablerow">$input $tool $note</td></tr>');
			$category_select = category_select('product[catid]', $LANG['please_select_catgory'], 0,'id="catid"');
			extract($db->get_one("SELECT companyid,address,telephone,email FROM ".TABLE_MEMBER_COMPANY." WHERE username='$_username'"));
			include managetpl('product_add');
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
		$r = $db->get_one("SELECT COUNT(companyid) AS num FROM ".TABLE_YP_PRODUCT." WHERE $status $condition");
		$number = $r['num'];
		$pages = phppages($number,$page,$pagesize);
		$products = array();
		$result = $db->query("SELECT * FROM ".TABLE_YP_PRODUCT." WHERE $status $condition ORDER BY $order LIMIT $offset,$pagesize");		
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
		include managetpl('product_'.$job);
	break;

	case 'status':
		if(empty($productid))
		{
			showmessage($LANG['illegal_parameters']);
		}
		$productids=is_array($productid) ? implode(',',$productid) : $productid;
		$db->query("UPDATE ".TABLE_YP_PRODUCT." SET status=$status WHERE productid IN ($productids) AND username='$_username'");
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
			$product['title'] = htmlspecialchars($product['title']);
			$product['thumb'] = htmlspecialchars($product['thumb']);
			$product['keywords'] = htmlspecialchars($product['keywords']);
			$sql = $s = "";
			foreach($product as $key=>$value)
			{
				$sql .= $s.$key."='".$value."'";
				$s = ",";
			}
			$db->query("UPDATE ".TABLE_YP_PRODUCT." SET $sql WHERE productid='$productid' AND username='$_username'");
			$field->update("productid=$productid");
			$product['introduce'] = stripslashes($product['introduce']);
			createhtml('product',PHPCMS_ROOT.'/yp/web');
			createhtml('index',PHPCMS_ROOT.'/yp/web');
			showmessage($LANG['operation_success'],$forward);
		}
		else
		{			
			@extract($db->get_one("SELECT * FROM ".TABLE_YP_PRODUCT." WHERE productid='$productid'"),EXTR_OVERWRITE);			
			$category_select = category_select('product[catid]', $LANG['please_select_catgory'], $catid,'id="catid"');
			$fields = $field->get_form('<tr><td class="tablerow">$title</td><td class="tablerow">$input $tool $note</td></tr>');
			$style_edit = style_edit("product[style]", $style);
			include managetpl('product_edit');
		}
		break;

		case 'delete':
		if(empty($productid))
		{
			showmessage($LANG['illegal_parameters']);
		}
		$filepath = PHPCMS_ROOT.'/yp/web/userdata/'.$_userdir.'/'.$domainName.'/product/';
		if(is_array($productid))
		{
			foreach($productid AS $id)
			{
				$htmlfilename = $filepath.$id.'.php';
				@unlink($htmlfilename);
			}
		}
		else
		{
				$htmlfilename = $filepath.$productid.'.php';
				@unlink($htmlfilename);
		}
		$productids = is_array($productid) ? implode(',',$productid) : $productid;
		$db->query("DELETE FROM ".TABLE_YP_PRODUCT." WHERE productid IN ($productids) AND username='$_username'");
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
		$db->query("DELETE FROM ".TABLE_YP_PRODUCT." WHERE status=-1");
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
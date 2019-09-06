<?php
defined('IN_PHPCMS') or exit('Access Denied');
$action = $action ? $action : 'manage';
$job = $job ? $job : 'manage';
$jobs = array("manage"=>"status=3 ", "check"=>"status=1", "recycle"=>"status=-1");
array_key_exists($job, $jobs) or showmessage($LANG['illegal_action'], 'goback');
$submenu = array(
	array($LANG['manage_product'],"?mod=$mod&file=$file&action=manage&job=manage"),
	array($LANG['check_product'],"?mod=$mod&file=$file&action=manage&job=check"),
	array($LANG['recycle'],"?mod=$mod&file=$file&action=manage&job=recycle"),
	array($LANG['statistical_report'],"?mod=$mod&file=$file&action=stats"),
);
require PHPCMS_ROOT.'/yp/include/tag.func.php';
require_once PHPCMS_ROOT.'/include/tree.class.php';
$module = $mod;
$tree = new tree;
$catid = isset($catid) ? intval($catid) : 0;
if($catid) $CAT = cache_read('category_'.$catid.'.php');
$menu = adminmenu($LANG['manage_product'],$submenu);
switch($action)
{
	case 'manage':		
		if($job == 'manage')
		{
			$status = 'status>=3';
		}
		elseif($job == 'check')
		{
			$status = 'status=1';
		}
		else
		{
			$status = 'status=-1';
		}
		$pagesize = $PHPCMS['pagesize'];
		$page = isset($page) ? intval($page) : 1;
		$offset = ($page-1)*$pagesize;
		$srchtype = isset($srchtype) ? intval($srchtype) : 0;
		$typeid = isset($typeid) ? intval($typeid) : 0;
		$orders = array('productid DESC', 'productid ASC', 'edittime DESC', 'edittime ASC', 'hits DESC', 'hits ASC');
		$ordertype = isset($ordertype) ? intval($ordertype) : 0;
		$order = $orders[$ordertype];
		$category_select = category_select('catid', $LANG['please_select_catgory'], $catid);
		$category_jump = category_select('catid', $LANG['please_choose_category_manage'], $catid, "onchange=\"if(this.value!=''){location='?mod=$mod&file=$file&action=manage&typeid=$typeid&job=$job&catid='+this.value;}\"");
		$condition = '';
		$condition .= $catid ? 'AND catid='.$catid.' ' : '';
		$condition .= $typeid ? 'AND typeid='.$typeid.' ' : '';
		$condition .= isset($label) ? 'AND label='.$label.' ' : '';
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
			extract($db->get_one("SELECT companyname,linkurl FROM ".TABLE_MEMBER_COMPANY." WHERE companyid=$r[companyid]"));
			$r['companyname'] = $companyname;
			$r['domain'] = $linkurl;
			$products[] = $r;
		}
	include admintpl('product_'.$job);
	break;

case 'listorder':
	if(empty($listorder) || !is_array($listorder))
	{
		showmessage($LANG['illegal_parameters']);
	}
	foreach($listorder as $key=>$val)
	{
		$db->query("UPDATE ".TABLE_YP_PRODUCT." SET `listorder`='$val' WHERE productid=$key ");
	}
	showmessage($LANG['update_success'],$forward);

break;

case 'status' :
	if(empty($productid))
	{
		showmessage($LANG['illegal_parameters']);
	}
	if(!is_numeric($status))
	{
		showmessage($LANG['illegal_parameters']);
	}
	if(is_array($productid))
	{
		$arr_product = $productid;
		$productids = implode(',',$productid);
	}
	else
	{
		$productids = $productid;
	}
	$db->query("UPDATE ".TABLE_YP_PRODUCT." SET status=$status WHERE productid IN ($productids)");	
	if($db->affected_rows()>0)
	{
		if($status==3)
		{	
			foreach($arr_product AS $aid)
			{
				extract($db->get_one("SELECT companyid FROM ".TABLE_YP_PRODUCT." WHERE productid=$aid"));
				if($MOD['enableSecondDomain'])
				{
					extract($db->get_one("SELECT *,companyname AS pagename,sitedomain AS domainName,templateid AS defaultTplType,banner,background,introduce,menu FROM ".TABLE_MEMBER_COMPANY." WHERE companyid='$companyid'"));
				}
				else
				{
					extract($db->get_one("SELECT m.username,m.userid, c.companyname AS pagename,c.templateid AS defaultTplType,c.* FROM ".TABLE_MEMBER_COMPANY." c, ".TABLE_MEMBER." m WHERE c.companyid='$companyid' AND c.username=m.username"));
				}
				if($background)
				{
					$backgrounds = explode('|',$background);
					$backgroundtype = $backgrounds[0];
					$background = $backgrounds[1];
				}
				createhtml('index');
			}
		}
		showmessage($LANG['operation_success'],$forward);
	}
	else
	{
		showmessage($LANG['operation_failure']);
	}
	break;
case 'truncate':
	$db->query("DELETE FROM ".TABLE_YP_PRODUCT." WHERE status='-1'");
	showmessage($LANG['operation_success'],$forward);
	break;
case 'delete':
	if(empty($productid))
	{
		showmessage($LANG['illegal_parameters']);
	}
	$productids = is_array($productid) ? implode(',',$productid) : $productid;
	$db->query("DELETE FROM ".TABLE_YP_PRODUCT." WHERE productid IN ($productids)");
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
	require PHPCMS_ROOT.'/include/field.class.php';
	$field = new field($CONFIG['tablepre'].'yp_product');
	if($dosubmit)
	{
		$field->check_form();
		if($MOD['enableSecondDomain'])
		{
			extract($db->get_one("SELECT companyname AS pagename,sitedomain AS domainName,templateid AS defaultTplType,banner,background,introduce,menu FROM ".TABLE_MEMBER_COMPANY." WHERE companyid='$companyid'"));
			$product['linkurl'] = 'http://'.$domainName.'.'.$MOD['secondDomain'].'/product.php?item-'.$productid.'.html';
		}
		else
		{
			extract($db->get_one("SELECT m.username,m.userid, c.companyname AS pagename,c.templateid AS defaultTplType,c.banner,c.background,c.introduce,c.menu FROM ".TABLE_MEMBER_COMPANY." c, ".TABLE_MEMBER." m WHERE c.companyid='$companyid' AND c.username=m.username"));
			$product['linkurl'] = $MODULE['yp']['linkurl'].'web/product.php?enterprise-'.$userid.'/item-'.$productid.'.html';	
		}
		if($background)
		{
			$backgrounds = explode('|',$background);
			$backgroundtype = $backgrounds[0];
			$background = $backgrounds[1];
		}
		$product['title'] = htmlspecialchars($product['title']);
		$product['thumb'] = htmlspecialchars($product['thumb']);
		$product['keywords'] = htmlspecialchars($product['keywords']);

		$sql = $s = "";
		foreach($product as $key=>$value)
		{
			$sql .= $s.$key."='".$value."'";
			$s = ",";
		}	
		$db->query("UPDATE ".TABLE_YP_PRODUCT." SET $sql WHERE productid='$productid'");
		$field->update("productid=$productid");
		$periodtime = $PHP_TIME+$product['period']*86400;
		$product['period'] = date('Y-m-d',$periodtime);
		$product['introduce'] = stripslashes($product['introduce']);
		createhtml('product');
		showmessage($LANG['operation_success'],$forward);
	}
	else
	{
		@extract($db->get_one("SELECT * FROM ".TABLE_YP_PRODUCT." WHERE productid='$productid'"),EXTR_OVERWRITE);		
		$fields = $field->get_form('<tr><td class="tablerow">$title</td><td class="tablerow">$input $tool $note</td></tr>');
		$CAT = cache_read('categorys_'.$mod.'.php');
		$category_select = category_select('product[catid]', $LANG['please_select_catgory'], $catid,'id="catid"');
		$style_edit = style_edit("product[style]", $style);
		include admintpl('product_edit');
	}

	break;
	case 'stats':
		require_once PHPCMS_ROOT.'/admin/include/category_module.class.php';
		$username = isset($username) ? $username : '';
		$fromdate = isset($fromdate) && preg_match('/^([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})/', $fromdate) ? $fromdate : '';
		$fromtime = $fromdate ? strtotime($fromdate.' 0:0:0') : 0;
		$todate = isset($todate) && preg_match('/^([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})/', $todate) ? $todate : '';
		$totime = $todate ? strtotime($todate.' 23:59:59') : 0;
		$sql = '';
		if($username) $sql .= " and username='$username' ";
		if($fromtime) $sql .= " and addtime>$fromtime ";
		if($totime) $sql .= " and addtime<$totime ";
		$tree = new tree;
		$cat = new category_module($module, $catid);
		$list = $cat->get_list();
		if(is_array($list))
		{
			$categorys = array();
			$sum__1 = $sum_1 = $sum_3 =0;
			foreach($list as $catid => $category)
			{
				$status[-1] = 'num__1';
				$status[1] = 'num_1';
				$status[3] = 'num_3';
				for($i=-1; $i<4; $i++)
				{
					$r = $db->get_one("select count(productid) as num from ".TABLE_YP_PRODUCT." where status=$i and catid=$catid $sql ");
					$$status[$i] = $r['num'];
				}
				$percent__1 = $percent_1 = $percent_3 =0;
				$sum = $num__1+$num_1+$num_3;
				$sum__1 += $num__1;
				$sum_1 += $num_1;
				$sum_3 += $num_3;
				if($sum > 0)
				{
					$percent__1 = round(100*$num__1/$sum, 1);
					$percent_1 = round(100*$num_1/$sum, 1);
					$percent_3 = round(100*$num_3/$sum, 1);
				}
			
				$categorys[$category['catid']] = array('id'=>$category['catid'],'parentid'=>$category['parentid'],'name'=>$category['catname'],'listorder'=>$category['listorder'],'style'=>$category['style'],'mod'=>$mod,'channelid'=>$channelid,'file'=>$file,'num__1'=>$num__1,'num_0'=>$num_0,'num_1'=>$num_1,'num_2'=>$num_2,'num_3'=>$num_3,'percent__1'=>$percent__1,'percent_1'=>$percent_1,'percent_3'=>$percent_3);
			}
			$str = "<tr onmouseout=this.style.backgroundColor='#F1F3F5' onmouseover=this.style.backgroundColor='#BFDFFF' bgColor='#F1F3F5' height='23'>
						<td>\$id</td>
						<td>\$spacer<a href='?mod=\$mod&file=\$file&action=manage&catid=\$id'><span style='\$style'>\$name</span></a></td>
						<td><span style='float:right;font-size:10px;'>\$percent_3%</span><a href='?mod=\$mod&file=\$file&action=manage&catid=\$id'>\$num_3</a></td>
						<td><span style='float:right;font-size:10px;'>\$percent_1%</span><a href='?mod=\$mod&file=\$file&action=manage&job=check&catid=\$id'>\$num_1</a></td>
						<td><span style='float:right;font-size:10px;'>\$percent__1%</span><a href='?mod=\$mod&file=\$file&action=manage&job=recycle&catid=\$id'>\$num__1</a></td>
					</tr>";
			$tree->tree($categorys);
			$categorys = $tree->get_tree(0,$str);
		}
		include admintpl('product_stats');
	break;
}
?>
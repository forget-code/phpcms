<?php
defined('IN_PHPCMS') or exit('Access Denied');
$action = $action ? $action : 'manage';
$job = $job ? $job : 'manage';
$jobs = array("manage"=>"status=3 ", "check"=>"status=1", "recycle"=>"status=-1");
array_key_exists($job, $jobs) or showmessage($LANG['illegal_action'], 'goback');
$submenu = array(
	array($LANG['article_manage'],"?mod=$mod&file=$file&action=manage&job=manage"),
	array($LANG['check_manage'],"?mod=$mod&file=$file&action=manage&job=check"),
	array($LANG['recycle'],"?mod=$mod&file=$file&action=manage&job=recycle"),
	array($LANG['statistical_report'],"?mod=$mod&file=$file&action=stats"),
);
require PHPCMS_ROOT.'/yp/include/tag.func.php';
require_once PHPCMS_ROOT.'/include/tree.class.php';
$module = $mod;
$tree = new tree;
require_once PHPCMS_ROOT.'/yp/include/trade.func.php';

$catid = isset($catid) ? intval($catid) : 0;
$TRADE = cache_read('trades_article.php');
$menu = adminmenu($LANG['article_manage'],$submenu);
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
		$orders = array('articleid DESC', 'articleid ASC', 'edittime DESC', 'edittime ASC', 'hits DESC', 'hits ASC');
		$ordertype = isset($ordertype) ? intval($ordertype) : 0;
		$order = $orders[$ordertype];
		$category_select = type_select('catid', $LANG['select_catid'],$catid);
		$category_jump = type_select('catid', $LANG['select_catid'],$catid,"onchange=\"if(this.value!=''){location='?mod=$mod&file=$file&action=manage&typeid=$typeid&job=$job&catid='+this.value;}\"");

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
		$r = $db->get_one("SELECT COUNT(companyid) AS num FROM ".TABLE_YP_ARTICLE." WHERE $status $condition");
		$number = $r['num'];
		$pages = phppages($number,$page,$pagesize);
		$articles = array();
		$result = $db->query("SELECT * FROM ".TABLE_YP_ARTICLE." WHERE $status $condition ORDER BY $order LIMIT $offset,$pagesize");		
		while($r = $db->fetch_array($result))
		{
			$r['addtime'] = date('Y-m-d',$r['addtime']);
			$r['edittime'] = date('Y-m-d H:i:s',$r['edittime']);
			$r['checktime'] = date('Y-m-d H:i:s',$r['checktime']);
			@extract($db->get_one("SELECT companyname,linkurl FROM ".TABLE_MEMBER_COMPANY." WHERE companyid=$r[companyid]"));
			$r['companyname'] = $companyname;
			$r['domain'] = $linkurl;
			$articles[] = $r;
		}
	include admintpl('article_'.$job);
	break;

case 'listorder':
	if(empty($listorder) || !is_array($listorder))
	{
		showmessage($LANG['illegal_parameters']);
	}
	foreach($listorder as $key=>$val)
	{
		$db->query("UPDATE ".TABLE_YP_ARTICLE." SET `listorder`='$val' WHERE articleid=$key ");
	}
	showmessage($LANG['update_success'],$forward);
break;

case 'status' :
	if(empty($articleid))
	{
		showmessage($LANG['illegal_parameters']);
	}
	if(!is_numeric($status))
	{
		showmessage($LANG['illegal_parameters']);
	}
	if(is_array($articleid))
	{
		$arr_article = $articleid;
		$articleids = implode(',',$articleid);
	}
	else
	{
		$articleids = $articleid;
	}
	$db->query("UPDATE ".TABLE_YP_ARTICLE." SET status=$status WHERE articleid IN ($articleids)");
	

	if($db->affected_rows()>0)
	{
		if($status==3)
		{	
			foreach($arr_article AS $aid)
			{
				extract($db->get_one("SELECT companyid FROM ".TABLE_YP_ARTICLE." WHERE articleid=$aid"));
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
	$db->query("DELETE FROM ".TABLE_YP_ARTICLE." WHERE status='-1'");
	showmessage($LANG['operation_success'],$forward);
	break;
case 'delete':
	if(empty($articleid))
	{
		showmessage($LANG['illegal_parameters']);
	}
	$articleids = is_array($articleid) ? implode(',',$articleid) : $articleid;
	$db->query("DELETE FROM ".TABLE_YP_ARTICLE." WHERE articleid IN ($articleids)");
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
		if($MOD['enableSecondDomain'])
		{
			extract($db->get_one("SELECT username,companyname AS pagename,sitedomain AS domainName,templateid AS defaultTplType,banner,background,introduce,menu FROM ".TABLE_MEMBER_COMPANY." WHERE companyid='$companyid'"));
			$product['linkurl'] = 'http://'.$domainName.'.'.$MOD['secondDomain'].'/article.php?item-'.$articleid.'.html';
		}
		else
		{
			extract($db->get_one("SELECT m.username,m.userid, c.companyname AS pagename,c.templateid AS defaultTplType,c.banner,c.background,c.introduce,c.menu FROM ".TABLE_MEMBER_COMPANY." c, ".TABLE_MEMBER." m WHERE c.companyid='$companyid' AND c.username=m.username"));
			$product['linkurl'] = $MODULE['yp']['linkurl'].'web/article.php?enterprise-'.$userid.'/item-'.$articleid.'.html';
		}
		if($background)
		{
			$backgrounds = explode('|',$background);
			$backgroundtype = $backgrounds[0];
			$background = $backgrounds[1];
		}
		$sql = $s = "";
		foreach($article as $key=>$value)
		{
			$sql .= $s.$key."='".$value."'";
			$s = ",";
		}
		$db->query("UPDATE ".TABLE_YP_ARTICLE." SET $sql WHERE articleid='$articleid'");
		if($background)
		{
			$backgrounds = explode('|',$background);
			$backgroundtype = $backgrounds[0];
			$background = $backgrounds[1];
		}
		$article['content'] = stripslashes($article['content']);
		createhtml('article');
		showmessage($LANG['operation_success'],$forward);

	}
	else
	{
		@extract($db->get_one("SELECT * FROM ".TABLE_YP_ARTICLE." WHERE articleid='$articleid'"),EXTR_OVERWRITE);
		$categorys = trade_select('article[catid]', $LANG['select_catid'],$catid,"id='catid'");
		$style_edit = style_edit("article[style]", $style);
		include admintpl('article_edit');
	}

	break;
	case 'stats':
require_once MOD_ROOT.'/include/trade.class.php';

		$username = isset($username) ? $username : '';
		$fromdate = isset($fromdate) && preg_match('/^([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})/', $fromdate) ? $fromdate : '';
		$fromtime = $fromdate ? strtotime($fromdate.' 0:0:0') : 0;
		$todate = isset($todate) && preg_match('/^([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})/', $todate) ? $todate : '';
		$totime = $todate ? strtotime($todate.' 23:59:59') : 0;
		$sql = '';
		if($username) $sql .= " and username='$username' ";
		if($fromtime) $sql .= " and addtime>$fromtime ";
		if($totime) $sql .= " and addtime<$totime ";
		$cat = new trade('article', $catid);
		
		$list = $cat->get_list();
		if(is_array($list))
		{
			$categorys = array();
			$sum__1 = $sum_0 = $sum_1 = $sum_2 = $sum_3 =0;
			foreach($list as $catid => $category)
			{
				$status[-1] = 'num__1';
				$status[1] = 'num_1';
				$status[3] = 'num_3';
				for($i=-1; $i<4; $i++)
				{
					$r = $db->get_one("select count(articleid) as num from ".TABLE_YP_ARTICLE." where status=$i and catid=$catid $sql ");
					$$status[$i] = $r['num'];
				}
				$percent__1 = $percent_1  = $percent_3 =0;
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
			
				$categorys[$category['tradeid']] = array('id'=>$category['tradeid'],'parentid'=>$category['parentid'],'name'=>$category['tradename'],'listorder'=>$category['listorder'],'style'=>$category['style'],'file'=>$file,'num__1'=>$num__1,'num_1'=>$num_1,'num_3'=>$num_3,'percent__1'=>$percent__1,'percent_1'=>$percent_1,'percent_3'=>$percent_3);
			}
			$str = "<tr onmouseout=this.style.backgroundColor='#F1F3F5' onmouseover=this.style.backgroundColor='#BFDFFF' bgColor='#F1F3F5' height='23'>
						<td>\$id</td>
						<td>\$spacer<a href='?mod=yp&file=\$file&action=manage&catid=\$id'><span style='\$style'>\$name</span></a></td>
						<td><span style='float:right;font-size:10px;'>\$percent_3%</span><a href='?mod=\$mod&file=\$file&action=manage&catid=\$id'>\$num_3</a></td>
						<td><span style='float:right;font-size:10px;'>\$percent_1%</span><a href='?mod=\$mod&file=\$file&action=manage&job=check&catid=\$id'>\$num_1</a></td>
						<td><span style='float:right;font-size:10px;'>\$percent__1%</span><a href='?mod=\$mod&file=\$file&action=manage&job=recycle&catid=\$id'>\$num__1</a></td>
					</tr>";
			$tree->tree($categorys);
			$categorys = $tree->get_tree(0,$str);

		}
		include admintpl('article_stats');
	break;
}
?>
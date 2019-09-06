<?php
defined('IN_PHPCMS') or exit('Access Denied');
@set_time_limit(600);
require MOD_ROOT.'/include/urlrule.inc.php';
require MOD_ROOT.'/include/tag.func.php';
require MOD_ROOT.'/include/global.func.php';
require PHPCMS_ROOT."/include/module.func.php";
$referer=isset($referer) ? $referer : "?mod=$mod&file=$file";
if(isset($action) && strpos($action, ','))
{
	$actions=explode(',',$action);
	$action=$actions[0];
	unset($actions[0]);
	$actions=implode(',',$actions);
	$referer='?mod='.$mod.'&file='.$file.'&action='.$actions;
}
$action = $action ? $action : 'main';
switch($action)
{
	case 'index':
		createhtml("index_yp");
		showmessage($LANG['yp_index_update_succss'], $referer);
	break;
	
	case 'product':
	
	if(isset($_SESSION["temp_cat_name"]))
	{
		include PHPCMS_ROOT.'/data/temp/'.$_SESSION["temp_cat_name"];
		$catid = array_shift($cats_array);
		if(!$catid)
		{
			unlink(PHPCMS_ROOT.'/data/temp/'.$_SESSION["temp_cat_name"]);
			unset($_SESSION["temp_cat_name"]);
			showmessage($LANG['update_success'],'?mod=yp&file=createhtml');
		}
		array_save($cats_array,"\$cats_array",PHPCMS_ROOT.'/data/temp/'.$_SESSION["temp_cat_name"]);
		$referer = '?mod='.$mod.'&file='.$file.'&action='.$action;
	}
	if(empty($cats) && !$catid)
	{
		$cats = array();
		foreach($CATEGORY as $r)
		{
			$cats[] = $r['catid'];
		}
	}
	if(isset($cats) && is_array($cats))
	{
		$_SESSION["temp_cat_name"] = 'T'.$PHP_TIME.'.php';
		array_save($cats,"\$cats_array",PHPCMS_ROOT.'/data/temp/'.$_SESSION["temp_cat_name"]);
		unset($cats);
		showmessage($LANG['begin_update_category'].'...','?mod='.$mod.'&file='.$file.'&action='.$action);
	}
	elseif(is_numeric($catid))
	{
		createhtml("list_yp");
		showmessage($LANG['category'].' ['.$CATEGORY[$catid]['catname'].'] '.$LANG['update_success'].'...',$referer);
	}
	break;

	case 'url':
		switch($label)
		{
			case 'article':
				$table = TABLE_YP_ARTICLE;
				$label_alt = $LANG['label_article'];
				$flagid = 'articleid';
			break;
			case 'product':
				$table = TABLE_YP_PRODUCT;
				$label_alt = $LANG['label_product'];
				$flagid = 'productid';
			break;
			case 'job':
				$table = TABLE_YP_JOB;
				$label_alt = $LANG['label_job'];
				$flagid = 'jobid';
			break;
			case 'buy':
				$table = TABLE_YP_BUY;
				$label_alt = $LANG['label_buy'];
				$flagid = 'productid';
			break;
			case 'sales':
				$table = TABLE_YP_SALES;
				$label_alt = $LANG['label_sales'];
				$flagid = 'productid';
			break;
		}

		if(!isset($fid))
		{
			$r=$db->get_one("SELECT min($flagid) AS fid FROM ".$table);
			$fid=$r['fid'];
		}
		if(!isset($tid))
		{
			$r=$db->get_one("SELECT max($flagid) AS tid FROM ".$table);
			$tid=$r['tid'];
		}
		$pernum = isset($pernum) ? intval($pernum) : 100 ;
		if($fid+$pernum < $tid)
		{
			$query = "SELECT $flagid FROM ".$table." WHERE status>=3 AND $flagid>=$fid ORDER BY $flagid LIMIT 0,$pernum ";
			$result = $db->query($query);
			if($db->affected_rows($result) > 0)
			{
				while($r = $db->fetch_array($result))
				{
					$labelid = $r[$flagid];
					update_url($table,$label,$labelid,$flagid);
				}
			}
			else
			{
				$labelid = $fid + $pernum;
			}
		}
		elseif($fid<$tid)
		{
			$query = "SELECT $flagid FROM ".$table." WHERE status>=3 AND $flagid>=$fid ORDER BY $flagid LIMIT 0,$pernum ";
			$result = $db->query($query);
			while($r = $db->fetch_array($result))
			{
				$labelid = $r[$flagid];
				update_url($table,$label,$labelid,$flagid);
			}
			showmessage($label_alt.$LANG['link_success'],'?mod='.$mod.'&file='.$file.'&label='.$label);
		}
		else
		{
			showmessage($label_alt.$LANG['link_success'],'?mod='.$mod.'&file='.$file.'&label='.$label);
		}
		$referer='?mod='.$mod.'&file='.$file.'&action='.$action.'&fid='.$labelid.'&tid='.$tid.'&pernum='.$pernum.'&label='.$label;
		showmessage('ID '.$LANG['from'].$fid.' '.$LANG['to'].' '.($fid+$pernum-1).' '.$label_alt.$LANG['link_success'], $referer);
	break;

	case 'show':
		switch($label)
		{
			case 'article':
				$table = TABLE_YP_ARTICLE;
				$label_alt = $LANG['label_article'];
				$flagid = 'articleid';
			break;
			case 'product':
				$table = TABLE_YP_PRODUCT;
				$label_alt = $LANG['label_product'];
				$flagid = 'productid';
			break;
			case 'job':
				$table = TABLE_YP_JOB;
				$label_alt = $LANG['label_job'];
				$flagid = 'jobid';
			break;
			case 'buy':
				$table = TABLE_YP_BUY;
				$label_alt = $LANG['label_buy'];
				$flagid = 'productid';
			break;
			case 'sales':
				$table = TABLE_YP_SALES;
				$label_alt = $LANG['label_sales'];
				$flagid = 'productid';
			break;
		}

		$tmpskindir = $skindir;
		if(!isset($fid))
		{
			$r=$db->get_one("SELECT min($flagid) as fid FROM ".$table);
			$fid=$r['fid'];
		}
		if(!isset($tid))
		{
			$r=$db->get_one("SELECT max($flagid) as tid FROM ".$table);
			$tid=$r['tid'];
		}
		$pernum = isset($pernum) ? intval($pernum) : 100 ;
		if($fid+$pernum < $tid)
		{
			$query = "SELECT $flagid FROM ".$table." WHERE status>=3 AND $flagid>=$fid order by $flagid LIMIT 0,$pernum ";
			$result = $db->query($query);
			if($db->affected_rows($result) > 0)
			{
				while($r = $db->fetch_array($result))
				{
					$labelid = $r[$flagid];
					$skindir = $tmpskindir; 
					createhtml_show($table,$label,$labelid,$flagid);
				}
			}
			else
			{
				$labelid = $fid + $pernum;
			}
		}
		elseif($fid<=$tid)
		{
			$query = "SELECT $flagid FROM ".$table." WHERE status>=3 AND $flagid>=$fid ORDER BY $flagid LIMIT 0,$pernum ";
			$result = $db->query($query);
			while($r = $db->fetch_array($result))
			{
				$labelid = $r[$flagid];
				$skindir = $tmpskindir; 
				createhtml_show($table,$label,$labelid,$flagid);
			}
			showmessage($label_alt.$LANG['html_success'],'?mod='.$mod.'&file='.$file.'&label='.$label);
		}
		else
		{
			showmessage($label_alt.$LANG['html_success'],'?mod='.$mod.'&file='.$file.'&label='.$label);
		}
		$referer='?mod='.$mod.'&file='.$file.'&action='.$action.'&fid='.$labelid.'&tid='.$tid.'&pernum='.$pernum.'&label='.$label;
		showmessage('ID '.$LANG['from'].$fid.' '.$LANG['to'].' '.($fid+$pernum-1).' '.$label_alt.$LANG['html_success'], $referer);
	break;

	case 'searchjs':
		require_once PHPCMS_ROOT."/include/formselect.func.php";
		require_once PHPCMS_ROOT."/include/tree.class.php";
		$tree = new tree();
		$category_select = category_select('catid',$LANG['select_catid']);
		$type_selected = "<select name='typeid' ><option value='0'>".$LANG['please_choose_company_type']."</option>";
		$types = explode("\n",$MOD['type']);
		foreach($types AS $t)
		{
			$selected = '';
			$type_selected .= "<option value='$t'>$t</option>";
		}
		$type_selected .= "</select>";
		$TRADE = cache_read('trades_trade.php');
		require_once PHPCMS_ROOT.'/yp/include/trade.func.php';
		$trade_selected = trade_select('tradeid',$LANG['please_choose_company_trade']);
		$TRADE = cache_read('trades_article.php');
		$article_selected = trade_select('articlecatid', $LANG['select_category']);
		ob_start();
		include template('yp', 'search_form');
		$data = ob_get_contents();
		ob_clean();
		$data = strip_js($data);
		$jsname = PHPCMS_ROOT."/data/js/yp_search.js";
		@file_put_contents($jsname,$data);
		showmessage($LANG['js_success'],$forward);
	break;

	default :
		$submenu = array(
		array('<font color="red">'.$LANG['update_channel_index'].'</font>','?mod='.$mod.'&file='.$file.'&action=index'),
		array('<font color="blue">'.$LANG['update_channel_product'].'</font>','?mod='.$mod.'&file='.$file.'&action=product'),
		array($LANG['update_searchjs'],'?mod='.$mod.'&file='.$file.'&action=searchjs'),
		);
		$menu=adminmenu($LANG['update_yp'],$submenu);
		extract($db->get_one("SELECT min(companyid) AS mincompanyid,max(companyid) AS maxcompanyid FROM ".TABLE_MEMBER_COMPANY." "));
		extract($db->get_one("SELECT min(articleid) AS minarticleid,max(articleid) AS maxarticleid FROM ".TABLE_YP_ARTICLE." "));
		extract($db->get_one("SELECT min(productid) AS minproductid,max(productid) AS maxproductid FROM ".TABLE_YP_PRODUCT." "));
		extract($db->get_one("SELECT min(productid) AS minbuyid,max(productid) AS maxbuyid FROM ".TABLE_YP_BUY." "));
		extract($db->get_one("SELECT min(productid) AS minsalesid,max(productid) AS maxsalesid FROM ".TABLE_YP_SALES." "));
		extract($db->get_one("SELECT min(jobid) AS minjobid,max(jobid) AS maxjobid FROM ".TABLE_YP_JOB." "));
		if(!$mincompanyid) $mincompanyid = $maxcompanyid = 0;
		if(!$minarticleid) $minarticleid = $maxarticleid = 0;
		if(!$minproductid) $minproductid = $maxproductid = 0;
		if(!$minbuyid) $minbuyid = $maxbuyid = 0;
		if(!$minsalesid) $minsalesid = $maxsalesid = 0;
		if(!$minjobid) $minjobid = $maxjobid = 0;
		include admintpl('createhtml');
	break;
}
?>
<?php 
defined('IN_PHPCMS') or exit('Access Denied');
$submenu = array(
	array($LANG['article_manage'],"?file=$file&action=manage"),
	array($LANG['add_manage'],"?file=article&action=add"),
	array($LANG['waiting_check'],"?file=$file&action=manage&status=1"),
	array($LANG['recycle'],"?file=$file&action=manage&status=-1"),

);
require PHPCMS_ROOT.'/admin/include/global.func.php';
require_once PHPCMS_ROOT.'/include/formselect.func.php';
$menu = adminmenu($LANG['article_manage'],$submenu);
$username = $_username;
$TRADE = cache_read('trades_article.php');

$arrgroupidview_post = explode(',',$MOD['arrgroupidview_post']);
$arrgroupidpost = FALSE;
if(in_array($_groupid,$arrgroupidview_post)) $arrgroupidpost = TRUE;
require_once PHPCMS_ROOT.'/include/tree.class.php';
$module = $mod;
$tree = new tree;
require_once PHPCMS_ROOT.'/yp/include/trade.func.php';

switch($action)
{
	case 'add':
		if($dosubmit)
		{
			$article['username'] = $_username;
			$article['title'] = htmlspecialchars($article['title']);
			$article['thumb'] = htmlspecialchars($article['thumb']);
			$article['keywords'] = htmlspecialchars($article['keywords']);
			$article['addtime'] = $article['edittime'] = $article['checktime'] = $PHP_TIME;
			$sql1 = $sql2 = $s = "";
			foreach($article as $key=>$value)
			{
				$sql1 .= $s.$key;
				$sql2 .= $s."'".$value."'";
				$s = ",";
			}
			$sql = "INSERT INTO ".TABLE_YP_ARTICLE." ($sql1) VALUES($sql2)";
			$result = $db->query($sql);
			if($db->affected_rows($result))
			$articleid = $db->insert_id();
			if($MOD['enableSecondDomain'])
			{
				$linkurl = $mydomain.'/article.php?item-'.$articleid.'.html';
			}
			else
			{
				$linkurl = $MODULE['yp']['linkurl'].'web/article.php?enterprise-'.$domainName.'/item-'.$articleid.'.html';
				
			}
			$db->query("UPDATE ".TABLE_YP_ARTICLE." SET linkurl='$linkurl' WHERE articleid=$articleid ");
			extract($db->get_one("SELECT banner,background,introduce FROM ".TABLE_MEMBER_COMPANY." WHERE username='$_username'"));
			if($background)
			{
				$backgrounds = explode('|',$background);
				$backgroundtype = $backgrounds[0];
				$background = $backgrounds[1];
			}
			createhtml('header',PHPCMS_ROOT.'/yp/web');
			createhtml('article',PHPCMS_ROOT.'/yp/web');
			createhtml('index',PHPCMS_ROOT.'/yp/web');
			showmessage($LANG['add_success'],$forward);
		}
		else
		{
			if($MOD['ischeck'] && $companystatus!=3) showmessage($LANG['watting_checked']);
			if($vip && $PHP_TIME>$vip) showmessage($LANG['please_buy_vip']);
			$categorys = type_select('article[catid]', $LANG['select_catid'],'',"id='catid'");
			$style_edit = style_edit('article[style]','');
			break;
		}

	case 'manage':
		$catid = isset($catid) ? $catid : '';
		$categorys = type_select('article[catid]', $LANG['select_catid'],$catid,"id='catid'");
		$ordertype = isset($ordertype) ? intval($ordertype) : 0;
		$status = isset($status) ? "status=".intval($status) : "status>=3";
		$pagesize = $PHPCMS['pagesize'];
		$page = isset($page) ? intval($page) : 1;
		$offset = ($page-1)*$pagesize;
		$orders = array('articleid DESC', 'articleid ASC', 'edittime DESC', 'edittime ASC', 'hits DESC', 'hits ASC');
		$condition = '';
		$condition .= $catid ? " AND catid=$catid " : '';
		$keywords = !empty($keywords) ? trim($keywords) : '';
		if($keywords)
		{
			$keywords = trim($keywords);
			$keywords = str_replace(' ','%',$keywords);
			$keywords = str_replace('*','%',$keywords);
			$condition .= " AND title LIKE '%$keywords%' ";
		}
		$condition .= " AND username='$_username'";
		$r = $db->get_one("SELECT COUNT(articleid) AS num FROM ".TABLE_YP_ARTICLE." WHERE $status $condition");
		$number = $r['num'];
		$pages = phppages($number,$page,$pagesize);
		$articles = array();
		$result = $db->query("SELECT * FROM ".TABLE_YP_ARTICLE." WHERE $status $condition ORDER BY $orders[$ordertype] LIMIT $offset,$pagesize");		
		while($r = $db->fetch_array($result))
		{
			$r['addtime'] = date('Y-m-d',$r['addtime']);
			$r['edittime'] = date('Y-m-d H:i:s',$r['edittime']);
			$r['checktime'] = date('Y-m-d H:i:s',$r['checktime']);
			$articles[] = $r;
		}
		break;
	case 'status':
		if(empty($articleid))
		{
			showmessage($LANG['illegal_parameters']);
		}
		$articleids=is_array($articleid) ? implode(',',$articleid) : $articleid;
		$db->query("UPDATE ".TABLE_YP_ARTICLE." SET status=$status WHERE articleid IN ($articleids) AND username='$_username'");
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
			$sql = $s = "";
			$article['title'] = htmlspecialchars($article['title']);
			$article['thumb'] = htmlspecialchars($article['thumb']);
			$article['keywords'] = htmlspecialchars($article['keywords']);
			foreach($article as $key=>$value)
			{
				$sql .= $s.$key."='".$value."'";
				$s = ",";
			}
			$db->query("UPDATE ".TABLE_YP_ARTICLE." SET $sql WHERE articleid='$articleid' AND username='$_username'");
			extract($db->get_one("SELECT banner,background,introduce FROM ".TABLE_MEMBER_COMPANY." WHERE username='$_username'"));
			if($background)
			{
				$backgrounds = explode('|',$background);
				$backgroundtype = $backgrounds[0];
				$background = $backgrounds[1];
			}
			$article['content'] = stripslashes($article['content']);
			createhtml('article',PHPCMS_ROOT.'/yp/web');
			createhtml('index',PHPCMS_ROOT.'/yp/web');
			showmessage($LANG['operation_success'],$forward);
		}
		else
		{
			@extract($db->get_one("SELECT * FROM ".TABLE_YP_ARTICLE." WHERE articleid='$articleid'"),EXTR_OVERWRITE);
			$categorys = type_select('article[catid]', $LANG['select_catid'],$catid);
			$style_edit = style_edit("article[style]", $style);
	}
	break;

	case 'delete':
		if(empty($articleid))
		{
			showmessage($LANG['illegal_parameters']);
		}
		$filepath = PHPCMS_ROOT.'/yp/web/userdata/'.$_userdir.'/'.$domainName.'/article/';
		if(is_array($articleid))
		{
			foreach($articleid AS $id)
			{
				$htmlfilename = $filepath.$id.'.php';
				@unlink($htmlfilename);
			}
		}
		else
		{
				$htmlfilename = $filepath.$articleid.'.php';
				@unlink($htmlfilename);
		}
		$articleids = is_array($articleid) ? implode(',',$articleid) : $articleid;
		$db->query("DELETE FROM ".TABLE_YP_ARTICLE." WHERE articleid IN ($articleids) AND username='$_username'");
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
include managetpl('article_'.$action);
?>
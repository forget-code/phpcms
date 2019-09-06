<?php
defined('IN_PHPCMS') or exit('Access Denied');
include(PHPCMS_ROOT."/$mod/admin/menu.inc.php");
require_once PHPCMS_ROOT."/include/tree.class.php";
$tree = new tree();
$submenu = array
(
	array($LANG['all_question'], '?mod='.$mod.'&file='.$file.'&action=manage'),
	array($LANG['not_solve'], '?mod='.$mod.'&file='.$file.'&action=manage&job=1'),
	array($LANG['solve'], '?mod='.$mod.'&file='.$file.'&action=manage&job=2'),
	array($LANG['vote'], '?mod='.$mod.'&file='.$file.'&action=manage&job=3'),
	array($LANG['commend_question'], '?mod='.$mod.'&file='.$file.'&action=manage&job=2&commend=1'),
	array($LANG['close_question'], '?mod='.$mod.'&file='.$file.'&action=manage&job=4'),
	array($LANG['outtime_question'], '?mod='.$mod.'&file='.$file.'&action=manage&job=1&pass=1')
);
$CATEGORY = cache_read('categorys_'.$mod.'.php');
$menu=adminmenu($LANG['question_manage'],$submenu);

$action = $action ? $action : 'manage';

$search_fromdates = isset($search_fromdate) ? strtotime($search_fromdate) : '';
$search_todates = isset($search_todate) ? strtotime($search_todate) : '';
$sql .= "";
if($search_fromdate && $search_todate) $sql .=" AND asktime >= '$search_fromdates' AND asktime <= '$search_todates'";
if($search_fromdate && !$search_todate) $sql .=" AND asktime >= '$search_fromdates'";  

if($search_todate && !$search_fromdate) $sql .=" AND asktime <= '$search_todates'";
if (isset($catid) && intval($catid))
{
	$catid = $CATEGORY[$catid]['arrchildid'];
	$sql .= " AND catid IN ($catid)";
}
if(isset($job) && $job) $sql .= " AND status=$job";
if(isset($commend) && $commend) $sql .= " AND elite=$commend";
if(isset($pass) && intval($pass)) $sql .= " AND endtime<'$PHP_TIME'";
$pagesize = 20;
$page = intval($page);
$page = $page < 1 ? 1 : $page;
$offset = ($page - 1) * $pagesize;
$cat_pos = admin_catpos($catid);
$category_jump = category_select('catid', $LANG['choose_category'], $catid, "onchange=\"if(this.value!=''){location='?mod=$mod&file=$file&action=manage&catid='+this.value;}\"");
switch($action)
{
	case 'manage':
		@extract($db->get_one("SELECT count(*) AS num FROM ".TABLE_WENBA_QUESTION." WHERE 1 $sql"));
		$total = $num;
		if($total)
		{	
			$ques_all_r = $db->query("SELECT catid, qid,title,asktime,score,answercount,hits,status,elite FROM ".TABLE_WENBA_QUESTION." WHERE 1 $sql ORDER BY qid DESC LIMIT $offset,$pagesize");
			while($r=$db->fetch_array($ques_all_r))
			{
				$r['asktime'] = date('Y-m-d H:i',$r['asktime']);
				$all_queslist[]=$r;
			}
			$phpcmspage = phppages($total, $page, $pagesize);
			$referer = "$curUri&page=$page";
		}
		include admintpl('question');
	break;

	case 'delete':
	if ($dosubmit)
	{
		$item = is_array($qid) ? implode(',', $qid) : intval($qid);
		$db->query("DELETE FROM ".TABLE_WENBA_QUESTION." WHERE qid IN ($item)");
		$catids = cache_categorys($mod);
		showmessage($LANG['operation_success'], $PHP_REFERER);
	}
	break;

	case 'commend':
	if ($dosubmit)
	{	
		$qid = intval($qid);
		$db->query("UPDATE ".TABLE_WENBA_QUESTION." SET elite=1 WHERE qid=$qid");
		showmessage($LANG['question_commended_success'], $PHP_REFERER);
	}
	break;

	case 'cancel':
	if ($dosubmit)
	{	
		$qid = intval($qid);
		$db->query("UPDATE ".TABLE_WENBA_QUESTION." SET elite=0 WHERE qid=$qid");
		showmessage($LANG['question_repeal_commend'], $PHP_REFERER);
	}
	break;
}
?>
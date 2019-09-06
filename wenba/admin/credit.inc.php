<?php
defined('IN_PHPCMS') or exit('Access Denied');
include(PHPCMS_ROOT."/$mod/admin/menu.inc.php");
require PHPCMS_ROOT."/$mod/include/global.func.php";
$ACTOR = cache_read('actors.php');

$submenu = array
(
	array($LANG['all_integral'], '?mod='.$mod.'&file='.$file.'&action=manage'),
	array($LANG['premonth_integral'], '?mod='.$mod.'&file='.$file.'&action=month'),
	array($LANG['preweek_integral'], '?mod='.$mod.'&file='.$file.'&action=week')
);

$menu=adminmenu($LANG['manage_integral'],$submenu);

$action = $action ? $action : 'manage';

switch($action)
{
	case 'week':
		$title = $LANG['preweek_integral'];
		$que_r=$db->get_one("SELECT COUNT(a.username) AS num FROM ".TABLE_WENBA_CREDIT." AS a, ".TABLE_MEMBER." AS b WHERE a.username=b.username");
		@extract($que_r);
		$sql="SELECT a.username,a.preweek as num,b.credit,b.lastlogintime,b.logintimes,b.totalonline,b.answercounts,b.acceptcount,b.actortype FROM ".TABLE_WENBA_CREDIT." AS a, ".TABLE_MEMBER." AS b WHERE a.username=b.username ORDER BY a.preweek DESC";
    break;
    
	case 'month':
		$title = $LANG['premonth_integral'];
		$que_r=$db->get_one("SELECT COUNT(a.username) AS num FROM ".TABLE_WENBA_CREDIT." AS a, ".TABLE_MEMBER." AS b WHERE a.username=b.username");
		@extract($que_r);
		$sql="SELECT a.username,a.premonth as num,b.credit,b.lastlogintime,b.logintimes,b.totalonline,b.answercounts,b.acceptcount,b.actortype FROM ".TABLE_WENBA_CREDIT." AS a, ".TABLE_MEMBER." AS b WHERE a.username=b.username ORDER BY a.premonth DESC";
    break;
    
    case 'manage':
		$title = $LANG['all_integral'];
		$que_r=$db->get_one("SELECT COUNT(*) AS num FROM ".TABLE_MEMBER." WHERE credit>0 AND groupid=6");
		@extract($que_r);
		$sql="SELECT username,credit,actortype,lastlogintime,logintimes,totalonline,answercounts,acceptcount FROM ".TABLE_MEMBER." WHERE credit>0 AND groupid=6 ORDER BY credit DESC";
	break;
}
$total = $num;
if($total)
{
	$pagesize = 20;
	$page = intval($page);
	$page = $page < 1 ? 1 : $page;
	$offset = ($page - 1) * $pagesize;
	$res=$db->query($sql." LIMIT $offset,$pagesize");
	$i=1;
	while($r=$db->fetch_array($res))
	{	
		$r['orderid']=$i;
		$r['lastlogintime']=date("y-n-j H:i",$r['lastlogintime']);
		$r['totalonline_hour']=intval($r['totalonline']/3600);
		$r['totalonline_minute']=round(($r['totalonline']%3600)/60);
		if(!$r['actortype']) $r['actortype'] = 0;
		$credit = $r['credit'];
		$acts = $ACTOR[$r['actortype']];
		foreach($acts As $k=>$v)
		{
			if($credit >= $v['min'] && $credit <= $v['max'])
			{
				$r['grade'] = $v['grade'].' '.$v['actor'];
			}
			elseif($credit>$v['max'])
			{
				$r['grade'] = $v['grade'].' '.$v['actor'];
			}
		}
		$members_list[$i]=$r;
		$i++;
	}
	$phpcmspage = phppages($total, $page, $pagesize);
	$referer = "$curUri&page=$page";
}
include admintpl('credit');
?>
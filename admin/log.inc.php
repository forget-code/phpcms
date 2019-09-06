<?php
defined('IN_PHPCMS') or exit('Access Denied');

include PHPCMS_ROOT.'/include/date.class.php';
$date = new phpcms_date();

$submenu = array
(
	array($LANG['manage_index'], "?mod=".$mod."&file=log&action=manage"),
	array($LANG['delete_log_one_week_before'], "?mod=".$mod."&file=log&action=delete"),
	array($LANG['delete_log_one_month_before'], "?mod=".$mod."&file=log&action=delete")
);

$menu = adminmenu($LANG['log_manage'], $submenu);

if(!isset($s_mod)) $s_mod = '';
if(!isset($s_channelid)) $s_channelid = 0;
if(!isset($s_type)) $s_type = '';
if(!isset($keywords)) $keywords = '';
if(!isset($s_fromdate)) $s_fromdate = '';
if(!isset($s_todate)) $s_todate = '';


$action = $action ? $action : 'manage';

switch($action)
{
	case 'manage':
		if(!isset($page)) $page = 1;
	    $page = intval($page);
		$offset = ($page-1)*$PHPCMS['pagesize'];

		$addquery = $s_mod ? " and mod='$s_mod'" : "";
		$addquery .= $s_channelid ? " and channelid='$s_channelid'" : "";
		if($s_fromdate)
	    {
			$date->set_date($s_fromdate);
			$fromtime = $date->get_time();
			$addquery .= " and addtime >= $fromtime";
        }
		if($s_todate)
	    {
			$date->set_date($s_todate);
			$totime = $date->get_time() + 86400;
			$addquery .= " and addtime <= $totime";
        }
        $addquery .= $keywords ? " and $s_type like '%$keywords%'" : "";
        $addquery = $addquery ? " WHERE 1 ".$addquery : "";
		$r = $db->get_one("SELECT COUNT(*) AS num FROM ".TABLE_LOG." $addquery");
	    $pages = phppages($r['num'], $page, $PHPCMS['pagesize']);
		$logs = array();
		$result= $db->query("select * from ".TABLE_LOG." $addquery order by logid desc LIMIT $offset,$PHPCMS[pagesize]");
		while($r = $db->fetch_array($result))
		{
             $r['addtime'] = date("Y-m-d H:i:s", $r['addtime']);
			 $r['mod'] = $MODULE[$r['mod']]['name'];
			 $r['channelid'] = $r['channelid'] > 0 ? $CHANNEL[$r['channelid']]['channelname'] : '';
			 $r['querystring'] = wordwrap(urldecode($r['querystring']),36,"<br/>\n",1);
			 $logs[] = $r;
		}

		if(!$s_fromdate && !$s_todate)
	    {
			$date->set_date(date('Y-m-d'));
			$todate = $date->get_date();
			$date->dayadd(-7);
			$fromdate = $date->get_date();
		}
		else
	    {
			$todate = $s_todate;
			$fromdate = $s_fromdate;
		}
		include admintpl('log');
		break;

    case 'delete':
          $date->monthadd(-1);
	      $time = $date->get_time();
		  $db->query("DELETE FROM ".TABLE_LOG." WHERE addtime<$time");
		  showmessage($LANG['operation_success'],$PHP_REFERER);
          break;
}
?>
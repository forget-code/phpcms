<?php
defined('IN_PHPCMS') or exit('Access Denied');
$submenu = array(
    array($LANG['error_list'], "?mod=$mod&file=error_report"),
    );
$menu = adminmenu($LANG['error_name'], $submenu);
$condition = '';
if ($keyid)
{
    $condition = " AND keyid='$keyid'";
}
else
{
	if($action=='clear')
	{
	$condition='';
	mkcookie('report_keyid','',0);
	}
	else
	{
		$report_keyid = $report_keyid?$report_keyid:getcookie('report_keyid');
		if ($report_keyid)
	{
		$condition = " AND keyid='$report_keyid'";
		mkcookie('report_keyid', $report_keyid, 0);
	}
	}
}
if (isset($serch_submit))
{
    if ($start_date && $end_date)
    {
        $start_date = strtotime($start_date);
        $end_date = strtotime($end_date);
        $condition = " AND addtime >='$start_date' AND addtime<='$end_date' ";
    }
    else
    {
        showmessage($LANG['illegal_operation']);
    }
}
if ($action == 'delete')
{
    if (isset($error_all) && is_array($error_all))
    {
        $error_all_id = implode(',', $error_all);
        $sql = "DELETE FROM " . TABLE_ERROR_REPORT . " WHERE error_id IN ($error_all_id) ";
        $db->query($sql);
        showmessage($LANG['operation_success'], $PHP_REFERER);
    } elseif (isset($error_all_id))
    {
        $error_all_id = intval($error_all_id);
    }
}
if ($action == 'delete_all')
{
    $db->query("DELETE FROM " . TABLE_ERROR_REPORT);
    showmessage($LANG['operation_success'], $PHP_REFERER);
}
$res = $db->get_one("SELECT COUNT(*) AS num FROM " . TABLE_ERROR_REPORT . " WHERE 1 $condition ");

$page = $page ? intval($page) : 1;
$pagesize = 15;
$pageend = ($page-1) * $pagesize;
$pages = phppages($res['num'], $page, $pagesize);
$rs = $db->query("SELECT * FROM " . TABLE_ERROR_REPORT . " WHERE 1 $condition ORDER BY error_id DESC LIMIT $pageend,$pagesize");
while ($rows = $db->fetch_array($rs))
{
    $rows['addtime'] = date("Y-m-d H:i", $rows['addtime']);
    $error_list[] = $rows;
}
include admintpl('error_report');

?>
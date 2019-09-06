<?php 
require_once './include/common.inc.php';

$action = isset($action) ? $action : 'all';
$pagesize = 30;
$page = isset($page) ? intval($page) : 1;
$sql = '';
if($action == 'outtime')
{
	$sql .= ' AND endtime<'.$PHP_TIME.' AND status=1';
}
if($action=='vote')
{
	$sql .= ' AND status=3';
}
@extract($db->get_one("SELECT COUNT(*) AS number FROM ".TABLE_WENBA_QUESTION." WHERE username='$_username' $sql"));
$pages = phppages($number, $page, $pagesize);
$offset = ($page-1)*$pagesize;
$all_query = $db->query("SELECT qid,title,answercount,status,asktime,endtime FROM ".TABLE_WENBA_QUESTION." WHERE username='$_username' $sql ORDER BY asktime DESC LIMIT $offset, $pagesize");
while($r = $db->fetch_array($all_query))
{
	$r['title'] = ($r['endtime']<$PHP_TIME && $r['status']==1) ? '<font color="red">'.$r['title'].'</font>' : $r['title'];
	$r['asktime'] = date('Y-m-d H:i',$r['asktime']);
	$all_questionlist[] = $r;
}
include template('wenba','member_index');
?>
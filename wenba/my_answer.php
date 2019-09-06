<?php 
require_once './include/common.inc.php';

$sql = '';
if($status)
{
	$sql .= ' AND accept_status = '.$status ;
}
$page = isset($page) ? intval($page) : 1;
$pagesize = 30;
$munber = $db->get_one("SELECT COUNT(*) AS num FROM ".TABLE_WENBA_ANSWER." AS A, ".TABLE_WENBA_QUESTION." AS Q WHERE A.qid=Q.qid AND A.username='$_username'".$sql);
$pages = phppages($munber['num'], $page, $pagesize);
$answers = array();
$result = $db->query("SELECT Q.qid,Q.title,Q.answercount,Q.status,Q.asktime,Q.endtime,A.accept_status FROM ".TABLE_WENBA_ANSWER." AS A, ".TABLE_WENBA_QUESTION." AS Q WHERE A.qid=Q.qid AND A.username='$_username'".$sql." ORDER BY A.answertime DESC");
while($r = $db->fetch_array($result))
{
	$r['title'] = ($r['endtime']<$PHP_TIME && $r['status']==1) ? '<font color="red">'.$r['title'].'</font>' : $r['title'];
	$r['asktime'] = date('Y-m-d H:i',$r['asktime']);
	$answers[] = $r;
}

include template('wenba', 'my_answer');
?> 
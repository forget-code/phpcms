<?php 
require_once './include/common.inc.php';

$word = isset($word) ? trim(strip_tags($word)) : '';
$pagesize = 20;
$page = (isset($page) && intval($page)>0) ? intval($page) : 1;
@extract($db->get_one("SELECT count(*) AS num FROM ".TABLE_WENBA_QUESTION." WHERE title LIKE '%$word%'"));
$pages = phppages($num, $page, $pagesize);
$offset = ($page-1)*$pagesize;
$query = $db->query("SELECT qid,title,status,answercount,asktime FROM ".TABLE_WENBA_QUESTION." WHERE title LIKE '%$word%' ORDER BY qid DESC LIMIT $offset, $pagesize");
while ($search_temp = $db->fetch_array($query))
{	
	$search_temp['asktime'] = date('Y-m-d H:i', $search_temp['asktime']);
	$search_list[] = $search_temp;
}
include template('wenba','search');
?>
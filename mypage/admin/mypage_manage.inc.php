<?php
defined('IN_PHPCMS') or exit('Access Denied');
$page = isset($page) && $page>1 ? intval($page) : 1;
$offset = $page ? ($page-1)*$pagesize : 0;

$r = $db->get_one("SELECT COUNT(*) AS num FROM ".TABLE_MYPAGE."");
$number = $r['num'];

$pages=phppages($number,$page,$pagesize);

$result=$db->query("SELECT * FROM ".TABLE_MYPAGE." ORDER BY mypageid LIMIT $offset,$pagesize");
$mypages = array();
while($r=$db->fetch_array($result))
{
	$r['url'] = $PHP_SITEURL.$mod."/index.php?name=".$r['name'];
	$mypages[]=$r;
}
include admintpl('mypage_manage');
?>
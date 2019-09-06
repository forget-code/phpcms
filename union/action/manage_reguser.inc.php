<?php
defined('IN_PHPCMS') or exit('Access Denied');

$pagesize = $PHPCMS['pagesize'];
if(!isset($page)) $page = 1;
$offset = ($page-1)*$pagesize;

$r = $db->get_one("SELECT count(*) AS number FROM ".TABLE_MEMBER." WHERE introducer=$_userid");
$pages = phppages($r['number'], $page, $pagesize);

$users = array();
$result = $db->query("SELECT * FROM ".TABLE_MEMBER." m,".TABLE_MEMBER_INFO." i WHERE m.userid=i.userid AND m.introducer=$_userid ORDER BY m.userid DESC LIMIT $offset,$pagesize");
while($r = $db->fetch_array($result))
{
	$r['regtime'] = $r['regtime'] ? date('Y-m-d H:i', $r['regtime']) : '';
	$r['lastlogintime'] = $r['lastlogintime'] ? date('Y-m-d H:i', $r['lastlogintime']) : '';
	$users[] = $r;
}

$head['title'] = '注册用户列表';

include template($mod, 'reguser');
?>
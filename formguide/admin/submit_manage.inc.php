<?php
defined('IN_PHPCMS') or exit('Access Denied');

if(!isset($formid)) showmessage($LANG['illegal_parameters'],'goback');
$formid = intval($formid);
$page = isset($page) ? intval($page) : 1;
$offset = ($page-1)*$PHPCMS['pagesize'];
$result = $db->query("SELECT count(did) as num FROM ".TABLE_FORMGUIDE_DATA." WHERE formid=$formid");
$r = $db->fetch_array($result);
$number = $r['num'];
$pages = phppages($number,$page,$PHPCMS['pagesize']);

$query ="SELECT did,content,ip,username,addtime,formid".
		" FROM ".TABLE_FORMGUIDE_DATA.
		" WHERE formid=$formid order by did desc limit $offset,".$PHPCMS['pagesize'];

$result = $db->query($query);
$submits = array();
while($r = $db->fetch_array($result))
{
	$r['addtime'] = date('Y-m-d H:i',$r['addtime']);
	$r['username'] = $r['username']?$r['username']:$LANG['guest'];
	$r['content'] = unserialize($r['content']);
	$r['itemnames'] = $r['content']['itemname'];
	$r['formtype'] = $r['content']['formtype'];
	unset($r['content']['itemname'],$r['content']['formtype']);
	$submits[] = $r;
}

include admintpl('submit_manage');
?>
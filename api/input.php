<?php
/*
	外部数据提交接口

*/
require '../include/common.inc.php';
$categoty_keys = array_keys($CATEGORY);
if(!is_numeric($catid) || !in_array($catid,$categoty_keys))
{
	header('HTTP/1.1 102 catid error');
	exit;
}
require_once 'admin/content.class.php';
require_once 'attachment.class.php';
$attachment = new attachment('phpcms', $catid);

$member = load('member.class.php', 'member', 'include');
$r = $member->login($username, $password);
if(!$r)
{
	header('HTTP/1.1 100 login failed');
	exit;
}

@extract($r, EXTR_PREFIX_ALL, '');
$G = cache_read('member_group_'.$_groupid.'.php');
if(!$G['allowpost'] || !$priv_group->check('catid', $catid, 'input', $_groupid))
{
	header('HTTP/1.1 103 Access Denied'.$G['allowpost']);
	exit;
}
$c = new content();
$modelid = $CATEGORY[$catid]['modelid'];
if(!$template) $template = $CATEGORY[$catid]['template_show'];
$array_fields = cache_read($modelid.'_fields.inc.php', CACHE_MODEL_PATH);
$thumb = $attachment->remotefileurls('thumb',$thumb);

foreach ($array_fields AS $key=>$value)
{
	if($value['iscore'] || !$value['isadd']) continue;
	$data[$key] = $$key;
}
$contentid = $c->add($data);
if(!$contentid) if(!$r) header('HTTP/1.1 101 input failed');
?>
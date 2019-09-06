<?php
defined('IN_PHPCMS') or exit('Access Denied');
$result = $db->query("select * from ".$CONFIG['tablepre']."channel where module='down' ");
while($r = $db->fetch_array($result))
{
	if($r['islink']) continue;
	$table = $CONFIG['tablepre']."down_".$r['channelid'];
	$db->query("DROP TABLE IF EXISTS $table ");
	dir_delete(PHPCMS_ROOT.'/'.$r['channeldir'].'/');
}
$db->query("DELETE FROM ".$CONFIG['tablepre']."channel WHERE module='down'");
$db->query("DELETE FROM ".$CONFIG['tablepre']."module WHERE module='down'");
$db->query("DROP TABLE IF EXISTS ".$CONFIG['tablepre']."down_server ");

require_once PHPCMS_ROOT.'/admin/include/tag.class.php';
$tag = new tag('down');
foreach($tag->tags_config as $tagname=>$config)
{
	$tag->update($tagname , '');
}

dir_delete(PHPCMS_ROOT.'/module/down/');
dir_delete(PHPCMS_ROOT.'/'.$CONFIG['defaulttemplate'].'/down/');

template_cache();
?>
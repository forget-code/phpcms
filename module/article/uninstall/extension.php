<?php
defined('IN_PHPCMS') or exit('Access Denied');

$result = $db->query("select * from ".$CONFIG['tablepre']."channel where module='article' ");
while($r = $db->fetch_array($result))
{
	if($r['islink']) continue;
	$table = $CONFIG['tablepre']."article_".$r['channelid'];
	$table_data = $CONFIG['tablepre']."article_data_".$r['channelid'];
	$db->query("DROP TABLE IF EXISTS $table ");
	$db->query("DROP TABLE IF EXISTS $table_data ");
	dir_delete(PHPCMS_ROOT.'/'.$r['channeldir'].'/');
}
$db->query("DELETE FROM ".$CONFIG['tablepre']."channel WHERE module='article'");
$db->query("DELETE FROM ".$CONFIG['tablepre']."module WHERE module='article'");

require_once PHPCMS_ROOT.'/admin/include/tag.class.php';
$tag = new tag('article');
foreach($tag->tags_config as $tagname=>$config)
{
	$tag->update($tagname , '');
}

dir_delete(PHPCMS_ROOT.'/module/article/');
dir_delete(PHPCMS_ROOT.'/'.$CONFIG['defaulttemplate'].'/article/');

template_cache();
?>
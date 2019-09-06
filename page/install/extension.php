<?php
defined('IN_PHPCMS') or exit('Access Denied');
$pages = array();
$page = array();
$result = $db->query("SELECT title,linkurl,filepath FROM ".$CONFIG['tablepre']."page WHERE keyid='phpcms' AND passed=1 ORDER by listorder DESC ");
while($r = $db->fetch_array($result))
{
	$page['title'] = $r['title'];
	$page['url'] = $r['linkurl'] ? $r['linkurl'] : PHPCMS_PATH.$r['filepath'];
	$pages[]=$page;
}
if(!empty($pages)) cache_write('definedpage_phpcms.php', $pages);
?>
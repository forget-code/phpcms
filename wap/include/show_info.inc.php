<?php
defined('IN_PHPCMS') or exit('Access Denied');

$contentid = isset($contentid) && !empty($contentid) ? intval($contentid) : exit($lang['contentid_canot_be_empty']);
$cats = array();
$cats['news'] = submodelcats();
$cats['info'] = submodelcats(4);
$html = menus();
require_once 'admin/content.class.php';
$c = new content;
$r = $c->get($contentid);
$c->hits($contentid);
if($r && $r['status'] == 99 && !$r['readpoint'] && $priv_group->check('catid', $r['catid'], 'view', $_groupid)) 
{
	
	$html .= $lang['who'].$r['username']."<br/>";
	$html .= $lang['tel'].$r['telephone']."<br/>";
	$html .= $lang['address'].$r['address']."<br/>";
	$html .= $lang['time'].date('Y-m-d', $r['inputtime'])."<br/>";
	$html .= $lang['endtime'].$r['endtime']."<br/>";
	$html .= wml_strip($r['content'])."<br/>";
	
}
else 
{
	$html .= $lang['content_canot_find'];
}
$html .= '<a href="index.php">'.$lang['return_index'].'</a><br/>';
?>
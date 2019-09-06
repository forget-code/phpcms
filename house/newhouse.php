<?php
require './include/common.inc.php';

$tab = 'listdisplay';

$displayid = isset($displayid) ? intval($displayid) : 0;
$displayid or showmessage($LANG['illegal_operation'], $PHP_SITEURL);

$display = $db->get_one("SELECT * FROM ".TABLE_HOUSE_DISPLAY." WHERE displayid=$displayid AND status=1");
$display or showmessage('请求的信息不存在', 'goback');

$display['thumb'] = imgurl($display['thumb']);
$display['img1'] = imgurl($display['img1']);
$display['img2'] = imgurl($display['img2']);
$display['img3'] = imgurl($display['img3']);
$display['housetype'] = $display['housetype'] ? $HOUSETYPE[$display['housetype']] : '';
extract($display);
unset($display);

$title = $name;

$query = "SELECT *   FROM ".TABLE_HOUSE_HOLD." WHERE displayid = $displayid";
$result = $db->query($query);
$holds = array();
while($r = $db->fetch_array($result))
{
	$holds[] = $r;
}

$holdcount = count($holds);
$itemurl = linkurl($linkurl);
$adddate = date('Y-m-d H:i:s', $addtime);

if($skinid) $skindir = PHPCMS_PATH.'templates/'.$CONFIG['defaulttemplate'].'/skins/'.$skinid;
if(!$templateid) $templateid = 'newhouse';

$head['title'] = $name;
$head['keywords'] = $name.",".$MOD['seo_keywords'];
$head['description'] = $introduce.'-'.$MOD['seo_description'];

include template($mod, $templateid);
?>
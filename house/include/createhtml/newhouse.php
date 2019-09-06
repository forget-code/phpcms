<?php 
defined('IN_PHPCMS') or exit('Access Denied');
$tab = 'listdisplay';
$displayid = isset($displayid) ? intval($displayid) : 0;
if(!$displayid) return FALSE;
$display = $db->get_one("SELECT * FROM ".TABLE_HOUSE_DISPLAY." WHERE displayid=$displayid ");
if(!$display || $display['status'] < 1 || !$display['ishtml']) return FALSE;

$display['thumb'] = imgurl($display['thumb']);
$display['img1'] = imgurl($display['img1']);
$display['img2'] = imgurl($display['img2']);
$display['img3'] = imgurl($display['img3']);
$display['housetype'] = $display['housetype'] ? $HOUSETYPE[$display['housetype']] : '';
extract($display);
unset($display);

$title = $name;
$holds = array();
$result = $db->query("SELECT * FROM ".TABLE_HOUSE_HOLD." WHERE displayid=$displayid");
while($r = $db->fetch_array($result))
{
	$r['thumb'] = imgurl($r['thumb']);
	$r['image'] = imgurl($r['image']);
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

ob_start();
include template($mod, $templateid);
$data = ob_get_contents();
ob_clean();
$filepath = display_item_url('path', $ishtml,$urlruleid, $htmldir, $prefix, $displayid, $addtime);		
$filepath = PHPCMS_ROOT.'/'.$filepath;
$dir = dirname($filepath);
dir_create($dir);
file_put_contents($filepath, $data);
@chmod($filepath, 0777);
return TRUE;
?>
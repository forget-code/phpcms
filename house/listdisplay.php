<?php
require './include/common.inc.php';
$areaid = isset($areaid) ? intval($areaid) : 0;
if($MOD['createlistdisplay'] && !$areaid){header('Location:'.$MOD['display_list_url']);exit;}
$tab = 'listdisplay';
$head['title'] = '新楼盘-'.$MOD['seo_keywords'];
$head['keywords'] = '新楼盘列表-'.$MOD['seo_keywords'];
$head['description'] =  '新楼盘列表-'.$MOD['seo_description'];
$skindir = $skinid ? PHPCMS_PATH.'templates/'.$CONFIG['defaulttemplate'].'/skins/'.$skinid : $skindir;
$templateid = 'listdisplay';
include template($mod,$templateid);
?>
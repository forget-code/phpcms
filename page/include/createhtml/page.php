<?php 
defined('IN_PHPCMS') or exit('Access Denied');
$pageid = isset($pageid) ? intval($pageid) : 0;
if(!$pageid) return FALSE;
$r = $db->get_one("select * from ".TABLE_PAGE." where pageid=$pageid and passed=1 and linkurl='' ");
if(!$r['pageid']) return FALSE;
@extract($r);
$head['title'] = ($seo_title ? $seo_title : $title).'-'.$PHPCMS['seo_title'];
$head['keywords'] = $seo_keywords ? $seo_keywords : $PHPCMS['seo_keywords'];
$head['description'] = $seo_description ? $seo_description : $PHPCMS['seo_description'];
$templateid = $templateid ? $templateid : 'page';
$skindir = $skinid ? PHPCMS_PATH."templates/".$defaulttemplate."/skins/".$skinid : $skindir;
ob_start();
include template('page', $templateid);
$data = ob_get_contents();
ob_clean();
$filename = PHPCMS_ROOT.'/'.$filepath;
$filepath = dirname($filename);
is_dir($filepath) or dir_create($filepath);
file_put_contents($filename,$data);
return TRUE;
?>
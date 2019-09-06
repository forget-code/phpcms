<?php 
defined('IN_PHPCMS') or exit('Access Denied');
if(!$MOD['ishtml']) return FALSE;
$tab = 'home';
$searchtype = isset($searchtype)?$searchtype:1;
$areaid = isset($areaid)?$areaid:0;
$type_1 = isset($type_1)?$type_1:0;
$type_2 = isset($type_2)?$type_2:0;
$type_3 = isset($type_3)?$type_3:0;
$propertytype = isset($propertytype )?$propertytype:0;
$decorate = isset($decorate)?$decorate:0;
$towards = isset($towards)?$towards:0;
$fromprice = isset($fromprice)?$fromprice:0;
$toprice = isset($toprice)?$toprice:0;
if(isset($keywords))
{
	$keywords = strip_tags(trim($keywords));
	if(strlen($keywords)>50) showmessage($LANG['keyword_num_not_greater_than_50'], 'goback');
}
else
{
	$keywords = '';
}
$head['title'] = $MOD['seo_title'];
$head['keywords'] = $MOD['seo_keywords'];
$head['description'] = $MOD['seo_description'];

$templateid = $MOD['templateid'] ? $MOD['templateid'] : 'index';
$filename = PHPCMS_ROOT.'/'.$mod.'/'.$PHPCMS['index'].'.'.$PHPCMS['fileext'];
ob_start();
include template($mod, $templateid);
$data = ob_get_contents();
ob_clean();
file_put_contents($filename, $data);
return TRUE;
?>
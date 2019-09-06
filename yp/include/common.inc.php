<?php 
define('MOD_ROOT', substr(dirname(__FILE__), 0, -8));

$mod = 'yp';
require substr(MOD_ROOT, 0, -strlen($mod)).'include/common.inc.php';

$head['title'] = $MOD['name'];
$head['keywords'] = $MOD['seo_keywords'];
$head['description'] = $MOD['seo_description'];
require PHPCMS_ROOT.'/include/module.func.php';
require MOD_ROOT.'/include/urlrule.inc.php';
require MOD_ROOT.'/include/tag.func.php';
$CATEGORY = cache_read('categorys_'.$mod.'.php');
$childcats = subcat($mod);
if(is_array($childcats))
{
	foreach($childcats as $i=>$cat)
	{
		$subcats[$i] = subcat($mod,$cat['catid']);
	}
}
$TYPE = cache_read('type_'.$mod.'.php');
$MSIE = FALSE;
if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== FALSE) $MSIE = TRUE;
?>
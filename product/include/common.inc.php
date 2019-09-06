<?php 
define('MOD_ROOT', substr(dirname(__FILE__), 0, -8));
$mod = 'product';
require substr(MOD_ROOT, 0, -strlen($mod)).'include/common.inc.php';

require PHPCMS_ROOT.'/include/module.func.php';
require MOD_ROOT.'/include/urlrule.inc.php';
require MOD_ROOT.'/include/tag.func.php';

$CATEGORY = cache_read('categorys_'.$mod.'.php');
$BRANDS = cache_read('product_brands.php');
$discount = 1;
if($_userid)
{
	$GROUP = cache_read('member_group_'.$_groupid.'.php');
	$discount = sprintf('%.2f',$GROUP['discount']/100);
	unset($GROUP);
}

$childcats = subcat($mod);
if(is_array($childcats))
{
	foreach($childcats as $i=>$cat)
	{
		$subcats[$i] = subcat($mod,$cat['catid']);
	}
}
?>
<?php 
require '../include/common.inc.php';
$TAGS = include TPL_ROOT.TPL_NAME.'/tag.inc.php';
if(!isset($TAGS[$tagname]) || strpos($TAGS[$tagname], '$')) exit;
	
ob_start();
eval($TAGS[$tagname].';');
$data = ob_get_contents();
ob_clean();
$siteurl = $PHPCMS['siteurl'];
$data = preg_replace(array("/src=(\"|')([a-z0-9_-]+)\//si","/href=(\"|')([a-z0-9_-]+)\./"),array("src=\\1".$siteurl."\\2/","href=\\1".$siteurl."\\2."),$data);
echo format_js($data);
cache_page(3600);
?>
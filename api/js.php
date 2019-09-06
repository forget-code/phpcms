<?php 
require '../include/common.inc.php';
$TAGS = include TPL_ROOT.TPL_NAME.'/tag.inc.php';

if(!isset($TAGS[$tagname])) exit;

ob_start();
eval($TAGS[$tagname].';');
$data = ob_get_contents();
ob_clean();

$siteurl = $PHPCMS['siteurl'];
$data = preg_replace(array("/href=(\"|')([^http:\/\/]+)/","/src=(\"|')([^http:\/\/]+)/"),array("href=\\1".$siteurl."\\2","src=\\1".$siteurl."\\2"),$data);
echo format_js($data);
cache_page(3600);
?>
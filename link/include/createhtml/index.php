<?php 
defined('IN_PHPCMS') or exit('Access Denied');
$templateid = 'index';
$filename = PHPCMS_ROOT.'/'.$mod.'/'.$PHPCMS['index'].'.'.$PHPCMS['fileext'];
ob_start();
include template($mod, $templateid);
$data = ob_get_contents();
ob_clean();
file_put_contents($filename, $data);
return TRUE;
?>

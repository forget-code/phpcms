<?php 
defined('IN_PHPCMS') or exit('Access Denied');

dir_create(PHPCMS_ROOT.'/data/js/');
$filename = PHPCMS_ROOT.'/data/js/search.js';
ob_start();
include template('phpcms', 'search');
$data = ob_get_contents();
ob_clean();
file_put_contents($filename, strip_js($data));
@chmod($filename, 0777);
return TRUE;
?>
<?php 
defined('IN_PHPCMS') or exit('Access Denied');

$htmlfilename = PHPCMS_ROOT.'/yp/index_update.html';
ob_start();
include template($mod, 'index');
$data = ob_get_contents();
ob_clean();
file_put_contents($htmlfilename, $data);
@chmod($htmlfilename, 0777);
return TRUE;
?> 
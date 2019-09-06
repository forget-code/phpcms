<?php 
ob_start();
include template($mod, 'house_search_inc');
$data = ob_get_contents();
ob_clean();
$filename = PHPCMS_ROOT.'/data/house_search_inc.html';
file_put_contents($filename, $data);
@chmod($filename, 0777);

ob_start();
include template($mod, 'building_search_inc');
$data = ob_get_contents();
ob_clean();
$filename = PHPCMS_ROOT.'/data/building_search_inc.html';
file_put_contents($filename, $data);
@chmod($filename, 0777);

ob_start();
include template($mod, 'coop_search_inc');
$data = ob_get_contents();
ob_clean();
$filename = PHPCMS_ROOT.'/data/coop_search_inc.html';
file_put_contents($filename, $data);
@chmod($filename, 0777);

return TRUE;
?>
<?php 
defined('IN_PHPCMS') or exit('Access Denied');

foreach($TYPE as $typeid=>$v)
{
	$filename = $v['type'];
	$typeid = $v['typeid'];
	$typename = $v['name'];
	$templateid = 'category_list';
	$filename = PHPCMS_ROOT.'/'.$mod.'/'.$filename.'.'.$PHPCMS['fileext'];
	ob_start();
	include template($mod, $templateid);
	$data = ob_get_contents();
	ob_clean();
	file_put_contents($filename, $data);
}
?>
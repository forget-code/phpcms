<?php
require './include/common.inc.php';

$lastedittime = @filemtime('product.html');
$lastedittime = $PHP_TIME-$lastedittime;
$autoupdatetime = intval($MOD['autoupdate']);
if(file_exists('product.html') && $lastedittime<$autoupdatetime)
{	
	include 'product.html';
}
else
{
	$head['title'] = $LANG['product'].$head['title'];
	require PHPCMS_ROOT."/include/formselect.func.php";
	require_once PHPCMS_ROOT."/include/tree.class.php";
	$tree = new tree();
	$category_select = category_select('catid', $LANG['select_category'],0);
	ob_start();
	include template($mod, 'product');
	$data .= ob_get_contents();
	ob_clean();
	file_put_contents('product.html', $data);
	@chmod('product.html', 0777);	
	echo $data;
}
?>

<?php 
defined('IN_PHPCMS') or exit('Access Denied');
$mod = 'yp';
$head['title'] = $head['keywords'] = $head['description'] = $product['title'];
$tablename = $CONFIG['tablepre'].'yp_product';
if(!isset($TEMP['fields'][$tablename])) $TEMP['fields'][$tablename] = cache_read($tablename.'_fields.php');
$fields = array();
if(is_array($TEMP['fields'][$tablename]))
{
	foreach($TEMP['fields'][$tablename] as $k=>$v)
	{
		$myfield = $v['name'];
		$fv = $temp[$myfield] ? $temp[$myfield] : $$myfield;
		$fields[] = array('title'=>$v['title'],'value'=>$fv);
	}
}
$headerpath = '/yp/web/userdata/'.$_userdir.'/'.$domainName.'/header.php';
$filepath = PHPCMS_ROOT.'/yp/web/userdata/'.$_userdir.'/'.$domainName.'/'.$filename.'/';
$htmlfilename = $filepath.$productid.'.php';
is_dir($filepath) or dir_create($filepath);
$templateid = $tplType.'-product_show';
$data = "<?php defined('IN_PHPCMS') or exit; include PHPCMS_ROOT.'$headerpath'; ?>";
ob_start();
include template($mod, $templateid);
$data .= ob_get_contents();
ob_clean();
file_put_contents($htmlfilename, $data);
@chmod($htmlfilename, 0777);
return TRUE;
?>
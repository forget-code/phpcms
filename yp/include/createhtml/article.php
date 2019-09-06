<?php 
defined('IN_PHPCMS') or exit('Access Denied');

$head['title'] = $article['title'];
$head['keywords'] = $article['keywords'];
$head['description'] = $article['title'].$article['keywords'];

require PHPCMS_ROOT.'/yp/web/admin/include/common.inc.php';

//$filename -> createhtml($filename, $mod_root = '')
$headerpath = '/yp/web/userdata/'.$_userdir.'/'.$domainName.'/header.php';
$filepath = PHPCMS_ROOT.'/yp/web/userdata/'.$_userdir.'/'.$domainName.'/'.$filename.'/';
$htmlfilename = $filepath.$articleid.'.php';
is_dir($filepath) or dir_create($filepath);

$templateid = $tplType.'-article_show';
$data = "<?php defined('IN_PHPCMS') or exit; include PHPCMS_ROOT.'$headerpath'; ?>";
ob_start();
include template($mod, $templateid);
$data .= ob_get_contents();
ob_clean();
file_put_contents($htmlfilename, $data);
@chmod($htmlfilename, 0777);
if(!file_exists($headerpath))
{
	$data = "<?php defined('IN_PHPCMS') or exit;?>";
	ob_start();
	include template($mod, $tplType.'-header');
	$data .= ob_get_contents();
	ob_clean();
	file_put_contents($headerpath, $data);
	@chmod($headerpath, 0777);
}
return TRUE;
?>
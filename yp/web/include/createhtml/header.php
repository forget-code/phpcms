<?php 
defined('IN_PHPCMS') or exit('Access Denied');
$mod = 'yp';
extract($db->get_one("SELECT banner,background,introduce FROM ".TABLE_MEMBER_COMPANY." WHERE username='$_username'"));
if($background)
{
	$backgrounds = explode('|',$background);
	$backgroundtype = $backgrounds[0];
	$background = $backgrounds[1];
}
$filepath = PHPCMS_ROOT.'/yp/web/userdata/'.$_userdir.'/'.$domainName.'/';
$htmlfilename = $filepath.'header.php';
is_dir($filepath) or dir_create($filepath);
$templateid = $tplType.'-header';
$data = "<?php defined('IN_PHPCMS') or exit;?>";
ob_start();
include template($mod, $templateid);
$data .= ob_get_contents();
ob_clean();
file_put_contents($htmlfilename, $data);
@chmod($htmlfilename, 0777);
return TRUE;
?>
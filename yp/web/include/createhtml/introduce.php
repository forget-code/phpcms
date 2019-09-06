<?php 
defined('IN_PHPCMS') or exit('Access Denied');

$head['title'] = $pagename;
$head['keywords'] = $pagename;
$head['description'] = $pagename;
$username = $_username;
extract($db->get_one("SELECT * FROM ".TABLE_MEMBER_COMPANY." WHERE username='$_username'"));
if($background)
{
	$backgrounds = explode('|',$background);
	$backgroundtype = $backgrounds[0];
	$background = $backgrounds[1];
}
if($map!='')
{
	$maps = explode('|',$map);
	$x = $maps[0];
	$y = $maps[1];
	$z = $maps[2];
}
$postid = $postid ? $postid : '';
$filepath = PHPCMS_ROOT.'/yp/web/userdata/'.$_userdir.'/'.$domainName.'/';
$htmlfilename = $filepath.'introduce.php';
is_dir($filepath) or dir_create($filepath);

$templateid = $tplType.'-introduce';
$data = '<?php defined(\'IN_PHPCMS\') or exit; ?>';
ob_start();
include template($mod, $templateid);
$data .= ob_get_contents();
ob_clean();
$data = new_stripslashes($data);
file_put_contents($htmlfilename, $data);
@chmod($htmlfilename, 0777);
return TRUE;
?>
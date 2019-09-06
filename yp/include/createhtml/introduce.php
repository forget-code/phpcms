<?php 
defined('IN_PHPCMS') or exit('Access Denied');

$head['title'] = $pagename;
$head['keywords'] = $pagename;
$head['description'] = $pagename;
$headerpath = PHPCMS_ROOT.'/yp/web/userdata/'.$_userdir.'/'.$domainName.'/header.php';
$filepath = PHPCMS_ROOT.'/yp/web/userdata/'.$_userdir.'/'.$domainName.'/';
$htmlfilename = $filepath.'introduce.php';
is_dir($filepath) or dir_create($filepath);

$templateid = $tplType.'-introduce';
$data = "<?php defined('IN_PHPCMS') or exit; include '$headerpath'; ?>";
ob_start();
include template($mod, $templateid);
$data .= ob_get_contents();
ob_clean();
$data = new_stripslashes($data);
file_put_contents($htmlfilename, $data);
@chmod($htmlfilename, 0777);
return TRUE;
?>
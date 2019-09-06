<?php
defined('IN_PHPCMS') or exit('Access Denied');
if($_grade>0) showmessage($LANG['you_have_no_permission']);
function getRelativePath($mainpath, $relativepath) {
	global $dir;
	$mainpath_info           = explode('/', $mainpath);
	$relativepath_info       = explode('/', $relativepath);
	$relativepath_info_count = count($relativepath_info);
	for ($i=0; $i<$relativepath_info_count; $i++) {
		if ($relativepath_info[$i] == '.' || $relativepath_info[$i] == '') continue;
		if ($relativepath_info[$i] == '..') {
			$mainpath_info_count = count($mainpath_info);
			unset($mainpath_info[$mainpath_info_count-1]);
			continue;
		}
		$mainpath_info[count($mainpath_info)] = $relativepath_info[$i];
	}
	return implode('/', $mainpath_info);
}

function dir_zip($fname,$zipname)
{
	include PHPCMS_ROOT.'/include/zip.class.php';
	
	$z = new gzip_file($zipname);
	$z->set_options(array('overwrite' => 1, 'level' => 1, 'storepaths' => 1, 'recurse'=>1));
	$z->add_files(array($fname));
	$z->create_archive();
}

?>

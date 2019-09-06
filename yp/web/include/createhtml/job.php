<?php 
defined('IN_PHPCMS') or exit('Access Denied');
$mod = 'yp';
$head['title'] = $head['keywords'] = $head['description'] = $job['title'];
//$filename -> createhtml($filename, $mod_root = '')
$headerpath = '/yp/web/userdata/'.$_userdir.'/'.$domainName.'/header.php';
$filepath = PHPCMS_ROOT.'/yp/web/userdata/'.$_userdir.'/'.$domainName.'/'.$filename.'/';
$htmlfilename = $filepath.$jobid.'.php';
$_username = isset($_username) ? $_username : $username;
$AREA = cache_read('areas_'.$mod.'.php');
is_dir($filepath) or dir_create($filepath);
@extract($db->get_one("SELECT introduce FROM ".TABLE_MEMBER_COMPANY." WHERE companyid=$companyid"));
if($job['period'])
{
	$job['period'] = $job['period']*86400+$PHP_TIME;
	$job['period'] = date("Y-m-d",$job['period']);
}
else
{
	$job['period'] = $LANG['job_time_no_limit'];
}
$job['area'] = $AREA[$job['areaid']]['areaname'];
$templateid = $tplType.'-job_show';
$data = "<?php defined('IN_PHPCMS') or exit; include PHPCMS_ROOT.'$headerpath'; ?>";
ob_start();
include template($mod, $templateid);
$data .= ob_get_contents();
ob_clean();
file_put_contents($htmlfilename, $data);
@chmod($htmlfilename, 0777);
return TRUE;
?>
<?php 
defined('IN_PHPCMS') or exit('Access Denied');
$head['title'] = $head['keywords'] = $head['description'] = $job['title'];
require PHPCMS_ROOT.'/yp/web/admin/include/common.inc.php';
$result = $db->query("SELECT * FROM ".TABLE_YP_JOB." WHERE username='$username' AND status>=3 ORDER BY jobid DESC");
while($r = $db->fetch_array($result))
{
	$jobs[] = $r;
}
if($job['period'])
{
	$job['period'] = $job['period']*86400+$PHP_TIME;
	$job['period'] = date("Y-m-d",$job['period']);
}
else
{
	$job['period'] = $LANG['job_time_no_limit'];
}
$AREA = cache_read('areas_'.$mod.'.php');
$job['area'] = $AREA[$job['areaid']]['areaname'];
$headerpath = '/yp/web/userdata/'.$_userdir.'/'.$domainName.'/header.php';
$filepath = PHPCMS_ROOT.'/yp/web/userdata/'.$_userdir.'/'.$domainName.'/'.$filename.'/';
$htmlfilename = $filepath.$jobid.'.php';
is_dir($filepath) or dir_create($filepath);
$templateid = $tplType.'-job_show';
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
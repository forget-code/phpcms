<?php
defined('IN_PHPCMS') or exit('Access Denied');

if($dosubmit)
{
	$setting['htmldir'] = trim($setting['htmldir']);
	if(!$setting['htmldir']) showmessage('Ads dir is null !');
	module_setting($mod, $setting);
	if(trim($M['htmldir']) != '' && $M['htmldir'] != $setting['htmldir'])
	{
		@unlink(PHPCMS_ROOT.'/data/'.$M['htmldir'].'.php');
		dir_delete(PHPCMS_ROOT.'/data/'.$M['htmldir'].'/');
		$forward = '?mod=ads&file=ads_place&action=createhtml';
	}
	$filename = PHPCMS_ROOT.'/data/'.$setting['htmldir'].'.php';
	if(!file_exists($filename))
	{
		$data = "<?php\nchdir('../ads/');\nrequire './ad.php';\n?>";
		file_put_contents($filename, $data);
		@chmod($filename, 0777);
	}
	showmessage($LANG['save_setting_success'], $forward);
}
else
{
	@extract(new_htmlspecialchars($M));
    include admin_tpl('setting');
}
?>
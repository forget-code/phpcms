<?php
defined('IN_PHPCMS') or exit('Access Denied');

if($dosubmit)
{
	$setting['htmldir'] = trim($setting['htmldir']);
	if(!$setting['htmldir']) showmessage('Ads dir is null !');
	module_setting($mod, $setting);
	if(trim($MOD['htmldir']) != '' && $MOD['htmldir'] != $setting['htmldir'])
	{
		@unlink(PHPCMS_ROOT.'/data/'.$MOD['htmldir'].'.php');
		dir_delete(PHPCMS_ROOT.'/data/'.$MOD['htmldir'].'/');
		$forward = '?mod=ads&file=createhtml';
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
	@extract(new_htmlspecialchars($MOD));

    include admintpl('setting');
}
?>
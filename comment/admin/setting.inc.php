<?php

defined('IN_PHPCMS') or exit('Access Denied');


if($dosubmit)
{
	$setting['enabledkey'] = ',';
	foreach($enabledkeys as $key)
	{
		$setting['enabledkey'] .= $key.",";
	}
    $data = json_encode($setting);
    $check = "var setting = $data;";
    $filename = PHPCMS_ROOT.'data/js/comment_setting.js';
	file_put_contents($filename, $check);
    @chmod($filename, 0777);
	module_setting($mod, $setting);
	showmessage($LANG['save_setting_success'], HTTP_REFERER);
}
else
{
	@extract(new_htmlspecialchars($M));
	$enabledkey = explode(",",$enabledkey);
	$enabledkey = array_filter($enabledkey);

	$link = '';
	$i = 1;
	foreach ($MODULE as $module => $m ) {
		++$i;
		if($module == 'phpcms' || $module == 'comment') continue;

		$link .= "<input type=\"checkbox\" name=\"enabledkeys[]\" value=\"$module\" ";
		if(in_array($module,$enabledkey)) $link .= " checked ";
		$link .= " > ".$m['name'];
		if($i%7==0) $link .='<br/>'; else $link .='&nbsp; ';
	}
    include admin_tpl('setting');
}
?>
<?php

defined('IN_PHPCMS') or exit('Access Denied');


if($dosubmit)
{
	$setting['enabledkey'] = ',';
	foreach($enabledkeys as $key)
	{
		$setting['enabledkey'] .= $key.",";
	}

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
		//if($m['iscopy']) continue;
		if($module == 'phpcms' || $module == 'comment') continue;
		
		$link .= "<input type=\"checkbox\" name=\"enabledkeys[]\" value=\"$module\" ";
		if(in_array($module,$enabledkey)) $link .= " checked ";
		$link .= " > ".$m['name'];
		if($i%7==0) $link .='<br/>'; else $link .='&nbsp; ';
	}
    include admin_tpl('setting');
}
?>
<?php

defined('IN_PHPCMS') or exit('Access Denied');

if($dosubmit)
{
	$setting['enabledkey'] = ',';
	foreach($enabledkeys as $key)
	{
		$setting['enabledkey'].=$key.",";
	}
	module_setting($mod, $setting);
	showmessage($LANG['save_setting_success'], $forward);
}
else
{	
	@extract(new_htmlspecialchars($MOD));	
	$enabledkey = explode(",",$enabledkey);
	$enabledkey = array_filter($enabledkey);
	$link = '';
	$i= 1;
	$j= 1;
	foreach($CHANNEL as $channelid=>$cha)
	{
		++$j;
		if($cha['islink']) continue;
		$link .= "<input type=\"checkbox\" name=\"enabledkeys[]\" value=\"$channelid\"";
		if(in_array($channelid,$enabledkey)) $link .=  " checked ";
		$link .=  "> ".$cha['channelname'];
		if($j%7==0) $link .='<br/>'; else $link .='&nbsp; ';
	}
	$link .='<br/>';
	foreach($MODULE as $module=>$m)
	{
		++$i;
		if($m['iscopy']) continue;
		if($module == 'phpcms' || $module == 'comment') continue;
		
		$link .= "<input type=\"checkbox\" name=\"enabledkeys[]\" value=\"$module\" ";
		if(in_array($module,$enabledkey)) $link .= " checked ";
		$link .= " > ".$m['name'];
		if($i%7==0) $link .='<br/>'; else $link .='&nbsp; ';
	}	
    include admintpl('setting');
}
?>
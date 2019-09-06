<?php 
defined('IN_PHPCMS') or exit('Access Denied');

if($dosubmit)
{
	if(!$position || !$name || !$url) showmessage($LANG['position_name_link_not_null']);
	$arrgroupid = isset($arrgroupid) ? implode(',', $arrgroupid) : '';
	$arrgrade = isset($arrgrade) ? implode(',', $arrgrade) : '';
	$db->query("INSERT INTO ".TABLE_MENU."(position,name,style,url,title,target,arrgroupid,arrgrade,username) VALUES('$position','$name','$style','$url','$title','$target','$arrgroupid','$arrgrade','$username')");
	showmessage($LANG['operation_success'], $forward);
}
else
{
	$target = target_select('target');
	$position = position_select('position');
	$showgroup = showgroup('checkbox','arrgroupid[]');
	$showgrade = '';
	foreach($grades as $grade=>$gradename)
	{
		$showgrade .= ' <input type="checkbox" name="arrgrade[]" value="'.$grade.'"> '.$gradename;
	}

	include admintpl('menu_add');
}
?>
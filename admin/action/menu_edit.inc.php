<?php 
defined('IN_PHPCMS') or exit('Access Denied');

if($dosubmit)
{
	if(!$position || !$name || !$url) showmessage($LANG['position_name_link_not_null']);
	$arrgroupid = isset($arrgroupid) ? implode(',', $arrgroupid) : '';
	$arrgrade = isset($arrgrade) ? implode(',', $arrgrade) : '';
	$db->query("UPDATE ".TABLE_MENU." SET position='$position',name='$name',style='$style',url='$url',title='$title',target='$target',arrgroupid='$arrgroupid',arrgrade='$arrgrade',username='$username' WHERE menuid=$menuid");
	showmessage($LANG['operation_success'], $forward);
}
else
{
	$menuid = intval($menuid);
	$r = $db->get_one("SELECT * FROM ".TABLE_MENU." WHERE menuid=$menuid");

	@extract($r);

	$target = target_select('target', $target);
	$position = position_select('position', $position);
	$showgroup = showgroup('checkbox','arrgroupid[]', $arrgroupid);
	$arrgrade = $arrgrade !== '' ? explode(',', $arrgrade) : array();
	$showgrade = '';
	foreach($grades as $grade=>$gradename)
	{
		$showgrade .= ' <input type="checkbox" name="arrgrade[]" value="'.$grade.'" '.(in_array($grade, $arrgrade) ? 'checked' : '').'> '.$gradename;
	}

	include admintpl('menu_edit');
}
?>
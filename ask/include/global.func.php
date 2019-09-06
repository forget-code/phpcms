<?php 
function get_arrgroupname($arrgroupid)
{
	global $GROUPS;
	if(!$arrgroupid) return '';
    if(!is_array($GROUPS)) $GROUPS = cache_read('member_group.php');

	$arrgroupname = '';
    $arrgroupid = explode(',', $arrgroupid);
	foreach($arrgroupid as $groupid)
	{
		$arrgroupname .= ', '.$GROUPS[$groupid]['groupname'];
	}
	return substr($arrgroupname, 1);
}
?>
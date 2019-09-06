<?php
defined('IN_PHPCMS') or exit('Access Denied');
if(!isset($did)) showmessage($LANG['illegal_parameters'],'goback');
if (!is_numeric($did))
{
	$dids = implode(",",$did);
	$db->query("DELETE FROM ".TABLE_FORMGUIDE_DATA." WHERE did in ($dids)");
}
else 
{
	$db->query("DELETE FROM ".TABLE_FORMGUIDE_DATA." WHERE did=$did limit 1");
}
showmessage($LANG['operation_success'],"?mod=$mod&file=$file&action=manage&formid=$formid&formname=$formname");
?>
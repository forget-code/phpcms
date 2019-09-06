<?php
defined('IN_PHPCMS') or exit('Access Denied');
if(!isset($formid)) showmessage($LANG['illegal_parameters'],'goback');
if (!is_numeric($formid))
{
	$formids = implode(",",$formid);
	$db->query("DELETE FROM ".TABLE_FORMGUIDE." WHERE formid in ($formids)");
}
else 
{
	$db->query("DELETE FROM ".TABLE_FORMGUIDE." WHERE formid=$formid limit 1");
}
showmessage($LANG['operation_success'],"?mod=$mod&file=$file&action=manage");
?>
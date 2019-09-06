<?php 
defined('IN_PHPCMS') or exit('Access Denied');

$submenu = array
(
	array($LANG['finance_operation'], '?mod='.$mod.'&file=pay_add'),
	array($LANG['finance_waste_book'], '?mod='.$mod.'&file=pay_list'),
	array($LANG['operation_type_setting'], '?mod='.$mod.'&file=pay_type'),
);
$menu = adminmenu($LANG['finance_operation'], $submenu);

if($_grade > 0) showmessage($LANG['you_have_no_permission']);

if($dosubmit)
{
	if(!isset($name)) $name = array();
	foreach($name as $id=>$v)
	{
		if(isset($delete[$id]) && $delete[$id])
		{
			$db->query("DELETE FROM ".TABLE_PAY_TYPE." WHERE typeid=$id");
		}
		else
		{
			$db->query("UPDATE ".TABLE_PAY_TYPE." SET name='$name[$id]',listorder='$listorder[$id]',operation='$operation[$id]' WHERE typeid=$id");
		}
	}
	if($newname)
	{
		$db->query("INSERT INTO ".TABLE_PAY_TYPE."(name,listorder,operation) VALUES('$newname','$newlistorder','$newoperation')");
	}
	showmessage($LANG['operation_success'], $forward);
}
else
{
	$maxtypeid = 0;
	$types = array();
	$result = $db->query("SELECT * FROM ".TABLE_PAY_TYPE." ORDER BY listorder");
	while($r = $db->fetch_array($result))
	{
		$types[$r['typeid']] = $r;
		$maxtypeid = max($maxtypeid, $r['typeid']);
	}
	$newlistorder = $maxtypeid + 1;
	include admintpl('pay_type');
}
?>
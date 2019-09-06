<?php
defined('IN_PHPCMS') or exit('Access Denied');

$userid = intval($userid);

if($dosubmit)
{
    $db->query("UPDATE ".TABLE_UNION." SET profitmargin='$profitmargin' WHERE userid=$userid");
    showmessage('操作成功！', $forward);
}
else
{
	$u = $db->get_one("SELECT * FROM ".TABLE_UNION." WHERE userid=$userid");
	extract($u);

    include admintpl('edit');
}
?>
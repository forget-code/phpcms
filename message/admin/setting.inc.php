<?php
defined('IN_PHPCMS') or exit('Access Denied');
if ($dosubmit)
{
	foreach ($group as $key => $value)
	{
		$key += 1;
		$db -> query("UPDATE ".TABLE_MEMBER_GROUP." SET messagelimit='$value' WHERE groupid='$key'");
	}
}
$res = $db -> query("SELECT groupid,groupname,messagelimit from ".TABLE_MEMBER_GROUP);
$usergroups = array();
while ($row = $db -> fetch_array($res))
{
	$usergroups[] = $row;
}
include admintpl('setting');
?>
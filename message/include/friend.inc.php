<?php
defined('IN_PHPCMS') or exit('Access Denied');
$res = $db->query("SELECT userother,types FROM ".TABLE_MESSAGE_FRIEND." WHERE userself='$_username'");
if ($db->num_rows($res) > 0)
{
	$friends = array();
	while ($row = $db->fetch_row($res))
	{
		$friends[] = $row;
	}
}
?>
<?php
defined('IN_PHPCMS') or exit('Access Denied');
if(empty($pageid))
{
	$result = $db->query("SELECT pageid FROM ".TABLE_PAGE." WHERE passed=1 ORDER by listorder DESC ");
	while($r = $db->fetch_array($result))
	{
		$pageid = $r['pageid'];
		createhtml("page");
	}
}
if(is_array($pageid))
{
	foreach($pageid as $pageid)
	{
		createhtml("page");
	}
}
else
{
	createhtml("page");
}

showmessage($LANG['operation_success'], $PHP_REFERER);
?>
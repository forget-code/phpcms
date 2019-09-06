<?php 
defined('IN_PHPCMS') or exit('Access Denied');

$fid = 1;
$pernum = intval($PHPCMS['autoupdatepagenum']);
createhtml('list');
if($CAT['arrparentid'])
{
	$catids = explode(',', $CAT['arrparentid']);
	foreach($catids as $catid)
	{
		if(!$catid) continue;
		createhtml('list');
	}
}
createhtml('show');
createhtml('index');
createhtml('index', PHPCMS_ROOT);
?>
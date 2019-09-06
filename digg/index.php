<?php
require './include/common.inc.php';
if(isset($page)) $page = max(intval($page), 1);
$head['title'] = $LANG['title'].' - '.$PHPCMS['sitename'];
$head['keywords'] = $LANG['keywords'];
$head['description'] = $LANG['keywords'].' - '.$PHPCMS['sitename'];

$where = $catname = $caturl = '';
if($catid && isset($CATEGORY[$catid]))
{
	$where = " AND c.catid IN(".$CATEGORY[$catid]['arrchildid'].") ";
	$catname = $CATEGORY[$catid]['catname'];
	$caturl = $CATEGORY[$catid]['url'];
}
include template('digg','index');
?>
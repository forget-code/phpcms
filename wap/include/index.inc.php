<?php
defined('IN_PHPCMS') or exit('Access Denied');

$cats = array();
$cats['news'] = submodelcats();
$cats['info'] = submodelcats(4);
$html = menus();

foreach($cats['news'] as $key=>$val) 
{
	$html .= "$val[catname]<br/>";
	$r = $db->query("SELECT title, contentid FROM ".DB_PRE."content WHERE catid = '$val[catid]' AND status = 99 ORDER BY contentid DESC LIMIT 5");
	while($s = $db->fetch_array($r)) 
	{
		$html .= "<a href=\"?action=show_news&amp;contentid=$s[contentid]\">$s[title]</a><br/>";
	}
}

foreach($cats['info'] as $key=>$val) 
{
	$html .= "$val[catname]<br/>";
	$r = $db->query("SELECT title, contentid FROM ".DB_PRE."content WHERE catid = '$val[catid]' AND status = 99 ORDER BY contentid DESC LIMIT 5");
	while($s = $db->fetch_array($r)) 
	{
		$html .= "<a href=\"?action=show_info&amp;contentid=$s[contentid]\">$s[title]</a><br/>";
	}
}
?>
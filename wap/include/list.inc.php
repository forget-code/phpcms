<?php
defined('IN_PHPCMS') or exit('Access Denied');

$catid = isset($catid) && !empty($catid) ? intval($catid) : exit($lang['catid_canot_be_empty']);
$catval = $CATEGORY[$catid];
if($catval['modelid'] == 1) 
{
	$a = "show_news";
}
elseif($catval['modelid'] == 4) 
{
	$a = "show_info";
}
$cats = array();
$cats['news'] = submodelcats();
$cats['info'] = submodelcats(4);
$html = menus();
$html .= $catval['catname']."<br/>";
$r = $db->get_one("SELECT COUNT(contentid) as count FROM ".DB_PRE."content WHERE catid = '$catid' AND status = 99");
$num = $r['count'];
$pagesize = 10; 
$page = isset($page) && !empty($page) ? intval($page) : 1;
$offset = ($page-1)*$pagesize;
$pages = wml_pages($num, $page, '?action='.$action.'&amp;catid='.$catid.'&amp;page=', $pagesize);
$r = $db->query("SELECT title,contentid FROM ".DB_PRE."content WHERE catid = '$catid' AND status = 99 ORDER BY contentid DESC LIMIT $offset,$pagesize");
while($s = $db->fetch_array($r)) 
{
	$html .= '<a href="?action='.$a.'&amp;contentid='.$s['contentid'].'">'.$s['title'].'</a><br/>';
}
$html .= $pages;
$html .= '<br/><a href="index.php">'.$lang['return_index'].'</a><br/>';
?>
<?php 
defined('IN_PHPCMS') or exit('Access Denied');

function companypages($catid, $total, $page=1, $perpage=20)
{
	global $PHP_URL,$LANG,$action;
	if(!$url) $url = preg_replace("/(.*)index\.php(.*)action-(.*)/i", "\\1\\2action-$action/", $PHP_URL);
	$url = str_replace('.html','/',$url);
	$s = strpos($url, '?') === FALSE ? '?' : '';
	$pages = ceil($total/$perpage);
	$page = min($pages,$page);
	$prepg = $page-1;
	$nextpg = $page == $pages ? 0 : ($page+1);
	if($total < 1) return FALSE;
	$pagenav = $LANG['total']."<b>$total</b>&nbsp;&nbsp;&nbsp;&nbsp;";
	$pagenav .= $prepg ? "<a href='$url{$s}page-1.html'>".$LANG['first']."</a>&nbsp;<a href='$url{$s}page-$prepg.html'>".$LANG['previous']."</a>&nbsp;" : $LANG['first']."&nbsp;".$LANG['previous']."&nbsp;";
	$pagenav .= $nextpg ? "<a href='$url{$s}page-$nextpg.html'>".$LANG['next']."</a>&nbsp;<a href='$url{$s}page-$pages.html'>".$LANG['last']."</a>&nbsp;" : $LANG['next']."&nbsp;".$LANG['last']."&nbsp;";
	$pagenav .= $LANG['page'].": <b><font color=red>$page</font>/$pages</b>&nbsp;&nbsp;<input type='text' name='page' id='page' class='page' size='2' onKeyDown=\"if(event.keyCode==13) {window.location='{$url}{$s}page-'+this.value+'.html'; return false;}\"> <input type='button' value='GO' class='gotopage' style='width:30px' onclick=\"window.location='{$url}{$s}page-'+$('page').value+'.html'\">\n";
	return $pagenav;
}

function update_url($table,$label,$labelid,$flagid)
{
	global $mod,$db,$MOD,$MODULE;
	if($MOD['enableSecondDomain'])
	{
		extract($db->get_one("SELECT companyid FROM $table WHERE $flagid='$labelid'"));
		extract($db->get_one("SELECT SQL_CACHE sitedomain FROM ".TABLE_MEMBER_COMPANY." WHERE companyid='$companyid'"));
		$linkurl = "http://".$sitedomain.".".$MOD['secondDomain']."/".$label.".php?item-".$labelid.".html";				
		$db->query("UPDATE $table SET linkurl='$linkurl' WHERE $flagid='$labelid'");
	}
	else
	{
		extract($db->get_one("SELECT companyid FROM $table WHERE $flagid='$labelid'"));
		extract($db->get_one("SELECT SQL_CACHE c.username,m.userid FROM ".TABLE_MEMBER_COMPANY." c, ".TABLE_MEMBER." m WHERE c.companyid='$companyid' AND c.username=m.username"));
		$linkurl = $MODULE['yp']['linkurl'].'web/'.$label.'.php?enterprise-'.$userid.'/item-'.$labelid.'.html';
		$db->query("UPDATE $table SET linkurl='$linkurl' WHERE $flagid='$labelid'");
	}
}

function createhtml_show($table,$label,$labelid,$flagid)
{
	global $mod,$db,$MOD,$MODULE,$CONFIG,$PHPCMS,$PHP_TIME,$skindir;
	$r = $db->get_one("SELECT * FROM $table WHERE $flagid='$labelid'");
	while (list($key, $value) = each($r))
	{
		$temp[$key] = $value;
	}
	if($label=='sales'||$label=='buy')
	{
		$product = $temp;
	}
	else
	{
		$$label = $temp;
	}
	$$label = $temp;
	$$flagid = $labelid;		
	$companyid = $temp['companyid'];
	extract($db->get_one("SELECT SQL_CACHE m.username,m.userid,c.companyname AS pagename,c.templateid AS defaultTplType,c.banner,c.background,c.introduce,c.menu FROM ".TABLE_MEMBER_COMPANY." c, ".TABLE_MEMBER." m WHERE c.companyid='$companyid' AND m.username=c.username"));
	if($background)
	{
		$backgrounds = explode('|',$background);
		$backgroundtype = $backgrounds[0];
		$background = $backgrounds[1];
	}
	$filename = $label;
	$_userid = $userid;
	
	require MOD_ROOT.'/include/createhtml/'.$label.'.php';
}
?>
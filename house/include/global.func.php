<?php
function change_url($par_name, $par_value, $url = '')
{
	global $PHP_URL;
	if(!$url) $url = $PHP_URL;
	$par_value = urlencode($par_value);
	$new_url = preg_replace("/([?&]$par_name=)[^&]*/i", "\${1}$par_value", $url);
	return $url == $new_url ? $url.(strpos($url, '?') === FALSE ? '?' : '&').$par_name.'='.$par_value : $new_url;
}

function is_systemdir($dir)
{
	global  $MOD;
	$sysdir = array($MOD['moduledir'],
					$MOD['moduledir'].'/admin',
					$MOD['moduledir'].'/include',
					$MOD['moduledir'].'/'.$MOD['uploaddir']
					);
	return in_array($dir,$sysdir);	
}

function house_item_url($type, $typeid, $ishtml, $urlruleid, $htmldir, $prefix, $itemid, $addtime, $page = 0)
{
	global $mod,$MOD,$PHPCMS,$urlrule,$PARS;
	if(!is_array($MOD)) return FALSE;

	$fileext = $PHPCMS['fileext'];
	$typename = $PARS['infotype']['type_'.$typeid];
	$year = date("Y", $addtime);
	$month = date("m", $addtime);
	$day = date("d", $addtime);
	$html = $ishtml ? 'html' : 'php';
	$rule = $urlrule[$html]['item'][$urlruleid];
	$rule = $page == 0 ? $rule['index'] : $rule['page'];
    eval("\$url = \"$rule\";");
	$urlpre = ($type == 'url' && $MOD['moduledomain']) ? $MOD['moduledomain'] : $mod;
	return $urlpre.$url;
}

function update_house_url($houseid)
{
	global $db;
	$houseid = intval($houseid);
	if(!$houseid) return FALSE;
	$house = $db->get_one("select * from ".TABLE_HOUSE." where houseid=$houseid ");
	if(!$house || $house['islink'])  return FALSE;
	$linkurl = house_item_url('url', $house['infocat'], $house['ishtml'], $house['urlruleid'], '', $house['prefix'], $houseid, $house['addtime'], 0);
	$db->query("update ".TABLE_HOUSE." set linkurl='$linkurl' where houseid=$houseid ");
}

function house_list_url($type, $infocat, $page = 0)
{
	global $mod,$MOD,$PHPCMS,$urlrule,$PARS;
	if(!is_array($MOD)) return FALSE;
	$fileext = $PHPCMS['fileext'];
	$index = $PHPCMS['index'];
	$htmldir = $MOD['listinfodir'];
	$typedir = $PARS['infotype']['typename_'.$infocat];
	$prefix = $PARS['infotype']['typename_'.$infocat];	
	$urlruleid = $MOD['createlistinfo'] ? $MOD['houselist_html_urlruleid'] : $MOD['houselist_php_urlruleid'];
	$html = $MOD['createlistinfo'] ? 'html' : 'php';
	$rule = $urlrule[$html]['type'][$urlruleid];
	$rule = $page == 0 ? $rule['index'] : $rule['page'];
    eval("\$url = \"$rule\";");
	return ($type == 'url' && $MOD['moduledomain']) ? $MOD['moduledomain'].$url : $MOD['moduledir'].$url;
}


function housepages($infocat, $total, $page=1, $perpage=20)
{
	global $LANG;
	$goto = '"'.linkurl(house_list_url('url', $infocat, '"+$("page").value+"')).'"';
	$page = $page > 0 ? $page : 1;
	$pages = ceil($total/$perpage);
	$page = min($pages,$page);
	$prepg = $page-1;
	$nextpg = $page==$pages ? 0 : ($page+1);
	if($total<1) return false;
	$pagenav = $LANG['total'].'<b>'.$total.'</b>&nbsp;&nbsp;&nbsp;&nbsp;';
	$pagenav.= $prepg ? "<a href='".linkurl(house_list_url('url', $infocat, 0))."'>".$LANG['first']."</a>&nbsp;<a href='".linkurl(house_list_url('url', $infocat, $prepg))."'>".$LANG['previous']."</a>&nbsp;" : $LANG['first']."&nbsp;".$LANG['previous']."&nbsp;";
	$pagenav.= $nextpg ? "<a href='".linkurl(house_list_url('url', $infocat, $nextpg))."'>".$LANG['next']."</a>&nbsp;<a href='".linkurl(house_list_url('url', $infocat, $pages))."'>".$LANG['last']."</a>&nbsp;" : $LANG['next']."&nbsp;".$LANG['last']."&nbsp;";
	$pagenav.= $LANG['page'].": <b><font color=red>$page</font>/$pages</b>&nbsp;&nbsp;<input type='text' name='page' id='page' class='page' size='3' onKeyDown='if(event.keyCode==13) {window.location=$goto; return false;}'> <input type='button' value='GO' class='gotopage' style='width:30px' onclick='window.location=$goto'>\n";
	return $pagenav;
}

function displaypages($total, $page=1, $perpage=20)
{
	global $LANG;
	$goto = '"'.linkurl(display_list_url('url', '"+$("page").value+"')).'"';
	$page = $page > 0 ? $page : 1;
	$pages = ceil($total/$perpage);
	$page = min($pages,$page);
	$prepg = $page-1;
	$nextpg = $page==$pages ? 0 : ($page+1);
	if($total<1) return false;
	$pagenav = $LANG['total'].'<b>'.$total.'</b>&nbsp;&nbsp;&nbsp;&nbsp;';
	$pagenav.= $prepg ? "<a href='".linkurl(display_list_url('url', 0))."'>".$LANG['first']."</a>&nbsp;<a href='".linkurl(display_list_url('url', $prepg))."'>".$LANG['previous']."</a>&nbsp;" : $LANG['first']."&nbsp;".$LANG['previous']."&nbsp;";
	$pagenav.= $nextpg ? "<a href='".linkurl(display_list_url('url', $nextpg))."'>".$LANG['next']."</a>&nbsp;<a href='".linkurl(display_list_url('url', $pages))."'>".$LANG['last']."</a>&nbsp;" : $LANG['next']."&nbsp;".$LANG['last']."&nbsp;";
	$pagenav.= $LANG['page'].": <b><font color=red>$page</font>/$pages</b>&nbsp;&nbsp;<input type='text' name='page' id='page' class='page' size='3' onKeyDown='if(event.keyCode==13) {window.location=$goto; return false;}'> <input type='button' value='GO' class='gotopage' style='width:30px' onclick='window.location=$goto'>\n";
	return $pagenav;
}

function display_list_url($type, $page = 0)
{
	global $mod,$MOD,$PHPCMS,$displayrule;
	if(!is_array($MOD)) return FALSE;
	$fileext = $PHPCMS['fileext'];
	$index = $PHPCMS['index'];
	$htmldir = $MOD['listdisplaydir'];
	$prefix = $MOD['listdisplayprefix'];
	$urlruleid = $MOD['createlistdisplay'] ? $MOD['displaylist_html_urlruleid'] : $MOD['displaylist_php_urlruleid'];
	$html = $MOD['createlistdisplay'] ? 'html' : 'php';
	$rule = $displayrule[$html]['list'][$urlruleid];
	$rule = $page == 0 ? $rule['index'] : $rule['page'];
    eval("\$url = \"$rule\";");
	return ($type == 'url' && $MOD['moduledomain']) ? $MOD['moduledomain'].$url : $MOD['moduledir'].$url;
}


function display_item_url($type,$ishtml, $urlruleid, $htmldir, $prefix, $itemid, $addtime, $page = 0)
{
	global $mod,$MOD,$PHPCMS,$displayrule;
	if(!is_array($MOD)) return FALSE;
	$fileext = $PHPCMS['fileext'];
	$year = date('Y', $addtime);
	$month = date('m', $addtime);
	$day = date('d', $addtime);
	$html = $ishtml ? 'html' : 'php';
	$rule = $displayrule[$html]['item'][$urlruleid];
	$rule = $page == 0 ? $rule['index'] : $rule['page'];
    eval("\$url = \"$rule\";");
	$urlpre = ($type == 'url' && $MOD['moduledomain']) ? $MOD['moduledomain'] : $mod;
	return $urlpre.$url;
}

function update_display_url($displayid)
{
	global $db;
	$displayid = intval($displayid);
	if(!$displayid) return FALSE;
	$display = $db->get_one("select * from ".TABLE_HOUSE_DISPLAY." where displayid=$displayid ");
	if(!$display) return FALSE;
	$linkurl = display_item_url('url', $display['ishtml'], $display['urlruleid'], '', '', $displayid, $display['addtime'], 0);
	$db->query("update ".TABLE_HOUSE_DISPLAY." set linkurl='$linkurl' where displayid=$displayid ");
}

function cache_infocat()
{
	global $PARS;
	if(!$PARS) $PARS = include MOD_ROOT.'/include/pars.inc.php';
	$CAT = array();
	for($i=1; $i<=6; $i++)
	{
		$CAT[$i]['name'] = $PARS['infotype']['type_'.$i];
		$CAT[$i]['linkurl'] = linkurl(house_list_url('url', $i));
	}
	cache_write('house_infocat.php', $CAT);
}
?>
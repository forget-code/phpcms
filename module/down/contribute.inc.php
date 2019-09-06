<?php 
defined('IN_PHPCMS') or exit('Access Denied');
require PHPCMS_ROOT."/module/".$mod."/include/common.inc.php";
require PHPCMS_ROOT.'/include/field.class.php';
$field = new field(channel_table('down', $channelid));
if($dosubmit)
{
	checkcode($checkcodestr, $MOD['check_code'], $PHP_REFERER);
	if(!$catid)	showmessage($LANG['choices_category'], 'goback');
	if(empty($title)) showmessage($LANG['short_heading_no_space'], 'goback');
	if(empty($downurls)) showmessage($LANG['download_url_no_air'], 'goback');
	$CAT = cache_read('category_'.$catid.'.php');
	if($CAT['islink']) showmessage($LANG['disallowed_add_information'], 'goback');
	if($CAT['child'] && !$CAT['enableadd']) showmessage($LANG['disallowed_add_downloaded'], 'goback');

	$inputstring = new_htmlspecialchars(array('title'=>$title,'keywords'=>$keywords,'author'=>$author,'homepage'=>$homepage,'thumb'=>$thumb,'downurls'=>$downurls));
	extract($inputstring,EXTR_OVERWRITE);
	$content = str_safe($content);
	$addtime = $PHP_TIME;
	$status = $CHA['enablecheck'] ? 1 : 3;
	$downurls = trim($downurls);
	$urlruleid = $CAT['ishtml'] ? $CAT['item_html_urlruleid'] : $CAT['item_php_urlruleid'];

	$field->check_form();

	$query = "INSERT INTO ".channel_table('down',$channelid)."(catid,typeid,title,keywords,introduce,author,homepage,downurls,thumb,status,username,addtime,editor,edittime,ishtml,urlruleid,htmldir,prefix) VALUES('$catid','$typeid','$title','$keywords','$content','$author','$homepage','$downurls','$thumb','$status','$_username','$addtime','$_username','$addtime','$CAT[ishtml]', '$urlruleid','$CAT[item_htmldir]','$CAT[item_prefix]')";
	$db->query($query);
	$downid = $db->insert_id();
	require PHPCMS_ROOT.'/include/attachment.class.php';
	$att = new attachment;
	$att->attachment($downid, $channelid, $catid);
	$att->add($introduce);
	$field->update("downid=$downid");
	$linkurl = item_url('url', $catid, $CAT['ishtml'], $CAT['item_html_urlruleid'], $CAT['item_htmldir'], $CAT['item_prefix'], $downid, $addtime);
	$db->query("UPDATE ".channel_table('down', $channelid)." SET linkurl='$linkurl' WHERE downid=$downid ");
	if($status == 3)
	{
		require PHPCMS_ROOT.'/include/create_related_html.inc.php';
	}
	showmessage($LANG['download_submitted_success'], $CHA['linkurl'].'contribute.php');
}
else
{
	if(!$MOD['enable_guest_add'] || $_userid)
	{
	   header('Location:'.$PHPCMS['siteurl'].$CHA['channeldir'].'/myitem.php?action=add&'.$PHP_QUERYSTRING);
	   exit;
	}
	if($CHA['channeldomain'] && strpos($PHP_URL, $CHA['channeldomain'])!==false)
	{
	   header('Location:'.$PHPCMS['siteurl'].$CHA['channeldir'].'/contribute.php?'.$PHP_QUERYSTRING);
	   exit;
	}
	$CHA['enablecontribute'] or showmessage($LANG['instructions_disallowed'], 'goback');
	require_once PHPCMS_ROOT."/include/formselect.func.php";
	require PHPCMS_ROOT."/include/tree.class.php";
	$tree = new tree();
	$catid = isset($catid) ? intval($catid) : 0;
	$type_select = type_select('typeid', $LANG['type']);
	$category_select = category_select('catid', $LANG['choose_category'] , $catid);
	$fields = $field->get_form('<tr><td class="td_right"><strong>$title</strong></td><td class="td_left">$input $tool $note</td></tr>');
	$disabled = $CHA['enablecheck'];
	$status = $disabled ? 1 : 3;
	$head['title'] = $LANG['contribute'].'-'.$channelname;
	$head['keywords'] = $LANG['contribute'].','.$channelname.','.$PHPCMS['seo_keywords'];
	$head['description'] = $LANG['contribute'].','.$channelname.','.$PHPCMS['seo_description'];
	include template($mod, 'contribute');
}
?>
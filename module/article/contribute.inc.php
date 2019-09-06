<?php 
defined('IN_PHPCMS') or exit('Access Denied');
require PHPCMS_ROOT."/module/".$mod."/include/common.inc.php";
require PHPCMS_ROOT.'/include/field.class.php';
$field = new field(channel_table('article', $channelid));
if($dosubmit)
{
	checkcode($checkcodestr, $MOD['check_code'], $PHP_REFERER);
	if(!$catid)	showmessage($LANG['please_choose_categories'], 'goback');
	if(empty($title)) showmessage($LANG['short_title_can_not_be_blank'], 'goback');
	if(empty($content))	showmessage($LANG['content_can_not_be_blank'], 'goback');
	$CAT = cache_read('category_'.$catid.'.php');
	if($CAT['islink']) showmessage($LANG['not_allowed_to_add_an_message'], 'goback');
	if($CAT['child'] && !$CAT['enableadd'])showmessage($LANG['not_allowed_to_add_an_artcile'],'goback');
	$inputstring=new_htmlspecialchars(array('title'=>$title,'keywords'=>$keywords,'author'=>$author,'copyfrom'=>$copyfrom,'introduce'=>$introduce,'thumb'=>$thumb));
	extract($inputstring,EXTR_OVERWRITE);
	$content = str_safe($content);
	$addtime = $PHP_TIME;
	if($CHA['enablecheck'])
	{
		$status = ($status == 1 ||  $status == 0) ? $status : 1;
	}
	else
	{
		$status = $status == 2 ? 0 : $status;
	}
	$urlruleid = $CAT['ishtml'] ? $CAT['item_html_urlruleid'] : $CAT['item_php_urlruleid'];

	$field->check_form();

	$query = "INSERT INTO ".channel_table('article',$channelid)."(catid,typeid,title,keywords,introduce,author,copyfrom,thumb,status,username,addtime,editor,edittime,ishtml,urlruleid,htmldir,prefix) VALUES('$catid','$typeid','$title','$keywords','$introduce','$author','$copyfrom','$thumb','$status','$_username','$addtime','$_username','$addtime','$CAT[ishtml]', '$urlruleid','$CAT[item_htmldir]','$CAT[item_prefix]')";
	$db->query($query);
	$articleid = $db->insert_id();
	require PHPCMS_ROOT.'/include/attachment.class.php';
	$att = new attachment;
	$att->attachment($articleid, $channelid, $catid);
	$att->add($content);
	$field->update("articleid=$articleid");
	$linkurl = item_url('url', $catid, $CAT['ishtml'], $CAT['item_html_urlruleid'], $CAT['item_htmldir'], $CAT['item_prefix'], $articleid, $addtime);
	$db->query("UPDATE ".channel_table('article', $channelid)." SET linkurl='$linkurl' WHERE articleid=$articleid ");

	if($MOD['storage_mode'] < 3) $db->query("INSERT INTO ".channel_table('article_data', $channelid)." (articleid,content) values('$articleid', '$content') ");
	if($MOD['storage_mode'] > 1) txt_update($channelid, $articleid, $content);
	if($MOD['storage_mode'] == 3) $db->query("INSERT INTO ".channel_table('article_data', $channelid)." (articleid,content) values('$articleid', '') ");

	if($status == 3)
	{
		require PHPCMS_ROOT.'/include/create_related_html.inc.php';
	}
	showmessage($LANG['add_article_success'], $CHA['linkurl'].'contribute.php');
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
	$CHA['enablecontribute'] or showmessage($LANG['not_allowed_to_add_an_article'], 'goback');
	require_once PHPCMS_ROOT."/include/formselect.func.php";
	require PHPCMS_ROOT."/include/tree.class.php";
	$tree = new tree();
	$catid = isset($catid) ? intval($catid) : 0;
	$type_select = type_select('typeid', $LANG['type']);
	$category_select = category_select('catid', $LANG['please_select'], $catid);
	$fields = $field->get_form('<tr><td class="td_right"><strong>$title</strong></td><td class="td_left">$input $tool $note</td></tr>');
	$disabled = $CHA['enablecheck'];
	$status = $disabled ? 1 : 3;
	$head['title'] = $LANG['add_article'].'-'.$channelname;
	$head['keywords'] = $LANG['add_article'].$channelname.','.$PHPCMS['seo_keywords'];
	$head['description'] = $LANG['add_article'].','.$channelname.','.$PHPCMS['seo_description'];
	include template($mod, 'contribute');
}
?>
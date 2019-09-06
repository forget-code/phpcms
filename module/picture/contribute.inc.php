<?php 
defined('IN_PHPCMS') or exit('Access Denied');
require PHPCMS_ROOT."/module/".$mod."/include/common.inc.php";
require PHPCMS_ROOT.'/include/field.class.php';
$field = new field(channel_table('down', $channelid));
if($dosubmit)
{
	checkcode($checkcodestr, $MOD['check_code'], $PHP_REFERER);
	if(!$catid)	showmessage($LANG['sorry_select_parent_category'], 'goback');
	if(empty($title)) showmessage($LANG['sorry_title_not_null'], 'goback');
	$CAT = cache_read('category_'.$catid.'.php');
	if($CAT['islink']) showmessage($LANG['appoint_category_not_allowed_to_add_info'], 'goback');
	if($CAT['child'] && !$CAT['enableadd']) showmessage($LANG['appoint_category_not_allowed_to_add_picture'], 'goback');
	if(empty($pictureurls)) showmessage($LANG['picture_url_not_null'], 'goback');
	$picurls = explode("\n", $pictureurls);
	$tmp_picurls = array();
	foreach($picurls as $picurl)
	{
		$t = '';
		if(strpos($picurl, "|") === false)
		{
			$t = $picurl;
		}
		else
		{
			$s = explode("|", $picurl);
			$t = $s[1];
		}
		$tmp_picurls[] = $t;
	}
	$tmp_allpicurls = explode("\n", $allpictureurls);
	$tmp_array = array_diff($tmp_allpicurls, $tmp_picurls);
	if(!empty($tmp_array))
	{
		foreach($tmp_array as $v)
		{
			if(strpos($v, "://")) continue;
			$fileurl = trim(PHPCMS_ROOT.'/'.$CHA['channeldir'].'/'.$MOD['upload_dir'].'/'.$v);
			@unlink($fileurl);
			@unlink(dirname($fileurl).'/thumb_'.basename($fileurl));
		}
	}
	$inputstring=new_htmlspecialchars(array('title'=>$title,'thumb'=>$thumb,'pictureurls'=>$pictureurls));
	extract($inputstring,EXTR_OVERWRITE);
	$content = str_safe($content);
	$addtime = $PHP_TIME;
	$status = $CHA['enablecheck'] ? 1 : 3;
	$urlruleid = $CAT['ishtml'] ? $CAT['item_html_urlruleid'] : $CAT['item_php_urlruleid'];

	$field->check_form();

	$query = "INSERT INTO ".channel_table('picture', $channelid)."(catid,typeid,title,introduce,thumb,status,islink,pictureurls,username,addtime,editor,edittime,ishtml,urlruleid,htmldir,prefix) VALUES('$catid','$typeid','$title','$content','$thumb','$status','0','$pictureurls','$_username','$addtime','$_username','$addtime','$CAT[ishtml]', '$urlruleid','$CAT[item_htmldir]','$CAT[item_prefix]')";
	$db->query($query);
	$pictureid = $db->insert_id();
	require PHPCMS_ROOT.'/include/attachment.class.php';
	$att = new attachment;
	$att->attachment($pictureid, $channelid, $catid);
	$att->add($introduce);
	$field->update("pictureid=$pictureid");
	$linkurl = item_url('url', $catid, $CAT['ishtml'], $CAT['item_html_urlruleid'], $CAT['item_htmldir'], $CAT['item_prefix'], $pictureid, $addtime);
	$db->query("UPDATE ".channel_table('picture', $channelid)." SET linkurl='$linkurl' WHERE pictureid=$pictureid ");
	if($status == 3)
	{
		require PHPCMS_ROOT.'/include/create_related_html.inc.php';
	}
	showmessage($LANG['picture_post_success'], $CHA['linkurl'].'contribute.php');
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
	$CHA['enablecontribute'] or showmessage($LANG['current_channel_not_allow_submit_picture'], 'goback');
	require_once PHPCMS_ROOT."/include/formselect.func.php";
	require PHPCMS_ROOT."/include/tree.class.php";
	$tree = new tree();
	$catid = isset($catid) ? intval($catid) : 0;
	$type_select = type_select('typeid', $LANG['type']);
	$category_select = category_select('catid', $LANG['select_category'], $catid);
	$fields = $field->get_form('<tr><td class="td_right"><strong>$title</strong></td><td class="td_left">$input $tool $note</td></tr>');
	$disabled = $CHA['enablecheck'];
	$status = $disabled ? 1 : 3;
	$head['title'] = $LANG['contribute'].'-'.$channelname;
	$head['keywords'] = $LANG['contribute'].','.$channelname.','.$PHPCMS['seo_keywords'];
	$head['description'] = $LANG['contribute'].','.$channelname.','.$PHPCMS['seo_description'];
	include template($mod, 'contribute');
}
?>
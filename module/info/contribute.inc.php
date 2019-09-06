<?php 
defined('IN_PHPCMS') or exit('Access Denied');
require PHPCMS_ROOT."/module/".$mod."/include/common.inc.php";
require PHPCMS_ROOT.'/include/field.class.php';
$field = new field(channel_table('info', $channelid));
if($dosubmit)
{
	checkcode($checkcodestr, $MOD['check_code'], $PHP_REFERER);
	if(!$catid)	showmessage($LANG['sorry_select_parent_category'], 'goback');
	$CAT = cache_read('category_'.$catid.'.php');
	if(empty($title)) showmessage($LANG['sorry_title_not_null'], 'goback');
	if(empty($content))	showmessage($LANG['sorry_information_content_not_null'], 'goback');
	if($CAT['child'] && !$CAT['enableadd']) showmessage($LANG['appoint_category_not_allowed_to_add_info'], 'goback');
	if(empty($areaid)) showmessage($LANG['select_parent_area'], 'goback');
	if(empty($author)) showmessage($LANG['select_contractor'], 'goback');
	if(empty($telephone)) showmessage($LANG['input_telephone'], 'goback');
	if(!empty($email) && !is_email($email)) showmessage($LANG['mail_format_not_correct'], 'goback');
	if(!empty($msn) && !is_email($msn)) showmessage($LANG['msn_format_not_correct'], 'goback');
	$inputstring=new_htmlspecialchars(array('title'=>$title,'province'=>$province,'city'=>$city,'area'=>$area,'author'=>$author,'telephone'=>$telephone,'address'=>$address,'email'=>$email,'qq'=>$qq,'msn'=>$msn,'endtime'=>$endtime,'thumb'=>$thumb));
	extract($inputstring,EXTR_OVERWRITE);
	$content = str_safe($content);
	$addtime = $PHP_TIME;
	$endtime = preg_match('/^([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})/', $endtime) ? strtotime($endtime.' '.date('H:i:s', $PHP_TIME)) : 0;
	$status = $CHA['enablecheck'] ? 1 : 3;
	$urlruleid = $CAT['ishtml'] ? $CAT['item_html_urlruleid'] : $CAT['item_php_urlruleid'];

	$field->check_form();

	$query = "INSERT INTO ".channel_table('info', $channelid)."(catid,typeid,title,areaid,author,telephone,email,msn,qq,address,content,thumb,status,islink,username,addtime,ip,endtime,ishtml,urlruleid,htmldir,prefix) VALUES('$catid','$typeid','$title','$areaid','$author','$telephone','$email','$msn','$qq','$address','$content','$thumb','$status','0','$_username','$addtime','$PHP_IP','$endtime','$CAT[ishtml]', '$urlruleid','$CAT[item_htmldir]','$CAT[item_prefix]')";
	$db->query($query);
	$infoid = $db->insert_id();

	require PHPCMS_ROOT.'/include/attachment.class.php';
	$att = new attachment;
	$att->attachment($infoid, $channelid, $catid);
	$att->add($content);

	$field->update("infoid=$infoid");
	$linkurl = item_url('url', $catid, $CAT['ishtml'], $CAT['item_html_urlruleid'], $CAT['item_htmldir'], $CAT['item_prefix'], $infoid, $addtime);
	$db->query("UPDATE ".channel_table('info', $channelid)." SET linkurl='$linkurl' WHERE infoid=$infoid ");
	if($status == 3)
	{
		require PHPCMS_ROOT.'/include/create_related_html.inc.php';
	}
	showmessage($LANG['info_post_success'], $PHP_REFERER);
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
	$CHA['enablecontribute'] or showmessage($LANG['current_channel_not_allow_submit_info'], 'goback');
	require_once PHPCMS_ROOT."/include/formselect.func.php";
	require PHPCMS_ROOT."/include/tree.class.php";
	$tree = new tree();
	$catid = isset($catid) ? intval($catid) : 0;
	$type_select = type_select('typeid', $LANG['type']);
	$category_select = category_select('catid', $LANG['select_category'], $catid);
	$info_province = isset($province) ? trim(urldecode($province)) : $PHPCMS['province'];
	$info_city = isset($city) ? trim(urldecode($city)) : $PHPCMS['city'];
	$info_area = isset($area) ? trim(urldecode($area)) : $PHPCMS['area'];
	$fields = $field->get_form('<tr><td class="td_right"><strong>$title</strong></td><td class="td_left">$input $tool $note</td></tr>');
	$head['title'] = $LANG['post_information'].'-'.$channelname;
	$head['keywords'] = $LANG['post_information'].",".$channelname.",".$PHPCMS['seo_keywords'];
	$head['description'] = $LANG['post_information'].','.$channelname.','.$PHPCMS['seo_description'];
	include template($mod, 'contribute');
}
?>
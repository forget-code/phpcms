<?php
defined('IN_PHPCMS') or exit('Access Denied');

require PHPCMS_ROOT.'/module/'.$mod.'/include/common.inc.php';

if($CHA['channeldomain'] && strpos($PHP_URL, $CHA['channeldomain'])!==false)
{
   header('Location:'.$PHPCMS['siteurl'].$CHA['channeldir'].'/myitem.php?'.$PHP_QUERYSTRING);
   exit;
}
$CHA['enablecontribute'] or showmessage($LANG['current_channel_not_allow_submit_info'], 'goback');
$_userid or showmessage($LANG['please_login'], 'goback');

require PHPCMS_ROOT.'/include/field.class.php';
$field = new field(channel_table('info', $channelid));

require_once PHPCMS_ROOT.'/include/post.func.php';
require_once PHPCMS_ROOT."/include/formselect.func.php";
require PHPCMS_ROOT."/include/tree.class.php";
$tree = new tree();

$infoid = isset($infoid) ? intval($infoid) : 0;
$catid = isset($catid) ? intval($catid) : 0;
if($catid) $CAT = cache_read('category_'.$catid.'.php');

$category_select = category_select('catid',$LANG['select_category'], $catid, 'id="catid"');
$pagesize = $PHPCMS['pagesize'] ? $PHPCMS['pagesize'] : 20;
$referer = isset($referer) ? $referer : $PHP_REFERER;
$action = isset($action) ? $action : 'manage';
if(!isset($checkcodestr)) $checkcodestr = '';

switch($action)
{
	case 'add':

		if($dosubmit)
		{
			checkcode($checkcodestr, $MOD['check_code'], $PHP_REFERER);
			if(!$catid)	showmessage($LANG['sorry_select_parent_category'], 'goback');
			if(empty($title)) showmessage($LANG['sorry_title_not_null'], 'goback');
			if(empty($content))	showmessage($LANG['sorry_information_content_not_null'], 'goback');
			if($CAT['child'] && !$CAT['enableadd']) showmessage($LANG['appoint_category_not_allowed_to_add_info'], 'goback');
			if($CAT['arrgroupid_add'] && strpos($CAT['arrgroupid_add'], "$_groupid") === false) showmessage($LANG['not_allowed_to_add_by_your_group'], 'goback');
			if(empty($areaid)) showmessage($LANG['select_parent_area'], 'goback');
			if(empty($author)) showmessage($LANG['select_contractor'], 'goback');
			if(empty($telephone)) showmessage($LANG['input_telephone'], 'goback');
			if(!empty($email) && !is_email($email)) showmessage($LANG['mail_format_not_correct'], 'goback');
			if(!empty($msn) && !is_email($msn)) showmessage($LANG['msn_format_not_correct'], 'goback');
			$inputstring = new_htmlspecialchars(array('title'=>$title,'province'=>$province,'city'=>$city,'area'=>$area,'author'=>$author,'telephone'=>$telephone,'address'=>$address,'email'=>$email,'qq'=>$qq,'msn'=>$msn,'endtime'=>$endtime,'thumb'=>$thumb));
			extract($inputstring,EXTR_OVERWRITE);
			$content = str_safe($content);
			$addtime = $PHP_TIME;
			$endtime = preg_match('/^([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})/', $endtime) ? strtotime($endtime.' '.date('H:i:s', $PHP_TIME)) : 0;
			$status = $CHA['enablecheck'] ? 1 : 3;
			$urlruleid = $CAT['ishtml'] ? $CAT['item_html_urlruleid'] : $CAT['item_php_urlruleid'];

			$field->check_form();

			$query = "INSERT INTO ".channel_table('info', $channelid)."(catid,typeid,title,areaid,author,telephone,email,msn,qq,address,content,thumb,status,islink,username,addtime,edittime,ip,endtime,ishtml,urlruleid,htmldir,prefix) VALUES('$catid','$typeid','$title','$areaid','$author','$telephone','$email','$msn','$qq','$address','$content','$thumb','$status','0','$_username','$addtime','$addtime','$PHP_IP','$endtime','$CAT[ishtml]', '$urlruleid','$CAT[item_htmldir]','$CAT[item_prefix]')";
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
			if(isset($MODULE['pay']) && $MOD['add_point'])
			{
				require_once PHPCMS_ROOT.'/pay/include/pay.func.php';
				point_diff($_username, $MOD['add_point'], $title.'(channelid='.$channelid.',infoid='.$infoid.')');
			}
			showmessage($LANG['info_post_success'], $referer);
		}
		else
		{
			$fields = $field->get_form('<tr><td class="td_right"><strong>$title</strong></td><td class="td_left">$input $tool $note</td></tr>');
			$type_select = type_select('typeid', $LANG['type']);
			$info_province = isset($province) ? trim(urldecode($province)) : $PHPCMS['province'];
			$info_city = isset($city) ? trim(urldecode($city)) : $PHPCMS['city'];
			$info_area = isset($area) ? trim(urldecode($area)) : $PHPCMS['area'];
			$disabled = $CHA['enablecheck'];
		}
	break;

	case 'edit':

		$infoid or showmessage($LANG['info_id_not_null'], 'goback');
		if($dosubmit)
		{
			checkcode($checkcodestr, $MOD['check_code'], $PHP_REFERER);
			if(!$catid)	showmessage($LANG['sorry_select_parent_category'], 'goback');
			if(empty($title)) showmessage($LANG['sorry_title_not_null'], 'goback');
			if(empty($content))	showmessage($LANG['sorry_information_content_not_null'], 'goback');
			if($CAT['child'] && !$CAT['enableadd']) showmessage($LANG['appoint_category_not_allowed_to_add_info'], 'goback');
			if($CAT['arrgroupid_add'] && strpos($CAT['arrgroupid_add'], "$_groupid") === false) showmessage($LANG['not_allowed_to_add_by_your_group'], 'goback');
			if(empty($areaid)) showmessage($LANG['select_parent_area'], 'goback');
			if(empty($author)) showmessage($LANG['select_contractor'], 'goback');
			if(empty($telephone)) showmessage($LANG['input_telephone'], 'goback');
			if(!empty($email) && !is_email($email)) showmessage($LANG['mail_format_not_correct'], 'goback');
			if(!empty($msn) && !is_email($msn)) showmessage($LANG['msn_format_not_correct'], 'goback');
			$inputstring=new_htmlspecialchars(array('title'=>$title,'author'=>$author,'telephone'=>$telephone,'address'=>$address,'email'=>$email,'qq'=>$qq,'msn'=>$msn,'endtime'=>$endtime,'thumb'=>$thumb));
			extract($inputstring,EXTR_OVERWRITE);
			$content = str_safe($content);
			$addtime = $PHP_TIME;
			$endtime = preg_match('/^([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})/', $endtime) ? strtotime($endtime.' '.date('H:i:s', $PHP_TIME)) : 0;
			
			$field->check_form();

			$query = "UPDATE ".channel_table('info', $channelid)." SET catid='$catid',typeid='$typeid',title='$title',areaid='$areaid',endtime='$endtime',thumb='$thumb',content='$content',author='$author',telephone='$telephone',address='$address',email='$email',msn='$msn',qq='$qq',editor='$_username',edittime='$PHP_TIME' WHERE infoid=$infoid  AND username='$_username' ";
			$db->query($query);
			$field->update("infoid=$infoid");
			require PHPCMS_ROOT.'/include/create_related_html.inc.php';
			showmessage($LANG['info_edit_success'], $referer);
		}
		else
		{
			$r = $db->get_one("SELECT * FROM ".channel_table('info', $channelid)." WHERE infoid=$infoid AND username='$_username' ");
			if(!$r['infoid']) showmessage($LANG['info_not_exist_or_no_permission'], 'goback');
			@extract($r);
			$endtime = date('Y-m-d', $endtime);
			$type_select = type_select('typeid', $LANG['type'], $typeid);
			$category_select = category_select('catid', $LANG['select_category'], $catid, 'id="catid"');
			$fields = $field->get_form('<tr><td class="td_right"><strong>$title</strong></td><td class="td_left">$input $tool $note</td></tr>');
		}
	break;

	case 'preview':
		
		$infoid or showmessage($LANG['info_id_not_null'], 'goback'); 
		$r = $db->get_one("SELECT * FROM ".channel_table('info', $channelid)." WHERE infoid=$infoid AND username='$_username' ");
		$r['infoid'] or showmessage($LANG['cannot_preview_info_not_exist'], 'goback');
		@extract($r);
		$adddate = date('Y-m-d', $addtime);
		$enddate = $endtime ? date('Y-m-d', $endtime) : $LANG['no_limit'];
		$thumb = imgurl($thumb);
		$CAT = cache_read('category_'.$catid.'.php');
		$catname = $CAT['catname'];
		$myfields = cache_read('phpcms_'.$mod.'_'.$channelid.'_fields.php');
		$fields = array();
		if(is_array($myfields))
		{
			foreach($myfields as $k=>$v)
			{
				$myfield = $v['name'];
				$fields[] = array('title'=>$v['title'],'value'=>$$myfield);
			}
		}

	break;

	case 'delete':

		$infoid or showmessage($LANG['info_id_not_null'], 'goback');
		$r = $db->get_one("SELECT infoid,linkurl,thumb,catid,ishtml,urlruleid,htmldir,prefix,addtime FROM ".channel_table('info', $channelid)." WHERE infoid=$infoid AND username='$_username' ");
		$r['infoid'] or showmessage($LANG['info_not_exist_or_no_permission'], 'goback');
		if($r['ishtml'])
		{
			$linkurl = item_url('path', $r['catid'], $r['ishtml'], $r['urlruleid'], $r['htmldir'], $r['prefix'], $r['infoid'], $r['addtime']);
			@unlink(PHPCMS_ROOT.'/'.$linkurl);
		}
		$db->query("DELETE FROM ".channel_table('info', $channelid)." WHERE infoid=$infoid AND username='$_username' ");
		if($db->affected_rows()>0)
		{
			require PHPCMS_ROOT.'/include/create_related_html.inc.php';
			showmessage($LANG['info_delete_success'],$referer);
		}
		else
		{
			showmessage($LANG['info_delete_fail'], 'goback');
		}
	break;


	case 'update':

		$infoid or showmessage($LANG['info_id_not_null'], 'goback');
		$db->query("UPDATE ".channel_table('info', $channelid)." set edittime='$PHP_TIME' WHERE infoid=$infoid AND username='$_username' ");
		if($db->affected_rows()>0)
		{
			require PHPCMS_ROOT.'/include/create_related_html.inc.php';
			showmessage($LANG['info_update_success'],$referer);
		}
		else
		{
			showmessage($LANG['info_update_fail'], 'goback');
		}
	break;

	case 'manage':

		$status = isset($status) ? intval($status) : 3;
		$ordertype = isset($ordertype) ? intval($ordertype) : 0;
		$searchtype = isset($searchtype) ? trim($searchtype) : 'title';
		$keywords = isset($keywords) ? trim($keywords) : '';

		if($ordertype<0 || $ordertype>5) $ordertype = 0;
		if($catid && !array_key_exists($catid, $CATEGORY)) $catid = 0;
		if(!isset($page))
		{
			$page=1;
			$offset=0;
		}
		else
		{
			$offset=($page-1)*$pagesize;
		}

		$ordertypes = array('listorder DESC, infoid DESC', 'edittime DESC', 'edittime ASC', 'hits DESC', 'hits ASC');

		$sql = '';
		if(!empty($keywords))
		{
			$keyword = str_replace(array(' ','*'),array('%','%'),$keywords);
			$searchtypes = array('title', 'author');
			$searchtype = in_array($searchtype, $searchtypes) ? $searchtype : 'title';
			$sql.= " AND $searchtype LIKE '%$keyword%' ";
		}
		if($catid)
		{
			$sql .=  $CATEGORY[$catid]['child'] ? " and catid in({$CATEGORY[$catid]['arrchildid']}) " : " and catid = $catid ";
		}

		$r = $db->get_one("SELECT COUNT(infoid) as num FROM ".channel_table('info', $channelid)." WHERE status='$status' AND username='$_username' $sql ");
		$number = $r["num"];
		$pages = phppages($number, $page, $pagesize);

		$infos = array();
		$result = $db->query("SELECT * FROM ".channel_table('info', $channelid)." WHERE status='$status' AND username='$_username' $sql ORDER BY $ordertypes[$ordertype] LIMIT $offset,$pagesize ");
		if($db->num_rows($result)>0)
		{
			while($r = $db->fetch_array($result))
			{
				$r['title'] = str_cut($r['title'], 46, '...');
				$r['title'] = style($r['title'], $r['style']);
				$r['linkurl'] = linkurl($r['linkurl']);
				$r['adddate'] = date("Y-m-d",$r['addtime']);
				$r['catname'] = $CATEGORY[$r['catid']]['catname'];
				$r['catlinkurl'] = $CATEGORY[$r['catid']]['linkurl'];
				$r['type'] = $r['typeid'] ? show_type($channelid, $r['typeid']) : '';
				$infos[]=$r;
			}
		}
	break;
}

$head['title'] = $LANG['my_pictrue_manage'];
$head['keywords'] = $PHPCMS['seo_keywords'];
$head['description'] = $PHPCMS['seo_description'];

include template('info', 'myitem');
?>
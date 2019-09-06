<?php
defined('IN_PHPCMS') or exit('Access Denied');
require PHPCMS_ROOT.'/module/'.$mod.'/include/common.inc.php';
if($CHA['channeldomain'] && strpos($PHP_URL, $CHA['channeldomain'])!==false)
{
   header('Location:'.$PHPCMS['siteurl'].$CHA['channeldir'].'/myitem.php?'.$PHP_QUERYSTRING);
   exit;
}
$CHA['enablecontribute'] or showmessage($LANG['current_channel_not_allow_submit_picture'], 'goback');
$_userid  or showmessage($LANG['please_login'], 'goback');

require PHPCMS_ROOT.'/include/field.class.php';
$field = new field(channel_table('picture', $channelid));

require_once PHPCMS_ROOT.'/include/post.func.php';
require_once PHPCMS_ROOT.'/include/formselect.func.php';
require PHPCMS_ROOT.'/include/tree.class.php';
$tree = new tree();

$enableaddalways = false;
$GROUP = cache_read('member_group.php');
$gid[] = $_groupid;
$gids = array_merge($_arrgroupid, $gid);
foreach($gids as $gid)
{
	if($GROUP[$gid]['enableaddalways'])
	{
		$enableaddalways = true;
		break;
	}
}

$pictureid = isset($pictureid) ? intval($pictureid) : 0;
$catid = isset($catid) ? intval($catid) : 0;
if($catid) $CAT = cache_read('category_'.$catid.'.php');

$category_select = category_select('catid', $LANG['select_category'], $catid, 'id="catid"');
$pagesize = $PHPCMS['pagesize'] ? $PHPCMS['pagesize'] : 20;
$referer = isset($referer) ? $referer : $PHP_REFERER;
$action = isset($action) ? $action : 'manage';
if(!isset($checkcodestr)) $checkcodestr = '';

switch($action){

case 'add':

	if($dosubmit)
	{
		checkcode($checkcodestr, $MOD['check_code'], $PHP_REFERER);
		if(!$catid)	showmessage($LANG['sorry_select_parent_category'], 'goback');
		if(empty($title)) showmessage($LANG['sorry_title_not_null'], 'goback');
		if($CAT['child'] && !$CAT['enableadd']) showmessage($LANG['appoint_category_not_allowed_to_add_picture'], 'goback');
		if(empty($pictureurls)) showmessage($LANG['picture_url_not_null'], 'goback');
		if($CAT['arrgroupid_add'] && strpos($CAT['arrgroupid_add'], "$_groupid") === false) showmessage($LANG['not_allowed_to_add_by_your_group'], 'goback');
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
		if($enableaddalways) $status = 3;
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
			if(isset($MODULE['pay']) && ($CAT['creditget'] || $MOD['add_point']))
			{
				require_once PHPCMS_ROOT.'/pay/include/pay.func.php';
				$point = $CAT['creditget'] ? $CAT['creditget'] : $MOD['add_point'];
				point_add($_username, $point, $title.'(channelid='.$channelid.',pictureid='.$pictureid.')');
			}
			require PHPCMS_ROOT.'/include/create_related_html.inc.php';
		}
		showmessage($LANG['picture_post_success'], $referer);
	}
	else
	{
		$fields = $field->get_form('<tr><td class="td_right"><strong>$title</strong></td><td class="td_left">$input $tool $note</td></tr>');
		$type_select = type_select('typeid', $LANG['type']);
		$picture_province = isset($province) ? trim(urldecode($province)) : $PHPCMS['province'];
		$picture_city = isset($city) ? trim(urldecode($city)) : $PHPCMS['city'];
		$picture_area = isset($area) ? trim(urldecode($area)) : $PHPCMS['area'];
		$disabled = $CHA['enablecheck'] && !$enableaddalways;
	}
break;

case 'edit':

    $pictureid or showmessage($LANG['picture_id_not_null'], 'goback');
    if($dosubmit)
	{
		checkcode($checkcodestr, $MOD['check_code'], $PHP_REFERER);
		if(!$catid)	showmessage($LANG['sorry_select_parent_category'], 'goback');
		if(empty($title)) showmessage($LANG['sorry_title_not_null'], 'goback');
		if($CAT['child'] && !$CAT['enableadd']) showmessage($LANG['appoint_category_not_allowed_to_add_picture'], 'goback');
		if(empty($pictureurls)) showmessage($LANG['picture_url_not_null'], 'goback');
		if($CAT['arrgroupid_add'] && strpos($CAT['arrgroupid_add'], "$_groupid") === false) showmessage($LANG['not_allowed_to_add_by_your_group'], 'goback');
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
		$inputstring = new_htmlspecialchars(array('title'=>$title,'thumb'=>$thumb,'pictureurls'=>$pictureurls));
		extract($inputstring,EXTR_OVERWRITE);
		$content = str_safe($content);

	    $field->check_form();

		$query = "UPDATE ".channel_table('picture', $channelid)." SET catid='$catid',typeid='$typeid',title='$title',thumb='$thumb',introduce='$content',pictureurls='$pictureurls',editor='$_username',edittime='$PHP_TIME' WHERE pictureid=$pictureid  AND username='$_username' AND status!=3 ";
		$db->query($query);
		$field->update("pictureid=$pictureid");
		showmessage($LANG['picture_edit_success'], $referer);
	}
	else
	{
		$r = $db->get_one("SELECT * FROM ".channel_table('picture', $channelid)." WHERE pictureid=$pictureid AND username='$_username' AND status!=3 ");
		if(!$r['pictureid']) showmessage($LANG['picture_not_exist_or_no_permission'], 'goback');
		@extract($r);
		$type_select = type_select('typeid', $LANG['type'], $typeid);
		$category_select = category_select('catid', $LANG['select_category'], $catid, 'id="catid"');
		$fields = $field->get_form('<tr><td class="td_right"><strong>$title</strong></td><td class="td_left">$input $tool $note</td></tr>');
		$pictureurls = trim($pictureurls);
		$picurls = explode("\n", $pictureurls);
		$allpictureurls = array();
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
			$allpictureurls[] = $t;
		}
		$allpictureurls = implode("\n", $allpictureurls);
	}
break;

case 'preview':

    $pictureid or showmessage($LANG['picture_id_not_null'], ' goback'); 
	$r = $db->get_one("SELECT * FROM ".channel_table('picture', $channelid)." WHERE pictureid=$pictureid AND username='$_username' ");
	$r['pictureid'] or showmessage($LANG['cannot_preview_picture_not_exist'], 'goback');
	@extract($r);
	$adddate = date('Y-m-d', $addtime);
	$enddate = $endtime ? date('Y-m-d', $endtime) : $LANG['no_limit'];
	$thumb = imgurl($thumb);
	$CAT = cache_read('category_'.$catid.'.php');
	$catname = $CAT['catname'];
	$urls = explode("\n", $pictureurls);
	$urls = array_map("trim", $urls);
	$pictureurls = array();
	$r = array();
	foreach($urls as $k=>$url)
	{
		if($url == '' || !strpos($url, "|")) continue;
		$url = explode("|", $url);
		$r['alt'] = $url[0];
		$r['src'] = strpos($url[1], "://") ? $url[1] :  imgurl($url[1]);
		$pictureurls[] = $r;
	}
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

	$pictureid or showmessage($LANG['picture_id_not_null'], ' goback'); 
	$db->query("DELETE FROM ".channel_table('picture', $channelid)." WHERE pictureid=$pictureid AND username='$_username' AND status!=3 ");
	if($db->affected_rows()>0)
	{
		showmessage($LANG['picture_delete_success'],$referer);
	}
	else
	{
		showmessage($LANG['picture_delete_fail'], 'goback');
	}
break;

case 'manage':

	$status=isset($status) ? intval($status) : 3;
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

	$ordertypes = array('listorder DESC, pictureid DESC', 'edittime DESC', 'edittime ASC', 'hits DESC', 'hits ASC');

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

	$query="SELECT COUNT(pictureid) as num FROM ".channel_table('picture', $channelid)." WHERE status='$status' AND username='$_username' $sql ";
	$result=$db->query($query);
	$r=$db->fetch_array($result);
	$number=$r["num"];

	$pages=phppages($number, $page, $pagesize);
	$pictures = array();
	$query="SELECT * FROM ".channel_table('picture', $channelid)." WHERE status='$status' AND username='$_username' $sql ORDER BY $ordertypes[$ordertype] LIMIT $offset,$pagesize ";
	$result=$db->query($query);
	if($db->num_rows($result)>0)
	{
		while($r=$db->fetch_array($result))
		{
			$r['linkurl'] = linkurl($r['linkurl']);
			$r['title'] = str_cut($r['title'], 46, '...');
			$r['title'] = style($r['title'], $r['style']);
			$r['adddate']=date("Y-m-d",$r['addtime']);
			$r['catname'] = $CATEGORY[$r['catid']]['catname'];
			$r['catlinkurl'] = $CATEGORY[$r['catid']]['linkurl'];
			$r['type'] = $r['typeid'] ? show_type($channelid, $r['typeid']) : '';
			$pictures[]=$r;
		}
	}
break;
}

$head['title'] = $LANG['my_pictrue_manage'];
$head['keywords'] = $PHPCMS['seo_keywords'];
$head['description'] = $PHPCMS['seo_description'];
include template('picture', 'myitem');
?>
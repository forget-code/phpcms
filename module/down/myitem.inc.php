<?php
defined('IN_PHPCMS') or exit('Access Denied');

require PHPCMS_ROOT.'/module/'.$mod.'/include/common.inc.php';
if($CHA['channeldomain'] && strpos($PHP_URL, $CHA['channeldomain'])!==false)
{
   header('Location:'.$PHPCMS['siteurl'].$CHA['channeldir'].'/myitem.php?'.$PHP_QUERYSTRING);
   exit;
}
$CHA['enablecontribute'] or showmessage($LANG['instructions_disallowed'], 'goback');
$_userid or showmessage($LANG['landing'], 'goback');

require PHPCMS_ROOT.'/include/field.class.php';
$field = new field(channel_table('down', $channelid));

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

$downid = isset($downid) ? intval($downid) : 0;
$catid = isset($catid) ? intval($catid) : 0;
if($catid) $CAT = cache_read('category_'.$catid.'.php');

$category_select = category_select('catid', $LANG['choose_columns'], $catid, 'id="catid"');
$pagesize = $PHPCMS['pagesize'] ? $PHPCMS['pagesize'] : 20;
$referer = isset($referer) ? $referer : $PHP_REFERER;
$action = isset($action) ? $action : 'manage';
if(!isset($checkcodestr)) $checkcodestr = '';

switch($action){

case 'add':

	if($dosubmit)
	{
		checkcode($checkcodestr, $MOD['check_code'], $PHP_REFERER);
		if(!$catid)	showmessage($LANG['choices_category'], 'goback');
		if(empty($title)) showmessage($LANG['short_heading_no_space'], 'goback');
		if(empty($downurls))	showmessage($LANG['download_url_no_air'], 'goback');
		if($CAT['child'] && !$CAT['enableadd']) showmessage($LANG['disallowed_add_information'], 'goback');
		if($CAT['arrgroupid_add'] && strpos($CAT['arrgroupid_add'], "$_groupid") === false) showmessage($LANG['not_allowed_to_add_by_your_group'], 'goback');
		$filesize = $filesize ? ($filesizetype ? $filesize.' '.$filesizetype : bytes2x($filesize)) : $LANG['unknown'];
		$inputstring=new_htmlspecialchars(array('title'=>$title,'keywords'=>$keywords,'author'=>$author,'homepage'=>$homepage,'thumb'=>$thumb,'downurls'=>$downurls));
		extract($inputstring,EXTR_OVERWRITE);
		$content = str_safe($content);
		$addtime = $PHP_TIME;

		$status = $CHA['enablecheck'] ? 1 : 3;
		if($enableaddalways) $status = 3;

		$downurls = trim($downurls);
		$urlruleid = $CAT['ishtml'] ? $CAT['item_html_urlruleid'] : $CAT['item_php_urlruleid'];

	    $field->check_form();

		$query = "INSERT INTO ".channel_table('down',$channelid)."(catid,typeid,title,keywords,introduce,author,homepage,downurls,filesize,thumb,status,username,addtime,editor,edittime,ishtml,urlruleid,htmldir,prefix) VALUES('$catid','$typeid','$title','$keywords','$content','$author','$homepage','$downurls','$filesize','$thumb','$status','$_username','$addtime','$_username','$addtime','$CAT[ishtml]', '$urlruleid','$CAT[item_htmldir]','$CAT[item_prefix]')";
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
			if(isset($MODULE['pay']) && ($CAT['creditget'] || $MOD['add_point']))
			{
				require_once PHPCMS_ROOT.'/pay/include/pay.func.php';
				$point = $CAT['creditget'] ? $CAT['creditget'] : $MOD['add_point'];
				point_add($_username, $point, $title.'(channelid='.$channelid.',downid='.$downid.')');
			}
			require PHPCMS_ROOT.'/include/create_related_html.inc.php';
		}
		showmessage($LANG['delivered_success'], $referer);
	}
	else
	{
		$fields = $field->get_form('<tr><td class="td_right"><strong>$title</strong></td><td class="td_left">$input $tool $note</td></tr>');
		$type_select = type_select('typeid', $LANG['type']);
		$disabled = $CHA['enablecheck'] && !$enableaddalways;
	}
break;

case 'edit':

	$downid or showmessage($LANG['id_not_air'], 'goback');
    if($dosubmit)
	{
		if(!$catid)	showmessage($LANG['choose_category'], 'goback');
		if(empty($title)) showmessage($LANG['short_heading_no_space'], 'goback');
		if(empty($content))	showmessage($LANG['content_not_empty'], 'goback');
		if($CAT['child'] && !$CAT['enableadd']) showmessage($LANG['disallowed_add_downloaded'], 'goback');
		
		if($CAT['arrgroupid_add'] && strpos($CAT['arrgroupid_add'], "$_groupid") === false) showmessage($LANG['not_allowed_to_add_by_your_group'], 'goback');
		$inputstring = new_htmlspecialchars(array('title'=>$title,'keywords'=>$keywords,'author'=>$author,'homepage'=>$homepage,'thumb'=>$thumb,'downurls'=>$downurls));
		extract($inputstring,EXTR_OVERWRITE);
		$content = str_safe($content);
		$addtime = $PHP_TIME;
		$downurls = trim($downurls);

	    $field->check_form();

		$query = "UPDATE ".channel_table('down', $channelid)." SET catid='$catid',typeid='$typeid',title='$title',introduce='$content',keywords='$keywords',author='$author',homepage='$homepage',thumb='$thumb',editor='$_username',edittime='$PHP_TIME',downurls='$downurls',filesize='$filesize' WHERE downid=$downid  AND username='$_username' AND status!=3 ";
		$db->query($query);
		$field->update("downid=$downid");
		showmessage($LANG['editor_success'], $referer);
	}
	else
	{
		$r = $db->get_one("SELECT * FROM ".channel_table('down', $channelid)." WHERE downid=$downid AND username='$_username' AND status!=3 ");
		if(!$r['downid']) showmessage($LANG['right_to_not_edit'], 'goback');
		@extract($r);
		$type_select = type_select('typeid', $LANG['type'], $typeid);
		$category_select = category_select('catid', $LANG['choose_category'], $catid, 'id="catid"');
		$fields = $field->get_form('<tr><td class="td_right"><strong>$title</strong></td><td class="td_left">$input $tool $note</td></tr>');
	}
break;

case 'preview':
	
	$downid or showmessage($LANG['id_not_air'], ' goback'); 
	$r = $db->get_one("SELECT * FROM ".channel_table('down', $channelid)." WHERE downid=$downid AND username='$_username' AND status!=3 ");
	$r['downid'] or showmessage($LANG['check_reservation'], 'goback');
	@extract($r);
	$adddate=date('Y-m-d', $addtime);
	$thumb = imgurl($thumb);
	$CAT = cache_read('category_'.$catid.'.php');
	$catname = $CAT['catname'];
	$urls = explode("\n", $downurls);
	$urls = array_map("trim", $urls);
	$downurls = array();
	$r = array();
	foreach($urls as $k=>$url)
	{
		if($url == '' || !strpos($url, "|")) continue;
		$url = explode("|", $url);
		$r['name'] = $url[0];
		$r['url'] = $url[1];
		$downurls[] = $r;
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

	$downid or showmessage($LANG['id_not_air'], ' goback'); 
	$db->query("DELETE FROM ".channel_table('down', $channelid)." WHERE downid=$downid AND username='$_username' AND status!=3 ");
	if($db->affected_rows()>0)
	{
		showmessage($LANG['delete_success'],$referer);
	}
	else
	{
		showmessage($LANG['failure_delete'], 'goback');
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

	$ordertypes = array('listorder DESC, downid DESC', 'edittime DESC', 'edittime ASC', 'hits DESC', 'hits ASC');

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

	$query="SELECT COUNT(downid) as num FROM ".channel_table('down', $channelid)." WHERE status='$status' AND username='$_username' $sql ";
	$result=$db->query($query);
	$r=$db->fetch_array($result);
	$number=$r["num"];

	$pages=phppages($number, $page, $pagesize);
	$downs = array();
	$query="SELECT * FROM ".channel_table('down', $channelid)." WHERE status='$status' AND username='$_username' $sql ORDER BY $ordertypes[$ordertype] LIMIT $offset,$pagesize ";
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
			$downs[]=$r;
		}
	}
break;
}

$head['title'] = $LANG['information_management'];
$head['keywords'] = $PHPCMS['seo_keywords'];
$head['description'] = $PHPCMS['seo_description'];
include template('down', 'myitem');
?>
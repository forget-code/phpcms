<?php
defined('IN_PHPCMS') or exit('Access Denied');

require PHPCMS_ROOT.'/module/'.$mod.'/include/common.inc.php';

$CHA['enablecontribute'] or showmessage($LANG['not_allowed_to_add_an_article'], 'goback');
$_userid  or showmessage($LANG['please_login'], 'goback');

require PHPCMS_ROOT.'/admin/include/field.class.php';
$field = new field(channel_table('article', $channelid));

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

$articleid = isset($articleid) ? intval($articleid) : 0;
$catid = isset($catid) ? intval($catid) : 0;
if($catid) $CAT = cache_read('category_'.$catid.'.php');

$category_select = category_select('catid', $LANG['please_select'], $catid, 'id="catid"');
$pagesize = $PHPCMS['pagesize'];
$referer = isset($referer) ? $referer : $PHP_REFERER;
$action = isset($action) ? $action : 'manage';
if(!isset($checkcodestr)) $checkcodestr = '';

switch($action){

case 'add':

	if($dosubmit)
	{
		checkcode($checkcodestr, $MOD['check_code'], $PHP_REFERER);
		if(!$catid)	showmessage($LANG['please_choose_categories'], 'goback');
		if(empty($title)) showmessage($LANG['short_title_can_not_be_blank'], 'goback');
		if(empty($content))	showmessage($LANG['content_can_not_be_blank'], 'goback');
		if($CAT['child'] && !$CAT['enableadd']) showmessage($LANG['not_allowed_to_add_an_article'], 'goback');

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

		if($enableaddalways) $status = 3;

		$urlruleid = $CAT['ishtml'] ? $CAT['item_html_urlruleid'] : $CAT['item_php_urlruleid'];

		$query = "INSERT INTO ".channel_table('article',$channelid)."(catid,typeid,title,keywords,introduce,author,copyfrom,thumb,status,username,addtime,editor,edittime,ishtml,urlruleid,htmldir,prefix) VALUES('$catid','$typeid','$title','$keywords','$introduce','$author','$copyfrom','$thumb','$status','$_username','$addtime','$_username','$addtime','$CAT[ishtml]', '$urlruleid','$CAT[item_htmldir]','$CAT[item_prefix]')";
		$db->query($query);
		$articleid = $db->insert_id();
		$field->update("articleid=$articleid");
		$linkurl = item_url('url', $catid, $CAT['ishtml'], $CAT['item_html_urlruleid'], $CAT['item_htmldir'], $CAT['item_prefix'], $articleid, $addtime);
		$db->query("UPDATE ".channel_table('article', $channelid)." SET linkurl='$linkurl' WHERE articleid=$articleid ");
		$db->query("INSERT INTO ".channel_table('article_data', $channelid)." (articleid,content) values('$articleid', '$content') ");
		if($CAT['ishtml'] && $status == 3)
		{
			createhtml('show');
		}
		if($MOD['add_point'] && $status == 3)
		{
			$db->query("update ".TABLE_MEMBER." set point=point+$MOD[add_point] where userid=$_userid");
		}
		showmessage($LANG['add_article_success'], $referer);
	}
	else
	{
		$type_select = type_select('typeid', $LANG['type']);
		$fields = $field->get_form('<tr><td class="td_right"><strong>$title</strong></td><td class="td_left">$input $note</td></tr>');
		$disabled = $CHA['enablecheck'] && !$enableaddalways;
		$status = $disabled ? 1 : 3;
	}
break;

case 'edit':

	$articleid or showmessage($LANG['empty_article_id'], 'goback');
    if($dosubmit)
	{
		checkcode($checkcodestr, $MOD['check_code'], $PHP_REFERER);
		if(!$catid)	showmessage($LANG['please_choose_categories'], 'goback');
		if(empty($title)) showmessage($LANG['short_title_can_not_be_blank'], 'goback');
		if(empty($content))	showmessage($LANG['content_can_not_be_blank'], 'goback');
		if($CAT['child'] && !$CAT['enableadd']) showmessage($LANG['not_allowed_to_add_an_article'], 'goback');

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
		$db->query("UPDATE ".channel_table('article_data', $channelid)." SET content='$content'");
		$query = "UPDATE ".channel_table('article', $channelid)." SET catid='$catid',typeid='$typeid',title='$title',introduce='$introduce',keywords='$keywords',author='$author',copyfrom='$copyfrom',thumb='$thumb',status='$status',editor='$_username',edittime='$PHP_TIME' WHERE articleid=$articleid  AND username='$_username' AND status!=3 ";
		$db->query($query);
		$field->update("articleid=$articleid");
		showmessage($LANG['modify_article_success'], $referer);
	}
	else
	{
		$r = $db->get_one("SELECT * FROM ".channel_table('article', $channelid)." WHERE articleid=$articleid AND username='$_username' AND status!=3 ");
		if(!$r['articleid']) showmessage($LANG['article_not_exists_orother'], 'goback');
		@extract($r);
		@extract($db->get_one("SELECT content FROM ".channel_table('article_data', $channelid)." WHERE articleid=$articleid "));
		$type_select = type_select('typeid', $LANG['type'], $typeid);
		$category_select = category_select('catid', $LANG['please_select'], $catid, 'id="catid"');
		$fields = $field->get_form('<tr><td class="td_right"><strong>$title</strong></td><td class="td_left">$input $note</td></tr>');
		$disabled = $CHA['enablecheck'];
	}
break;

case 'preview':
	
	$articleid or showmessage($LANG['not_allowed_to_add_an_article'], ' goback'); 
	$r = $db->get_one("SELECT * FROM ".channel_table('article', $channelid)." WHERE articleid=$articleid AND username='$_username' ");
	$r['articleid'] or showmessage($LANG['article_can_not_preview'], 'goback');
	@extract($r);
	@extract($db->get_one("SELECT content FROM ".channel_table('article_data', $channelid)." WHERE articleid=$articleid "));
	$adddate=date('Y-m-d', $addtime);
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

	$articleid or showmessage($LANG['empty_article_id'], ' goback'); 
	$db->query("DELETE FROM ".channel_table('article', $channelid)." WHERE articleid=$articleid AND username='$_username' AND status!=3 ");
	if($db->affected_rows()>0)
	{
		showmessage($LANG['delete_article_success'],$referer);
	}
	else
	{
		showmessage($LANG['failure_to_delete_article'], 'goback');
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

	$ordertypes = array('listorder DESC, articleid DESC', 'edittime DESC', 'edittime ASC', 'hits DESC', 'hits ASC');

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

	$query="SELECT COUNT(articleid) as num FROM ".channel_table('article', $channelid)." WHERE status='$status' AND username='$_username' $sql ";
	$result=$db->query($query);
	$r=$db->fetch_array($result);
	$number=$r["num"];

	$pages=phppages($number, $page, $pagesize);
	$articles = array();
	$query="SELECT * FROM ".channel_table('article', $channelid)." WHERE status='$status' AND username='$_username' $sql ORDER BY $ordertypes[$ordertype] LIMIT $offset,$pagesize ";
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
			$articles[]=$r;
		}
	}
break;
}

$head['title'] = $LANG['manage_my_news'];
$head['keywords'] = $PHPCMS['seo_keywords'];
$head['description'] = $PHPCMS['seo_description'];
include template('article', 'myitem');
?>
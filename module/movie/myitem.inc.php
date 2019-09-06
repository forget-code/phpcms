<?php
defined('IN_PHPCMS') or exit('Access Denied');
require PHPCMS_ROOT.'/module/'.$mod.'/include/common.inc.php';
if($CHA['channeldomain'] && strpos($PHP_URL, $CHA['channeldomain'])!==false)
{
   header('Location:'.$PHPCMS['siteurl'].$CHA['channeldir'].'/myitem.php?'.$PHP_QUERYSTRING);
   exit;
}
$CHA['enablecontribute'] or showmessage($LANG['not_allowed_to_add_an_movie'], 'goback');
$_userid  or showmessage($LANG['please_login'], 'goback');

require PHPCMS_ROOT.'/include/field.class.php';
$field = new field(channel_table('movie', $channelid));

require_once PHPCMS_ROOT.'/include/post.func.php';
require_once PHPCMS_ROOT.'/include/formselect.func.php';
require PHPCMS_ROOT.'/include/charset.func.php';
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

$movieid = isset($movieid) ? intval($movieid) : 0;
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
		if(empty($introduce))	showmessage($LANG['introduce_not_empty'], 'goback');
		if(empty($url))	showmessage($LANG['url_not_empty'], 'goback');
		if($CAT['child'] && !$CAT['enableadd']) showmessage($LANG['not_allowed_to_add_an_movie'], 'goback');
		if($CAT['arrgroupid_add'] && strpos($CAT['arrgroupid_add'], "$_groupid") === false) showmessage($LANG['not_allowed_to_add_by_your_group'], 'goback');
		$inputstring=new_htmlspecialchars(array('title'=>$title,'keywords'=>$keywords,'thumb'=>$thumb,'bigthumb'=>$bigthumb));
		extract($inputstring,EXTR_OVERWRITE);
		$introduce = str_safe($introduce);
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
		foreach($url AS $k=>$v)
		{
			$movieurls .= $txt[$k].'|'.$v."^";
		}
		$movieurls = substr($movieurls,0,-1);
		if($letter == '')
		{
			$letter = substr(trim($title),0,2);
			$letter = convert_encoding('gbk','pinyin',$letter);
			$letter = substr($letter,0,1);
		}
		$urlruleid = $CAT['ishtml'] ? $CAT['item_html_urlruleid'] : $CAT['item_php_urlruleid'];
	
	    $field->check_form();

		$query = "INSERT INTO ".channel_table('movie',$channelid)."(`catid`,`typeid`,`title`,`letter`,`onlineview`,`allowdown`,`serverid`,`keywords`,`playerid`,`movieurls`,`introduce`,`bigthumb`,`thumb`,status,username,addtime,editor,edittime,ishtml,urlruleid,htmldir,prefix) VALUES('$catid','$typeid','$title','$letter','$onlineview','$allowdown','$serverid','$keywords','$playerid','$movieurls','$introduce','$bigthumb','$thumb','$status','$_username','$addtime','$_username','$addtime','$CAT[ishtml]', '$urlruleid','$CAT[item_htmldir]','$CAT[item_prefix]')";
		$db->query($query);
		$movieid = $db->insert_id();
		require PHPCMS_ROOT.'/include/attachment.class.php';
		$att = new attachment;
		$att->attachment($movieid, $channelid, $catid);
		$att->add($content);
		$field->update("movieid=$movieid");
		
		$linkurl = item_url('url', $catid, $CAT['ishtml'], $CAT['item_html_urlruleid'], $CAT['item_htmldir'], $CAT['item_prefix'], $movieid, $addtime);
		$db->query("UPDATE ".channel_table('movie', $channelid)." SET linkurl='$linkurl' WHERE movieid=$movieid ");
		
		if($status == 3)
		{
			if(isset($MODULE['pay']) && ($CAT['creditget'] || $MOD['add_point']))
			{
				require_once PHPCMS_ROOT.'/pay/include/pay.func.php';
				$point = $CAT['creditget'] ? $CAT['creditget'] : $MOD['add_point'];
				point_add($_username, $point, $title.'(channelid='.$channelid.',movieid='.$movieid.')');
			}
			require PHPCMS_ROOT.'/include/create_related_html.inc.php';
		}
		showmessage($LANG['movie_submitted_success'],$referer);
	}
	else
	{
		$type_select = type_select('typeid', $LANG['type']);
		$fields = $field->get_form('<tr><td class="td_right"><strong>$title</strong></td><td class="td_left">$input $tool $note</td></tr>');
		$player_select = "<select name='playerid' ><option value='0'>".$LANG['choose_player']."</option>";
		$result = $db->query("SELECT * FROM ".TABLE_MOVIE_PLAYER." WHERE disabled = 1");
		while($r=$db->fetch_array($result))
			{
				if($MOD['playerid'] == $r['playerid'])	$selected = 'selected';
				$player_select .= "<option value='".$r['playerid']."' ".$selected.">".$r['subject']."</option>";
				$selected = '';
			}
		$player_select .= "</select>";
	
		$server_select = "<select name='serverid' ><option value='0'>".$LANG['choose_server']."</option>";
		$result = $db->query("SELECT * FROM ".TABLE_MOVIE_SERVER);
		while($r=$db->fetch_array($result))
			{
				if($MOD['serverid'] == $r['serverid'])	$selected = 'selected';
				$server_select .= "<option value='".$r['serverid']."' ".$selected.">".$r['servername']."|".$r['onlineurl']."</option>";
				$selected = '';
			}
		$server_select .= "</select>";
		$disabled = $CHA['enablecheck'] && !$enableaddalways;
		$status = $disabled ? 1 : 3;
	}
break;

case 'edit':
	$autoselect = intval($autoselect);
	$movieid or showmessage($LANG['empty_movie_id'], 'goback');
    if($dosubmit)
	{
		checkcode($checkcodestr, $MOD['check_code'], $PHP_REFERER);
		if(!$catid)	showmessage($LANG['please_choose_categories'], 'goback');
		if(empty($title)) showmessage($LANG['short_title_can_not_be_blank'], 'goback');
		if(empty($introduce))	showmessage($LANG['introduce_not_empty'], 'goback');
		if($CAT['child'] && !$CAT['enableadd']) showmessage($LANG['not_allowed_to_add_an_movie'], 'goback');
		if($CAT['arrgroupid_add'] && strpos($CAT['arrgroupid_add'], "$_groupid") === false) showmessage($LANG['not_allowed_to_add_by_your_group'], 'goback');
		$inputstring=new_htmlspecialchars(array('title'=>$title,'keywords'=>$keywords,'thumb'=>$thumb,'bigthumb'=>$bigthumb));
		extract($inputstring,EXTR_OVERWRITE);
		$introduce = str_safe($introduce);
		$addtime = $PHP_TIME;
		if($CHA['enablecheck'])
		{
			$status = ($status == 1 ||  $status == 0) ? $status : 1;
		}
		else
		{
			$status = $status == 2 ? 0 : $status;
		}
		foreach($url AS $k=>$v)
		{
			if(!$delSelected[$k])
			$movieurls .= $txt[$k].'|'.$v."^";
		}
		$movieurls = substr($movieurls,0,-1);
		if($letter == '')
		{
			$letter = substr(trim($title),0,2);
			$letter = convert_encoding('gbk','pinyin',$letter);
			$letter = substr($letter,0,1);
		}
		$query = "UPDATE ".channel_table('movie', $channelid)." SET catid='$catid',typeid='$typeid',title='$title',letter='$letter',onlineview='$onlineview',allowdown='$allowdown',serverid='$serverid',keywords='$keywords',playerid='$playerid',movieurls='$movieurls',introduce='$introduce',bigthumb='$bigthumb',thumb='$thumb',status='$status',editor='$_username',edittime='$PHP_TIME',autoselect='$autoselect' WHERE movieid=$movieid  AND username='$_username' AND status!=3 ";
		$db->query($query);
		if($db->affected_rows()>0)
		{
			showmessage($LANG['editor_success'], $referer);
			$field->update("movieid=$movieid");
		}
		else
		{
			showmessage($LANG['failure_editor'], 'goback');
		}
	}
	else
	{
		$r = $db->get_one("SELECT * FROM ".channel_table('movie', $channelid)." WHERE movieid=$movieid AND username='$_username' AND status!=3 ");
		if(!$r['movieid']) showmessage($LANG['movie_not_exist_deleted'], 'goback');
		@extract($r);
		$player_select = "<select name='playerid' ><option value='0'>".$LANG['choose_player']."</option>";
		$result = $db->query("SELECT * FROM ".TABLE_MOVIE_PLAYER." WHERE disabled = 1");
		while($r=$db->fetch_array($result))
			{
				if($playerid == $r['playerid'])	$selected = 'selected';
				$player_select .= "<option value='".$r['playerid']."' ".$selected.">".$r['subject']."</option>";
				$selected = '';
			}
		$player_select .= "</select>";
		
		$server_select = "<select name='serverid' ><option value='0'>".$LANG['choose_server']."</option>";
		$result = $db->query("SELECT * FROM ".TABLE_MOVIE_SERVER);
		while($r=$db->fetch_array($result))
			{
				if($serverid == $r['serverid'])	$selected = 'selected';
				$server_select .= "<option value='".$r['serverid']."' ".$selected.">".$r['servername']."|".$r['onlineurl']."</option>";
				$selected = '';
			}
		$server_select .= "</select>";
		$type_select = type_select('typeid', $LANG['type'], $typeid);
		$category_select = category_select('catid', $LANG['please_select'], $catid, 'id="catid"');
		$fields = $field->get_form('<tr><td class="td_right"><strong>$title</strong></td><td class="td_left">$input $tool $note</td></tr>');
		$disabled = $CHA['enablecheck'];

		$m = explode('^',trim($movieurls));
		$editEndnum = count($m) + 1;
		$delSelectedId = 0;
		foreach($m AS $k)
		{
			$mm = explode('|',$k);
			$movieUrlEdit .= "<input type='text' name='url[]' size=50 value='".$mm[1]."' class='Input' >&nbsp;前台显示<input name='txt[]' type='text' value='".$mm[0]."' size='4' class='Input'> <input type='text' name='delSelected[]' value='0' size='1' id='delSelected".$delSelectedId."'> <a href='###' onclick=\"$('delSelected".$delSelectedId."').value='del'\"><font color='red'>".$LANG['del']."</font></a><BR>";
			$delSelectedId++;
		}
	}
break;

case 'preview':
	
	$movieid or showmessage($LANG['not_allowed_to_add_an_movie'], ' goback'); 
	$r = $db->get_one("SELECT * FROM ".channel_table('movie', $channelid)." WHERE movieid=$movieid AND username='$_username' ");
	$r['movieid'] or showmessage($LANG['movie_can_not_preview'], 'goback');
	@extract($r);
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

	$movieid or showmessage($LANG['empty_movie_id'], ' goback'); 
	$db->query("DELETE FROM ".channel_table('movie', $channelid)." WHERE movieid=$movieid AND username='$_username' AND status!=3 ");
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

	$ordertypes = array('listorder DESC, movieid DESC', 'edittime DESC', 'edittime ASC', 'hits DESC', 'hits ASC');

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

	$query="SELECT COUNT(movieid) as num FROM ".channel_table('movie', $channelid)." WHERE status='$status' AND username='$_username' $sql ";
	$result=$db->query($query);
	$r=$db->fetch_array($result);
	$number=$r["num"];

	$pages=phppages($number, $page, $pagesize);
	$movies = array();
	$query="SELECT * FROM ".channel_table('movie', $channelid)." WHERE status='$status' AND username='$_username' $sql ORDER BY $ordertypes[$ordertype] LIMIT $offset,$pagesize ";
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
			$movies[]=$r;
		}
	}
break;
}

$head['title'] = $LANG['information_management'];
$head['keywords'] = $PHPCMS['seo_keywords'];
$head['description'] = $PHPCMS['seo_description'];
include template('movie', 'myitem');
?>
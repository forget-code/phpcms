<?php 
defined('IN_PHPCMS') or exit('Access Denied');
require PHPCMS_ROOT."/module/".$mod."/include/common.inc.php";
require PHPCMS_ROOT.'/include/field.class.php';
$field = new field(channel_table('movie', $channelid));
if($dosubmit)
	{
		require PHPCMS_ROOT.'/include/charset.func.php';
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
			require PHPCMS_ROOT.'/include/create_related_html.inc.php';
		}
		showmessage($LANG['movie_submitted_success'],$CHA['linkurl'].'contribute.php');
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
		require_once PHPCMS_ROOT."/include/formselect.func.php";
		require PHPCMS_ROOT."/include/tree.class.php";
		$tree = new tree();
		$catid = isset($catid) ? intval($catid) : 0;
		$type_select = type_select('typeid', $LANG['type']);
		$category_select = category_select('catid', $LANG['please_select'], $catid);
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
		$head['title'] = $LANG['add_movie'].'-'.$channelname;
		$head['keywords'] = $LANG['add_movie'].$channelname.','.$PHPCMS['seo_keywords'];
		$head['description'] = $LANG['add_movie'].','.$channelname.','.$PHPCMS['seo_description'];
		include template($mod, 'contribute');
	}
?>
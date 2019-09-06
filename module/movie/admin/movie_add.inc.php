<?php
defined('IN_PHPCMS') or exit('Access Denied');
$catid or showmessage($LANG['id_not_empty'],$referer);
if($CAT['child'] && !$CAT['enableadd'])
{
	showmessage($LANG['disallow_add_movie'],'goback');
}
require PHPCMS_ROOT.'/include/field.class.php';
$field = new field(channel_table('movie', $channelid));
require PHPCMS_ROOT.'/include/attachment.class.php';
$att = new attachment;
require PHPCMS_ROOT.'/include/charset.func.php';
require PHPCMS_ROOT.'/admin/include/position.class.php';
$pos = new position($channelid);

if($dosubmit)
{
	if(empty($movie['title']))
	{
		showmessage($LANG['short_heading_no_space'],'goback');
	}
	if(!is_array($url))	showmessage($LANG['url_no_permit_blank'],'goback');
	if(isset($addkeywords) && $movie['keywords']) update_keywords($movie['keywords'], $channelid);
	$movie['islink'] = isset($movie['islink']) ? 1 : 0;
	$movie['arrgroupidview'] = empty($movie['arrgroupidview']) ? '' : implode(',', $movie['arrgroupidview']);
	$movie['catid'] = $catid;
	$movie['username'] = $movie['editor'] = $movie['checker'] = $_username;
	$movie['urlruleid'] = $movie['ishtml'] ? $html_urlrule : $php_urlrule;
	$movie['addtime'] = $movie['edittime'] = $movie['checktime'] = preg_match('/^([0-9]{4})-([0-9]{1,2})-([0-9]{1,2}) ([0-9]{2}):([0-9]{2}):([0-9]{2})/', $movie['addtime']) ? strtotime($movie['addtime']) : $PHP_TIME;
	foreach($url AS $k=>$v)
	{
		$movie['movieurls'] .= $txt[$k].'|'.$v."^";
	}
	$movie['movieurls'] = substr($movie['movieurls'],0,-1);
	if($movie['letter'] == '')
	{
		$letter = substr(trim($movie['title']),0,2);
		$letter = convert_encoding('gbk','pinyin',$letter);
		$movie['letter'] = substr($letter,0,1);
	}
	if(isset($movie['arrposid']))
	{
		$arrposid = $movie['arrposid'];
		$movie['arrposid'] = ','.implode(',', $arrposid).',';
	}

	$field->check_form();

	$movieid = $d->add($movie);
	if($movieid)
	{
		if($freelink)
		{
			$r = $db->get_one("select title,thumb,linkurl,style from ".channel_table('movie', $channelid)." where movieid='$movieid' ");
			$f = array();
			$f['title'] = $r['title'];
			$f['url'] = linkurl($r['linkurl']);
			$f['image'] = imgurl($r['thumb']);
			$f['style'] = $r['style'];
			add_freelink(trim($freelink), $f);
		}
		$att->attachment($movieid, $channelid, $catid);
		$att->add($movie['introduce']);
		if(isset($arrposid) && $arrposid) $pos->add($movieid, $arrposid);
		$field->update("movieid=$movieid");
		$forward = "?mod=$mod&file=$file&action=add&channelid=$channelid&catid=$catid";
		if($movie['status'] == 3)
		{
			require PHPCMS_ROOT.'/include/create_related_html.inc.php';
		}
		showmessage($LANG['add_movie_success'], $forward);
	}
	else
	{
		showmessage($LANG['add_movie_failure'],'goback');
	}
}
else
{
	$today = date('Y-m-d H:i:s',$PHP_TIME);
	$type_select = type_select('movie[typeid]', $LANG['type_select']);
	$style_edit = style_edit("movie[style]","");
	$keywords_select = keywords_select($channelid);
	$this_category = str_replace("<option value='0'></option>",'',category_select('catid','',$catid));
	$showgroup = showgroup('checkbox','movie[arrgroupidview][]');
	$showskin = showskin('movie[skinid]');
	$showtpl = showtpl($mod,'content','movie[templateid]');
	$html_urlrule = urlrule_select('html_urlrule','html','item',$CAT['item_html_urlruleid']);
	$php_urlrule = urlrule_select('php_urlrule','php','item',$CAT['item_php_urlruleid']);
	$fields = $field->get_form('<tr><td class="tablerow"><strong>$title</strong></td><td class="tablerow">$input $tool $note</td></tr>');
	$position = $pos->checkbox('movie[arrposid][]');
	
	$player_select = "<select name='movie[playerid]' id='playerid'><option value='0'>".$LANG['choose_player']."</option>";
	$result = $db->query("SELECT SQL_CACHE * FROM ".TABLE_MOVIE_PLAYER." WHERE disabled = 1");
	while($r=$db->fetch_array($result))
	{
		if($MOD['playerid'] == $r['playerid'])	$selected = 'selected';
		$player_select .= "<option value='".$r['playerid']."' ".$selected.">".$r['subject']."</option>";
		$selected = '';
	}
	$player_select .= "</select>";
	
	$server_select = "<select name='movie[serverid]' ><option value='0'>".$LANG['choose_server']."</option>";
	$result = $db->query("SELECT SQL_CACHE * FROM ".TABLE_MOVIE_SERVER);
	while($r=$db->fetch_array($result))
	{
		if($MOD['serverid'] == $r['serverid'])	$selected = 'selected';
		$server_select .= "<option value='".$r['serverid']."' ".$selected.">".$r['servername']."|".$r['onlineurl']."</option>";
		$selected = '';
	}
	$server_select .= "</select>";
	include admintpl($mod.'_add');
}
?>
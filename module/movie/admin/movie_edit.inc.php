<?php
defined('IN_PHPCMS') or exit('Access Denied');
$movieid = intval($movieid);
$movieid or showmessage($LANG['id_movie_not_air'],$referer);

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
	$movie['editor'] = $movie['checker'] = $_username;
	$movie['urlruleid'] = $movie['ishtml'] ? $html_urlrule : $php_urlrule;
	$movie['addtime'] = $movie['edittime'] = $movie['checktime'] = preg_match('/^([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})/', $movie['addtime']) ? strtotime($movie['addtime'].' '.date('H:i:s',$PHP_TIME)) : $PHP_TIME;
	if(!$movie['onlineview']) $movie['onlineview'] = 0;
	if(!$movie['allowdown']) $movie['allowdown'] = 0;
	foreach($url AS $k=>$v)
	{
		if(!$delSelected[$k])
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
	else
	{
        $arrposid = array();
		$movie['arrposid'] = '';
	}
	$field->check_form();
	$movieid = $d->edit($movie);
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
		$field->update("movieid=$movieid");
		if($arrposid || $old_arrposid)
		{
			$old_posid_arr = $old_arrposid ? array_filter(explode(',', $old_arrposid)) : array();
			$pos->edit($movieid, $old_posid_arr, $arrposid);
		}
		if($movie['status'] == 3)
		{
			require PHPCMS_ROOT.'/include/create_related_html.inc.php';
		}
		showmessage($LANG['editor_success'], $referer);
	}
	else
	{
		showmessage($LANG['editor_failure'],'goback');
	}
}
else
{
	extract(new_htmlspecialchars($d->get_one()));
	$CAT = cache_read('category_'.$catid.'.php');
	$addtime = date('Y-m-d',$addtime);
	$type_select = type_select('movie[typeid]', $LANG['type_select'], $typeid);
	$style_edit = style_edit("movie[style]", $style);
	$keywords_select = keywords_select($channelid);
	$category_jump = category_select('catid', $LANG['to_other_category'], 0, "onchange=\"if(this.value!=''){location='?mod=$mod&file=$file&action=add&job=$job&channelid=$channelid&catid='+this.value;}\"");
	$showgroup = showgroup('checkbox', 'movie[arrgroupidview][]', $arrgroupidview);
	$showskin = showskin('movie[skinid]', $skinid);
	$showtpl = showtpl($mod,'content', 'movie[templateid]', $templateid);
	$html_urlrule = urlrule_select('html_urlrule', 'html', 'item', $urlruleid);
	$php_urlrule = urlrule_select('php_urlrule', 'php', 'item', $urlruleid);
	$fields = $field->get_form('<tr><td class="tablerow"><strong>$title</strong></td><td class="tablerow">$input $tool $note</td></tr>');
	$position = $pos->checkbox('movie[arrposid][]', $arrposid);
	
	$player_select = "<select name='movie[playerid]' ><option value='0'>".$LANG['choose_player']."</option>";
	$result = $db->query("SELECT * FROM ".TABLE_MOVIE_PLAYER." WHERE disabled = 1");
	while($r=$db->fetch_array($result))
		{
			if($playerid == $r['playerid'])	$selected = 'selected';
			$player_select .= "<option value='".$r['playerid']."' ".$selected.">".$r['subject']."</option>";
			$selected = '';
		}
	$player_select .= "</select>";
	$server_select = "<select name='movie[serverid]' ><option value='0'>".$LANG['choose_server']."</option>";
	$result = $db->query("SELECT * FROM ".TABLE_MOVIE_SERVER);
	while($r=$db->fetch_array($result))
		{
			if($serverid == $r['serverid'])	$selected = 'selected';
			$server_select .= "<option value='".$r['serverid']."' ".$selected.">".$r['servername']."|".$r['onlineurl']."</option>";
			$selected = '';
		}
	$server_select .= "</select>";
	$m = explode('^',trim($movieurls));
	$editEndnum = count($m) + 1;
	$delSelectedId = 0;
	foreach($m AS $k)
	{
		$mm = explode('|',$k);
		$movieUrlEdit .= "<input type='text' name='url[]' size=50 value='".$mm[1]."' class='Input' >&nbsp;前台显示<input name='txt[]' type='text' value='".$mm[0]."' size='4' class='Input'> <input type='text' name='delSelected[]' value='0' size='1' id='delSelected".$delSelectedId."'> <a href='###' onclick=\"$('delSelected".$delSelectedId."').value='del'\"><font color='red'>".$LANG['del']."</font></a><BR>";
		$delSelectedId++;
	}
	include admintpl($mod.'_edit');
}
?>
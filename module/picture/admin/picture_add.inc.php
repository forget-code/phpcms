<?php
defined('IN_PHPCMS') or exit('Access Denied');
$catid or showmessage($LANG['category_id_not_null'],$referer);
if($CAT['child'] && !$CAT['enableadd'])
{
	showmessage($LANG['appoint_category_not_allowed_add_picture'],'goback');
}
require PHPCMS_ROOT.'/include/field.class.php';
$field = new field(channel_table('picture', $channelid));

require PHPCMS_ROOT.'/admin/include/position.class.php';
$pos = new position($channelid);

if($dosubmit)
{
	if(empty($picture['title']))
	{
		showmessage($LANG['sorry_short_title_not_null'],'goback');
	}
	if(empty($picture['pictureurls']))
	{
		showmessage($LANG['sorry_picture_url_not_null'],'goback');
	}
	$picture['pictureurls'] = trim($picture['pictureurls']);
	$pictureurls = explode("\n", $picture['pictureurls']);
	$nums = count($pictureurls);
	$picture['pictureurls'] = '';
	foreach($pictureurls as $k => $pictureurl)
	{
		if(empty($pictureurl) || strlen($pictureurl)<10) continue;
		preg_match("/.+\|(.*)(\[d\])/", $pictureurl, $m);
		if(!empty($m) && !strpos($pictureurl, "://"))
		{
			$fileurl = PHPCMS_ROOT.'/'.$CHA['channeldir'].'/'.$MOD['upload_dir'].'/'.$m[1];
			@unlink($fileurl);
			@unlink(dirname($fileurl).'/thumb_'.basename($fileurl));
		}
		else
		{
			$picture['pictureurls'] .= $pictureurl."\n";
		}
	}

	if(empty($picture['pictureurls']))
	{
		showmessage($LANG['sorry_picture_url_not_null'],'goback');
	}
	if(isset($addkeywords) && $picture['keywords']) update_keywords($picture['keywords'], $channelid);
	if(isset($addauthor) && $picture['author']) update_author($picture['author'], $channelid);
	if(isset($addcopyfrom) && $picture['copyfrom']) update_copyfrom($picture['copyfrom'], $channelid);
	$picture['islink'] = isset($picture['islink']) ? 1 : 0;
	$picture['arrgroupidview'] = empty($picture['arrgroupidview']) ? '' : implode(',', $picture['arrgroupidview']);
	$picture['catid'] = $catid;
	$picture['username'] = $picture['editor'] = $picture['checker'] = $_username;
	$picture['urlruleid'] = $picture['ishtml'] ? $html_urlrule : $php_urlrule;
	$picture['addtime'] = $picture['edittime'] = $picture['checktime'] = preg_match('/^([0-9]{4})-([0-9]{1,2})-([0-9]{1,2}) ([0-9]{2}):([0-9]{2}):([0-9]{2})/', $picture['addtime']) ? strtotime($picture['addtime']) : $PHP_TIME;
	if(isset($picture['arrposid']))
	{
		$arrposid = $picture['arrposid'];
		$picture['arrposid'] = ','.implode(',', $arrposid).',';
	}

	$field->check_form();

	$pictureid = $pic->add($picture);
	if($pictureid)
	{
		if($freelink)
		{
			$r = $db->get_one("select title,thumb,linkurl,style from ".channel_table('picture', $channelid)." where pictureid='$pictureid' ");
			$f = array();
			$f['title'] = $r['title'];
			$f['url'] = linkurl($r['linkurl']);
			$f['image'] = imgurl($r['thumb']);
			$f['style'] = $r['style'];
			add_freelink(trim($freelink), $f);
		}
		require PHPCMS_ROOT.'/include/attachment.class.php';
		$att = new attachment;
		$att->attachment($pictureid, $channelid, $catid);
		$att->add($picture['introduce']);

		if(isset($arrposid) && $arrposid) $pos->add($pictureid, $arrposid);

		$field->update("pictureid=$pictureid");
		$forward = "?mod=$mod&file=$file&action=add&channelid=$channelid&catid=$catid";
		if($picture['status'] == 3)
		{
			require PHPCMS_ROOT.'/include/create_related_html.inc.php';
		}
		showmessage($LANG['picture_add_success'], $forward);
	}
	else
	{
		showmessage($LANG['fail_add_picture'],'goback');
	}
}
else
{
	$today=date('Y-m-d H:i:s',$PHP_TIME);
	$type_select = type_select('picture[typeid]', $LANG['type']);
	$style_edit = style_edit("picture[style]","");
	$keywords_select = keywords_select($channelid);
	$author_select = author_select($channelid);
	$copyfrom_select = copyfrom_select($channelid);
	$this_category = str_replace("<option value='0'></option>",'',category_select('catid','',$catid));
	$showgroup = showgroup('checkbox','picture[arrgroupidview][]');
	$showskin = showskin('picture[skinid]');
	$showtpl = showtpl($mod,'content','picture[templateid]');
	$html_urlrule = urlrule_select('html_urlrule','html','item',$CAT['item_html_urlruleid']);
	$php_urlrule = urlrule_select('php_urlrule','php','item',$CAT['item_php_urlruleid']);
	$fields = $field->get_form('<tr><td class="tablerow"><strong>$title</strong></td><td class="tablerow">$input $tool $note</td></tr>');
	$position = $pos->checkbox('picture[arrposid][]');
	include admintpl($mod.'_add');
}
?>
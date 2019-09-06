<?php
defined('IN_PHPCMS') or exit('Access Denied');

$pictureid = intval($pictureid);
$pictureid or showmessage($LANG['picture_id_not_null'],$referer);

require PHPCMS_ROOT.'/include/field.class.php';
$field = new field(channel_table('picture', $channelid));

require PHPCMS_ROOT.'/admin/include/position.class.php';
$pos = new position($channelid);

$referer = isset($referer) ? $referer : "?mod=$mod&file=$file&action=manage&channelid=$channelid";
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
	if($ishtmled) $pic->delete($pictureid, 1);//先删除已生成的文件
	$picture['islink'] = isset($picture['islink']) ? 1 : 0;
	$picture['arrgroupidview'] = empty($picture['arrgroupidview']) ? '' : implode(',',$picture['arrgroupidview']);
	$picture['catid'] = $catid;
	$picture['editor'] = $_username;
	$picture['urlruleid'] = $picture['ishtml'] ? $html_urlrule : $php_urlrule;
	$picture['addtime'] = preg_match('/^([0-9]{4})-([0-9]{1,2})-([0-9]{1,2}) ([0-9]{2}):([0-9]{2}):([0-9]{2})/', $picture['addtime']) ? strtotime($picture['addtime']) : $PHP_TIME;
	$picture['edittime'] = $PHP_TIME;
	if(isset($picture['arrposid']))
	{
		$arrposid = $picture['arrposid'];
		$picture['arrposid'] = ','.implode(',', $arrposid).',';
	}
	else
	{
        $arrposid = array();
		$picture['arrposid'] = '';
	}

	$field->check_form();

	if($pic->edit($picture))
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

		if($arrposid || $old_arrposid)
		{
			$old_posid_arr = $old_arrposid ? array_filter(explode(',', $old_arrposid)) : array();
			$pos->edit($pictureid, $old_posid_arr, $arrposid);
		}

		$field->update("pictureid=$pictureid");
		if($picture['status'] == 3)
		{
			require PHPCMS_ROOT.'/include/create_related_html.inc.php';
		}
		showmessage($LANG['picture_edit_success'], $referer);
	}
	else
	{
		showmessage($LANG['picture_edit_failure']);
	}
}
else
{
	extract(new_htmlspecialchars($pic->get_one()));
	$pictureurls = trim($pictureurls);
	$CAT = cache_read("category_$catid.php");
	$addtime = date('Y-m-d H:i:s',$addtime);
	$type_select = type_select('picture[typeid]', $LANG['type'], $typeid);
	$style_edit = style_edit("picture[style]", $style);
	$keywords_select = keywords_select($channelid);
	$author_select = author_select($channelid);
	$copyfrom_select = copyfrom_select($channelid);
	$category_jump = category_select('catid', $LANG['switch_to_other_category'], 0, "onchange=\"if(this.value!=''){location='?mod=$mod&file=$file&action=add&job=$job&channelid=$channelid&catid='+this.value;}\"");
	$showgroup = showgroup('checkbox', 'picture[arrgroupidview][]', $arrgroupidview);
	$showskin = showskin('picture[skinid]', $skinid);
	$showtpl = showtpl($mod,'content', 'picture[templateid]', $templateid);
	$html_urlrule = urlrule_select('html_urlrule', 'html', 'item', $urlruleid);
	$php_urlrule = urlrule_select('php_urlrule', 'php', 'item', $urlruleid);
	$fields = $field->get_form('<tr><td class="tablerow"><strong>$title</strong></td><td class="tablerow">$input $tool $note</td></tr>');
	$position = $pos->checkbox('picture[arrposid][]', $arrposid);
	include admintpl($mod.'_edit');
}
?>
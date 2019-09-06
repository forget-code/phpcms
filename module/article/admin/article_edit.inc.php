<?php
defined('IN_PHPCMS') or exit('Access Denied');
set_time_limit(0);
$articleid = intval($articleid);
$articleid or showmessage($LANG['empty_article_id'], $referer);

require PHPCMS_ROOT.'/include/field.class.php';
$field = new field(channel_table('article', $channelid));

require PHPCMS_ROOT.'/include/attachment.class.php';
$att = new attachment;

require PHPCMS_ROOT.'/admin/include/position.class.php';
$pos = new position($channelid);

$referer = isset($referer) ? $referer : "?mod=$mod&file=$file&action=manage&channelid=$channelid";

if($dosubmit)
{
	if(empty($article['title']))
	{
		showmessage($LANG['short_title_can_not_be_blank'],'goback');
	}
	if(!isset($article['islink']) && empty($article['content']))
	{
		showmessage($LANG['content_can_not_be_blank'],'goback');
	}
	if(isset($addkeywords) && $article['keywords']) update_keywords($article['keywords'], $channelid);
	if(isset($addauthor) && $article['author']) update_author($article['author'], $channelid);
	if(isset($addcopyfrom) && $article['copyfrom']) update_copyfrom($article['copyfrom'], $channelid);
	if(isset($save_remotepic)) 
	{
		require PHPCMS_ROOT.'/include/get_remotefiles.func.php';
		$article['content'] = get_remotepics($article['content'], $CHA['channeldir']."/".$CHA['uploaddir']);
	}
	if($ishtmled) $art->delete($articleid, 1);

	$introcude_length = isset($introcude_length) ? intval($introcude_length) : 0;
	if(empty($article['introduce']) && isset($add_introduce) && $introcude_length) $article['introduce'] = str_cut(strip_tags($article['content']), $introcude_length);
	if(!isset($article['islink']) && empty($article['thumb']) && isset($auto_thumb) && $auto_thumb_no)
	{
		if(intval($auto_thumb_no) < 1) $auto_thumb_no = 1;
		$c = stripslashes($article['content']);
		preg_match_all("/<img[^>]*src=\"([^\"]+)\"/i", $c, $m);
		if(isset($m[1][$auto_thumb_no-1]))
		{
			$thumb = $m[1][$auto_thumb_no-1];
			$thumb = str_replace('http://'.$PHP_DOMAIN, '' , $thumb);//For PHPCMS Editor
			if($PHPCMS['enablethumb'] && !strpos($thumb, "://"))
			{
				require_once PHPCMS_ROOT."/include/watermark.class.php";
				$thumb = substr($thumb, strlen(PHPCMS_PATH));
				$newthumb = str_replace(basename($thumb), "thumb_".basename($thumb), $thumb);
				$width = $MOD['thumb_width'] ? $MOD['thumb_width'] : $PHPCMS['thumb_width'];
				$height = $MOD['thumb_height'] ? $MOD['thumb_height'] : $PHPCMS['thumb_height'];
				$wm = new watermark(PHPCMS_ROOT.'/'.$thumb, 10, $PHPCMS['water_pos']);
				$wm->thumb($width, $height, PHPCMS_ROOT.'/'.$newthumb);
				$article['thumb'] = $newthumb;
			}
			else
			{
				$article['thumb'] = strpos($thumb, "://") ? $thumb : substr($thumb, strlen(PHPCMS_PATH));
			}
		}
	}

    $article['showcommentlink'] = isset($article['showcommentlink']) ? $article['showcommentlink'] : 0;
	$article['islink'] = isset($article['islink']) ? 1 : 0;
	$article['arrgroupidview'] = empty($article['arrgroupidview']) ? '' : implode(',',$article['arrgroupidview']);
	$article['catid'] = $catid;
	$article['editor'] = $_username;
	$article['urlruleid'] = $article['ishtml'] ? $html_urlrule : $php_urlrule;
	$article['addtime'] = preg_match('/^([0-9]{4})-([0-9]{1,2})-([0-9]{1,2}) ([0-9]{2}):([0-9]{2}):([0-9]{2})/', $article['addtime']) ? strtotime($article['addtime']) : $PHP_TIME;	
	$article['edittime'] = $PHP_TIME;
	if(isset($article['arrposid']))
	{
		$arrposid = $article['arrposid'];
		$article['arrposid'] = ','.implode(',', $arrposid).',';
	}
	else
	{
        $arrposid = array();
		$article['arrposid'] = '';
	}

	$field->check_form();

	if($art->edit($article))
	{
		if($freelink)
		{
			$r = $db->get_one("select title,thumb,linkurl,style from ".channel_table('article', $channelid)." where articleid='$articleid' ");
			$f = array();
			$f['title'] = $r['title'];
			$f['url'] = linkurl($r['linkurl']);
			$f['image'] = imgurl($r['thumb']);
			$f['style'] = $r['style'];
			add_freelink(trim($freelink), $f);
		}
		$att->attachment($articleid, $channelid, $catid);
		$att->add($article['content']);

		$field->update("articleid=$articleid");

		if($arrposid || $old_arrposid)
		{
			$old_posid_arr = $old_arrposid ? array_filter(explode(',', $old_arrposid)) : array();
			$pos->edit($articleid, $old_posid_arr, $arrposid);
		}

		if($article['status'] == 3)
		{
			require PHPCMS_ROOT.'/include/create_related_html.inc.php';
		}
		showmessage($LANG['modify_article_success'], $referer);
	}
	else
	{
		showmessage($LANG['modify_article_failure'],'goback');
	}
}
else
{
	@extract(new_htmlspecialchars($art->get_one()));
	$CAT = cache_read("category_$catid.php");
	$addtime = date('Y-m-d H:i:s',$addtime);
	$type_select = type_select('article[typeid]', $LANG['type'], $typeid);
	$style_edit = style_edit("article[style]", $style);
	$keywords_select = keywords_select($channelid);
	$author_select = author_select($channelid);
	$copyfrom_select = copyfrom_select($channelid);
	$category_jump = category_select('catid', $LANG['change_category_add_article'], 0, "onchange=\"if(this.value!=''){location='?mod=$mod&file=$file&action=add&job=$job&channelid=$channelid&catid='+this.value;}\"");
	$showgroup = showgroup('checkbox', 'article[arrgroupidview][]', $arrgroupidview);
	$showskin = showskin('article[skinid]', $skinid);
	$showtpl = showtpl($mod,'content', 'article[templateid]', $templateid);
	$html_urlrule = urlrule_select('html_urlrule', 'html', 'item', $urlruleid);
	$php_urlrule = urlrule_select('php_urlrule', 'php', 'item', $urlruleid);
	$fields = $field->get_form('<tr><td class="tablerow"><strong>$title</strong></td><td class="tablerow">$input $tool $note</td></tr>');
	$position = $pos->checkbox('article[arrposid][]', $arrposid);
	
	include admintpl($mod.'_edit');
}
?>
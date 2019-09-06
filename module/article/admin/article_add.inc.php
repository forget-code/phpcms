<?php
defined('IN_PHPCMS') or exit('Access Denied');
set_time_limit(0);
$catid or showmessage($LANG['empty_category_id'],$referer);
if($CAT['child'] && !$CAT['enableadd'])
{
	showmessage($LANG['not_allowed_to_add_an_artcile'],'goback');
}

require PHPCMS_ROOT.'/include/field.class.php';
$field = new field(channel_table('article', $channelid));

require PHPCMS_ROOT.'/admin/include/position.class.php';
$pos = new position($channelid);

require PHPCMS_ROOT.'/include/attachment.class.php';
$att = new attachment;

if($dosubmit)
{
	if(empty($article['title'])) showmessage($LANG['short_title_can_not_be_blank']);
	if(!isset($article['islink']) && empty($article['content'])) showmessage($LANG['content_can_not_be_blank'],'goback');
	if(isset($addkeywords) && $article['keywords']) update_keywords($article['keywords'], $channelid);
	if(isset($addauthor) && $article['author']) update_author($article['author'], $channelid);
	if(isset($addcopyfrom) && $article['copyfrom']) update_copyfrom($article['copyfrom'], $channelid);

	if(isset($save_remotepic))
	{
		require PHPCMS_ROOT.'/include/get_remotefiles.func.php';
		$article['content'] = get_remotepics($article['content'], $PHPCMS['uploaddir'].'/'.$CHA['channeldir'].'/'.$CHA['uploaddir']);
	}

	$introcude_length = isset($introcude_length) ? intval($introcude_length) : 0;
	if(!isset($article['islink']) && empty($article['introduce']) && isset($add_introduce) && $introcude_length) $article['introduce'] = str_cut(strip_tags($article['content']), $introcude_length);

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

	$article['islink'] = isset($article['islink']) ? 1 : 0;
	$article['arrgroupidview'] = empty($article['arrgroupidview']) ? '' : implode(',',$article['arrgroupidview']);
	$article['username'] = $article['editor'] = $article['checker'] = $_username;
	$article['urlruleid'] = $article['ishtml'] ? $html_urlrule : $php_urlrule;
	$article['addtime'] = $article['edittime'] = $article['checktime'] = preg_match('/^([0-9]{4})-([0-9]{1,2})-([0-9]{1,2}) ([0-9]{2}):([0-9]{2}):([0-9]{2})/', $article['addtime']) ? strtotime($article['addtime']) : $PHP_TIME;	
	if(isset($article['arrposid']))
	{
		$arrposid = $article['arrposid'];
		$article['arrposid'] = ','.implode(',', $arrposid).',';
	}
	$article['catid'] = $catid;
	$field->check_form();

	$articleid = $art->add($article);

	if($articleid)
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
		if(isset($arrposid) && $arrposid) $pos->add($articleid, $arrposid);

		$field->update("articleid=$articleid");
		$forward = "?mod=$mod&file=$file&action=add&channelid=$channelid&catid=$article[catid]";
		if($article['status'] == 3)
		{
			require PHPCMS_ROOT.'/include/create_related_html.inc.php';
		}
		showmessage($LANG['add_article_success'], $forward);
	}
	else
	{
		showmessage($LANG['add_article_failure'],'goback');
	}
}
else
{
	$today=date('Y-m-d H:i:s',$PHP_TIME);
	$type_select = type_select('article[typeid]', $LANG['type']);
	$style_edit = style_edit('article[style]','');
	$keywords_select = keywords_select($channelid);
	$author_select = author_select($channelid);
	$copyfrom_select = copyfrom_select($channelid);
	$this_category = str_replace("<option value='0'></option>",'',category_select('catid','',$catid));
	$showgroup = showgroup('checkbox','article[arrgroupidview][]');
	$showskin = showskin('article[skinid]');
	$showtpl = showtpl($mod,'content','article[templateid]');
	$html_urlrule = urlrule_select('html_urlrule','html','item',$CAT['item_html_urlruleid']);
	$php_urlrule = urlrule_select('php_urlrule','php','item',$CAT['item_php_urlruleid']);
	$fields = $field->get_form('<tr><td class="tablerow"><strong>$title</strong></td><td class="tablerow">$input $tool $note</td></tr>');
	$position = $pos->checkbox('article[arrposid][]');
	include admintpl($mod.'_add');
}
?>
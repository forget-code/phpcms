<?php
defined('IN_PHPCMS') or exit('Access Denied');
$downid = intval($downid);
$downid or showmessage($LANG['id_download_not_air'],$referer);

require PHPCMS_ROOT.'/include/field.class.php';
$field = new field(channel_table('down', $channelid));

require PHPCMS_ROOT.'/admin/include/position.class.php';
$pos = new position($channelid);

$referer = isset($referer) ? $referer : "?mod=$mod&file=$file&action=manage&channelid=$channelid";
if($dosubmit)
{
	if(empty($down['title']))
	{
		showmessage($LANG['title_no_air'],'goback');
	}
	if(empty($down['downurls']))
	{
		showmessage($LANG['downloaded_no_air'],'goback');
	}
	$down['downurls'] = trim($down['downurls']);
	if($down['mode'] == 0)
	{
		$downurls = explode("\n", $down['downurls']);
		$nums = count($downurls);
		$down['downurls'] = '';
		foreach($downurls as $k => $downurl)
		{
			if(empty($downurl) || strlen($downurl)<10) continue;
			preg_match("/.+\|(.*)(\[d\])/", $downurl, $m);
			if(!empty($m))
			{
				if(file_exists(PHPCMS_ROOT.'/'.$m[1])) @unlink(PHPCMS_ROOT.'/'.$m[1]);
			}
			else
			{
				$down['downurls'] .= $downurl."\n";
			}
			
		}
	}
	if(empty($down['downurls']))
	{
		showmessage($LANG['downloaded_no_air'],'goback');
	}
	if(isset($addkeywords) && $down['keywords']) update_keywords($down['keywords'], $channelid);
	if($ishtmled) $d->delete($downid, 1);
	$down['islink'] = isset($down['islink']) ? 1 : 0;
	$down['arrgroupidview'] = empty($down['arrgroupidview']) ? '' : implode(',',$down['arrgroupidview']);
	$down['catid'] = $catid;
	$down['editor'] = $_username;
	$down['urlruleid'] = $down['ishtml'] ? $html_urlrule : $php_urlrule;
	$down['addtime'] = preg_match('/^([0-9]{4})-([0-9]{1,2})-([0-9]{1,2}) ([0-9]{2}):([0-9]{2}):([0-9]{2})/', $down['addtime']) ? strtotime($down['addtime']) : $PHP_TIME;
	$down['edittime'] = $PHP_TIME;
	if(isset($down['arrposid']))
	{
		$arrposid = $down['arrposid'];
		$down['arrposid'] = ','.implode(',', $arrposid).',';
	}
	else
	{
        $arrposid = array();
		$down['arrposid'] = '';
	}

	$field->check_form();

	if($d->edit($down))
	{
		if($freelink)
		{
			$r = $db->get_one("select title,thumb,linkurl,style from ".channel_table('down', $channelid)." where downid='$downid' ");
			$f = array();
			$f['title'] = $r['title'];
			$f['url'] = linkurl($r['linkurl']);
			$f['image'] = imgurl($r['thumb']);
			$f['style'] = $r['style'];
			add_freelink(trim($freelink), $f);
		}
		require PHPCMS_ROOT.'/include/attachment.class.php';
		$att = new attachment;
		$att->attachment($downid, $channelid, $catid);
		$att->add($down['introduce']);

		if($arrposid || $old_arrposid)
		{
			$old_posid_arr = $old_arrposid ? array_filter(explode(',', $old_arrposid)) : array();
			$pos->edit($downid, $old_posid_arr, $arrposid);
		}

		$field->update("downid=$downid");
		if($down['status'] == 3)
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
	if(isset($_mode)) $mode = $_mode;
	$downurls = trim($downurls);
	if($mode==1)
	{
		if(strpos($downurls, "\n"))
		{
			$downurl = explode("\n", $downurls);
			$downurls = $downurl[0];
			unset($downurl);
			if(strpos($downurls, "|")) $downurls = substr($downurls, strpos($downurls, "|")+1, strlen($downurls));
		}

	}
	$CAT = cache_read('category_'.$catid.'.php');
	$addtime = date('Y-m-d H:i:s',$addtime);
	$type_select = type_select('down[typeid]', $LANG['type'], $typeid);
	$style_edit = style_edit("down[style]", $style);
	$keywords_select = keywords_select($channelid);
	$category_jump = category_select('catid', $LANG['to_other_category'], 0, "onchange=\"if(this.value!=''){location='?mod=$mod&file=$file&action=add&job=$job&channelid=$channelid&catid='+this.value;}\"");
	$showgroup = showgroup('checkbox', 'down[arrgroupidview][]', $arrgroupidview);
	$showskin = showskin('down[skinid]', $skinid);
	$showtpl = showtpl($mod,'content', 'down[templateid]', $templateid);
	$html_urlrule = urlrule_select('html_urlrule', 'html', 'item', $urlruleid);
	$php_urlrule = urlrule_select('php_urlrule', 'php', 'item', $urlruleid);
	$fields = $field->get_form('<tr><td class="tablerow"><strong>$title</strong></td><td class="tablerow">$input $tool $note</td></tr>');
	$position = $pos->checkbox('down[arrposid][]', $arrposid);
	include admintpl($mod.'_edit');
}
?>
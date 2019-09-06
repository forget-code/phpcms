<?php
defined('IN_PHPCMS') or exit('Access Denied');

$catid or showmessage($LANG['id_not_empty'], $referer);
if($CAT['child'] && !$CAT['enableadd'])
{
	showmessage($LANG['disallow_add_download'],'goback');
}
require PHPCMS_ROOT.'/include/field.class.php';
$field = new field(channel_table('down', $channelid));

require PHPCMS_ROOT.'/admin/include/position.class.php';
$pos = new position($channelid);

$mode = isset($mode)? $mode : $MOD['mode'];
if($dosubmit)
{
	if(empty($down['title']))
	{
		showmessage($LANG['short_heading_no_space'],'goback');
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
	$down['islink'] = isset($down['islink']) ? 1 : 0;
	$down['arrgroupidview'] = empty($down['arrgroupidview']) ? '' : implode(',', $down['arrgroupidview']);
	$down['catid'] = $catid;
	$down['filesize'] = $down['filesize'] ? ($filesizetype ? $down['filesize'].' '.$filesizetype : bytes2x($down['filesize'])) : $LANG['unknown'];
	$down['username'] = $down['editor'] = $down['checker'] = $_username;
	$down['urlruleid'] = $down['ishtml'] ? $html_urlrule : $php_urlrule;
	$down['addtime'] = $down['edittime'] = $down['checktime'] = preg_match('/^([0-9]{4})-([0-9]{1,2})-([0-9]{1,2}) ([0-9]{2}):([0-9]{2}):([0-9]{2})/', $down['addtime']) ? strtotime($down['addtime']) : $PHP_TIME;
	if($down['homepage'] =='' || $down['homepage'] == 'http://www.') $down['homepage'] = '';
	if(isset($down['arrposid']))
	{
		$arrposid = $down['arrposid'];
		$down['arrposid'] = ','.implode(',', $arrposid).',';
	}
	$field->check_form();

	$downid = $d->add($down);
	if($downid)
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

		if(isset($arrposid) && $arrposid) $pos->add($downid, $arrposid);

		$field->update("downid=$downid");
		$forward = "?mod=$mod&file=$file&action=add&channelid=$channelid&catid=$catid&mode=$mode";
		if($down['status'] == 3)
		{
			require PHPCMS_ROOT.'/include/create_related_html.inc.php';
		}
		showmessage($LANG['add_downloadeds_success'], $forward);
	}
	else
	{
		showmessage($LANG['add_downloadeds_failure'],'goback');
	}
}
else
{
	$today=date('Y-m-d H:i:s',$PHP_TIME);
	$type_select = type_select('down[typeid]', $LANG['type']);
	$style_edit = style_edit("down[style]","");
	$keywords_select = keywords_select($channelid);
	$this_category = str_replace("<option value='0'></option>",'',category_select('catid','',$catid));
	$showgroup = showgroup('checkbox','down[arrgroupidview][]');
	$showskin = showskin('down[skinid]');
	$showtpl = showtpl($mod,'content','down[templateid]');
	$html_urlrule = urlrule_select('html_urlrule','html','item',$CAT['item_html_urlruleid']);
	$php_urlrule = urlrule_select('php_urlrule','php','item',$CAT['item_php_urlruleid']);
	$fields = $field->get_form('<tr><td class="tablerow"><strong>$title</strong></td><td class="tablerow">$input $tool $note</td></tr>');
	$position = $pos->checkbox('down[arrposid][]');
	include admintpl($mod.'_add');
}
?>
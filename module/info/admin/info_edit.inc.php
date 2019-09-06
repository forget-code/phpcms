<?php
defined('IN_PHPCMS') or exit('Access Denied');
$infoid = intval($infoid);
$infoid or showmessage($LANG['info_id_not_null'],$referer);

$AREA = cache_read('areas_'.$channelid.'.php');

require PHPCMS_ROOT.'/include/field.class.php';
$field = new field(channel_table('info', $channelid));

require PHPCMS_ROOT.'/admin/include/position.class.php';
$pos = new position($channelid);

$referer = isset($referer) ? $referer : "?mod=$mod&file=$file&action=manage&channelid=$channelid";
if($dosubmit)
{
	if(empty($info['title']))
	{
		showmessage($LANG['sorry_short_title_not_null'],'goback');
	}
	if(isset($addkeywords) && $info['keywords']) update_keywords($info['keywords'], $channelid);
	if($ishtmled) $inf->delete($infoid, 1);//先删除已生成的文件
	$info['islink'] = isset($info['islink']) ? 1 : 0;
	$info['arrgroupidview'] = empty($info['arrgroupidview']) ? '' : implode(',',$info['arrgroupidview']);
	$info['catid'] = $catid;
	$info['ip'] = $PHP_IP;
	$info['editor'] = $_username;
	$info['urlruleid'] = $info['ishtml'] ? $html_urlrule : $php_urlrule;
	$info['addtime'] = preg_match('/^([0-9]{4})-([0-9]{1,2})-([0-9]{1,2}) ([0-9]{2}):([0-9]{2}):([0-9]{2})/', $info['addtime']) ? strtotime($info['addtime']) : $PHP_TIME;
	$info['endtime'] = preg_match('/^([0-9]{4})-([0-9]{1,2})-([0-9]{1,2}) ([0-9]{2}):([0-9]{2}):([0-9]{2})/', $info['endtime']) ? strtotime($info['endtime']) : 0;
	$info['edittime'] = $PHP_TIME;
	if(isset($info['arrposid']))
	{
		$arrposid = $info['arrposid'];
		$info['arrposid'] = ','.implode(',', $arrposid).',';
	}
	else
	{
        $arrposid = array();
		$info['arrposid'] = '';
	}

	$field->check_form();

	if($inf->edit($info))
	{
		if($freelink)
		{
			$r = $db->get_one("select title,thumb,linkurl,style from ".channel_table('info', $channelid)." where infoid='$infoid' ");
			$f = array();
			$f['title'] = $r['title'];
			$f['url'] = linkurl($r['linkurl']);
			$f['image'] = imgurl($r['thumb']);
			$f['style'] = $r['style'];
			add_freelink(trim($freelink), $f);
		}
		require PHPCMS_ROOT.'/include/attachment.class.php';
		$att = new attachment;
		$att->attachment($infoid, $channelid, $catid);
		$att->add($info['content']);

		if($arrposid || $old_arrposid)
		{
			$old_posid_arr = $old_arrposid ? array_filter(explode(',', $old_arrposid)) : array();
			$pos->edit($infoid, $old_posid_arr, $arrposid);
		}

		$field->update("infoid=$infoid");
		if($info['status'] == 3)
		{
			require PHPCMS_ROOT.'/include/create_related_html.inc.php';
		}
		showmessage($LANG['info_edit_success'], $referer);
	}
	else
	{
		showmessage($LANG['info_edit_failure'],'goback');
	}
}
else
{
	extract(new_htmlspecialchars($inf->get_one()));
	$CAT = cache_read("category_$catid.php");
	$addtime = date('Y-m-d H:i:s',$addtime);
	$endtime = $endtime ? date('Y-m-d H:i:s',$endtime) : '';
	$type_select = type_select('info[typeid]', $LANG['type'], $typeid);
	$style_edit = style_edit("info[style]", $style);
	$keywords_select = keywords_select($channelid);
	$category_jump = category_select('catid', $LANG['switch_to_other_category'], 0, "onchange=\"if(this.value!=''){location='?mod=$mod&file=$file&action=add&job=$job&channelid=$channelid&catid='+this.value;}\"");
	$showgroup = showgroup('checkbox', 'info[arrgroupidview][]', $arrgroupidview);
	$showskin = showskin('info[skinid]', $skinid);
	$showtpl = showtpl($mod,'content', 'info[templateid]', $templateid);
	$html_urlrule = urlrule_select('html_urlrule', 'html', 'item', $urlruleid);
	$php_urlrule = urlrule_select('php_urlrule', 'php', 'item', $urlruleid);
	$fields = $field->get_form('<tr><td class="tablerow"><strong>$title</strong></td><td class="tablerow">$input $tool $note</td></tr>');
	$position = $pos->checkbox('info[arrposid][]', $arrposid);
	$area_select = area_select('info[areaid]', $LANG['select_area'], $areaid, 'id="areaid"');
	include admintpl($mod.'_edit');
}
?>
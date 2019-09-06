<?php
defined('IN_PHPCMS') or exit('Access Denied');
$catid or showmessage($LANG['category_id_not_null'],$referer);

$areaid = isset($areaid) ? intval($areaid) : 0;

$AREA = cache_read('areas_'.$channelid.'.php');

if($CAT['child'] && !$CAT['enableadd'])
{
	showmessage($LANG['appoint_category_not_allowed_add_info'],'goback');
}

require PHPCMS_ROOT.'/include/field.class.php';
$field = new field(channel_table('info', $channelid));

require PHPCMS_ROOT.'/admin/include/position.class.php';
$pos = new position($channelid);

$mode = isset($mode) && $mode==1 ? 1 : 0;
if($dosubmit)
{
	if(empty($info['title']))
	{
		showmessage($LANG['sorry_short_title_not_null'],'goback');
	}
	if(isset($addkeywords) && $info['keywords']) update_keywords($info['keywords'], $channelid);
	$info['islink'] = isset($info['islink']) ? 1 : 0;
	$info['arrgroupidview'] = empty($info['arrgroupidview']) ? '' : implode(',', $info['arrgroupidview']);
	$info['catid'] = $catid;
	$info['ip'] = $PHP_IP;
	$info['username'] = $info['editor'] = $info['checker'] = $_username;
	$info['urlruleid'] = $info['ishtml'] ? $html_urlrule : $php_urlrule;
	$info['addtime'] = $info['edittime'] = $info['checktime'] = preg_match('/^([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})/', $info['addtime']) ? strtotime($info['addtime'].' '.date('H:i:s',$PHP_TIME)) : $PHP_TIME;
	$info['endtime'] = preg_match('/^([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})/', $info['endtime']) ? strtotime($info['endtime'].' '.date('H:i:s',$PHP_TIME)) : 0;
	if(isset($info['arrposid']))
	{
		$arrposid = $info['arrposid'];
		$info['arrposid'] = ','.implode(',', $arrposid).',';
	}

	$field->check_form();

	$infoid = $inf->add($info);
	if($infoid)
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
		
		if(isset($arrposid) && $arrposid) $pos->add($infoid, $arrposid);

		$field->update("infoid=$infoid");
		$forward = "?mod=$mod&file=$file&action=add&channelid=$channelid&catid=$catid&areaid=$areaid";
		if($info['status'] == 3)
		{
			require PHPCMS_ROOT.'/include/create_related_html.inc.php';
		}
		showmessage($LANG['info_add_success'], $forward);
	}
	else
	{
		showmessage($LANG['fail_add_info'],'goback');
	}
}
else
{
	$today=date('Y-m-d',$PHP_TIME);
	$type_select = type_select('info[typeid]', $LANG['type']);
	$style_edit = style_edit("info[style]","");
	$keywords_select = keywords_select($channelid);
	$category_jump = category_select('catid', $LANG['switch_to_other_category'], 0, "onchange=\"if(this.value!=''){location='?mod=$mod&file=$file&action=add&job=$job&channelid=$channelid&mode=$mode&areaid=$areaid&catid='+this.value;}\"");
	$showgroup = showgroup('checkbox','info[arrgroupidview][]');
	$showskin = showskin('info[skinid]');
	$showtpl = showtpl($mod,'content','info[templateid]');
	$html_urlrule = urlrule_select('html_urlrule','html','item',$CAT['item_html_urlruleid']);
	$php_urlrule = urlrule_select('php_urlrule','php','item',$CAT['item_php_urlruleid']);
	$fields = $field->get_form('<tr><td class="tablerow"><strong>$title</strong></td><td class="tablerow">$input $tool $note</td></tr>');
	$position = $pos->checkbox('info[arrposid][]');
	include admintpl($mod.'_add');
}
?>
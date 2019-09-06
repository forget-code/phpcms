<?php
defined('IN_PHPCMS') or exit('Access Denied');

if($dosubmit)
{
	if(substr($batch['dir'],-1) != '/') $batch['dir'] = $batch['dir'].'/';
	$dir = $dirtype ? $batch['dir'] : PHPCMS_ROOT.'/'.$batch['dir'];
	is_dir($dir) or showmessage($LANG['category_not_exist']);
	$files = glob($dir."*.*");
	!empty($files) or showmessage($LANG['file_not_find']);
	foreach($files as $file)
	{
		if(strpos($file, ".") === false) continue;
		if($batch['ext'] && !preg_match("/^(".$batch['ext'].")$/i", fileext($file))) continue;
		$down = array();

		if(preg_match("/^([\s\S]*?)([\x81-\xfe][\x40-\xfe])([\s\S]*?)/", $file))
		{
			$file = str_replace(array("%5C", "%2F", "%3A"), array("\\", "/", ":"), urlencode($file));
		}
		$down['title'] = urldecode(str_replace('.'.fileext($file), '', basename($file)));

		$r = $db->get_one("select downid from ".channel_table('down', $channelid)." where title='$down[title]' and status=3 ");
		if($r['downid']) continue;
		$down['filesize'] = bytes2x(filesize($file));
		$file = $dirtype ? $file : str_replace(PHPCMS_ROOT.'/', '', $file);
		$down['downurls'] = $down['title'].'|'.$file;
		$down['arrgroupidview'] = empty($batch['arrgroupidview']) ? '' : implode(',', $batch['arrgroupidview']);
		$down['readpoint'] = $batch['readpoint'];
		$down['catid'] = $batch['catid'];
		$down['islink'] = 0;
		$down['ishtml'] = $batch['ishtml'];
		$down['urlruleid'] = $batch['ishtml'] ? $html_urlrule : $php_urlrule;
		$down['htmldir'] = $batch['htmldir'];
		$down['prefix'] = $batch['prefix'];
		$down['status'] = $batch['status'];
		$down['username'] = $down['editor'] = $down['checker'] = $_username;
		$down['addtime'] = $down['edittime'] = $down['checktime'] = $PHP_TIME;
		$downid = $d->add($down);	
		if($downid)
		{
			if($down['ishtml']  && $down['status'] == 3 && !$down['islink']) createhtml('show');
		}
	}
	showmessage($LANG['batch_added_success'], $PHP_REFERER);
}
else
{
	$category_select = category_select('batch[catid]', $LANG['choose_category'], 0, 'id="catid"');
	$showgroup = showgroup('checkbox','batch[arrgroupidview][]');
	$html_urlrule = urlrule_select('html_urlrule','html','item',$CHA['item_html_urlruleid']);
	$php_urlrule = urlrule_select('php_urlrule','php','item',$CHA['item_php_urlruleid']);
	include admintpl($mod.'_add_batch_local');
}
?>
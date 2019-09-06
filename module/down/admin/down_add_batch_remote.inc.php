<?php
defined('IN_PHPCMS') or exit('Access Denied');
if($dosubmit)
{
	if(substr($batch['dir'],-1) != '/') $batch['dir'] = $batch['dir'].'/';
	require PHPCMS_ROOT.'/include/ftp.class.php';
	$ftp = new phpcms_ftp($batch['ftphost'], $batch['ftpuser'], $batch['ftppass'], 21, $batch['ftpwebpath'], 'I', 1);
	if(!$ftp->connected) showmessage($LANG['ftp_setting_wrong']);
	$files = $ftp->get_list($batch['dir']);
	!empty($files) or showmessage($LANG['file_not_find']);
	foreach($files as $file)
	{
		if(strpos($file, ".") === false) continue;
		if($batch['ext'] && !preg_match("/^(".$batch['ext'].")$/i", fileext($file))) continue;
		$down = array();
		$down['title'] = str_replace('.'.fileext($file), '', basename($file));
		$r = $db->get_one("select downid from ".channel_table('down', $channelid)." where title='$down[title]' ");
		if($r['downid']) continue;
		$down['filesize'] = $LANG['unknown'];
		if(isset($ifftp))
		{
			if(empty($batch['ftpuser']) && empty($batch['ftpuser']))
			{
				$file = 'ftp://'.$batch['ftphost'].'/'.$file;
			}
			else
			{
				$file = 'ftp://'.$batch['ftpuser'].':'.$batch['ftppass'].'@'.$batch['ftphost'].'/'.$file;
			}
		}
		else
		{
			$file = str_replace($batch['ftpwebpath'], '', $file);
			$file = $batch['httppath'].$batch['dir'].$file;
		}
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
	include admintpl($mod.'_add_batch_remote');
}
?>
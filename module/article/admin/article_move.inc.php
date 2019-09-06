<?php
defined('IN_PHPCMS') or exit('Access Denied');
if($dosubmit)
{
	if($totype == 1)
	{
		$targetcatid = isset($targetcatid) ? intval($targetcatid) : 0;
		$targetcatid or showmessage($LANG['empty_category']);
		$CAT = cache_read("category_$targetcatid.php");
		if($CAT['child'] && !$CAT['enableadd']) showmessage($LANG['not_allowed_to_add_an_artcile']);
	}
	else if($totype == 2)
	{
		$tochannelid = isset($tochannelid) ? intval($tochannelid) : 0;
		$tocatid = isset($tocatid) ? intval($tocatid) : 0;
		$tochannelid && $tocatid or showmessage($LANG['empty_category_id']);
		$CAT = cache_read("category_$tocatid.php");
		if($CAT['child'] && !$CAT['enableadd']) showmessage($LANG['not_allowed_to_add_an_artcile']);
	}

	if($fromtype == 1)
	{
		!empty($articleids) or showmessage($LANG['invalid_parameters']);
		$articleids=is_array($articleids) ? implode(',',$articleids) : $articleids;
		if($totype == 1)
		{
			$db->query("UPDATE ".channel_table('article', $channelid)." SET catid='$targetcatid' WHERE articleid IN ($articleids) ");
		}
		else if($totype == 2)
		{
			$result = $db->query("select * from ".channel_table('article', $channelid)."  WHERE articleid IN ($articleids) ");
			while($r = $db->fetch_array($result))
			{
				$r = new_addslashes($r);
				if($move_mode == 1)
				{
					$r['linkurl'] = linkurl($r['linkurl']);
					if(!strpos($r['linkurl'], '://')) $r['linkurl'] = $PHP_SITEURL.substr($r['linkurl'], 1);
					$query = "insert into ".channel_table('article', $tochannelid)." (title,linkurl,islink,status,catid,addtime,username,edittime,editor,checktime,checker) values('$r[title]','$r[linkurl]','1','3','$tocatid','$r[addtime]','$r[username]','$r[edittime]','$r[editor]','$r[checktime]','$r[checker]')";
				}
				else if($move_mode == 2)
				{
					$sql1 = $sql2 = $s = "";
					$articleid_tmp = $r['articleid'];//查询内容时用
					unset($r['articleid']);//
					$r['catid'] = $tocatid;//
					foreach($r as $key=>$value)
					{
						$sql1 .= $s.$key;
						$sql2 .= $s."'".$value."'";
						$s = ",";
					}
					$query = "insert into ".channel_table('article', $tochannelid)." ($sql1) values($sql2)";
				}
				$db->query($query);
				$articleid = $db->insert_id();
				
				if($move_mode == 1)
				{
					$db->query("insert into ".channel_table('article_data', $tochannelid)." (articleid) values ('$articleid') ");
				}
				else if($move_mode == 2)
				{
					$r = $db->get_one("select content from ".channel_table('article_data', $channelid)." where articleid=$articleid_tmp ");
					$r = new_addslashes($r);

					if($MOD['storage_mode'] < 3) $db->query("insert into ".channel_table('article_data', $tochannelid)." (articleid,content) values ('$articleid','$r[content]') ");
					if($MOD['storage_mode'] > 1) txt_update($tochannelid, $articleid, $r['content']);
					if($MOD['storage_mode'] == 3) $db->query("insert into ".channel_table('article_data', $tochannelid)." (articleid,content) values ('$articleid','$r[content]') ");

					if(!isset($save_original)) $art->delete($articleid_tmp, 0, 0);//保留了原始图片
				}
			}
		}
	}
	else if($fromtype == 2)
	{
		!empty($batchcatid) or showmessage($LANG['empty_parent_category']);
		$batchcatids = is_array($batchcatid) ? implode(",",$batchcatid) : $batchcatid;
		if($totype == 1)
		{
			$db->query("UPDATE ".channel_table('article', $channelid)." SET catid='$targetcatid' WHERE catid IN ($batchcatids) ");
		}
		else if($totype == 2)
		{
			$result = $db->query("select * from ".channel_table('article', $channelid)."  WHERE catid IN ($batchcatids) ");
			while($r = $db->fetch_array($result))
			{
				$r = new_addslashes($r);
				if($move_mode == 1)
				{
					$r['linkurl'] = linkurl($r['linkurl']);
					if(!strpos($r['linkurl'], '://')) $r['linkurl'] = $PHP_SITEURL.substr($r['linkurl'], 1);
					$query = "insert into ".channel_table('article', $tochannelid)." (title,linkurl,islink,status,catid,addtime,username,edittime,editor,checktime,checker) values('$r[title]','$r[linkurl]','1','3','$tocatid','$r[addtime]','$r[username]','$r[edittime]','$r[editor]','$r[checktime]','$r[checker]')";
				}
				else if($move_mode == 2)
				{
					$sql1 = $sql2 = $s = "";
					$articleid_tmp = $r['articleid'];//查询内容时用
					unset($r['articleid']);//
					$r['catid'] = $tocatid;//
					foreach($r as $key=>$value)
					{
						$sql1 .= $s.$key;
						$sql2 .= $s."'".$value."'";
						$s = ",";
					}
					$query = "insert into ".channel_table('article', $tochannelid)." ($sql1) values($sql2)";
				}

				$db->query($query);
				$articleid = $db->insert_id();
				
				if($move_mode == 1)
				{
					$db->query("insert into ".channel_table('article_data', $tochannelid)." (articleid) values ('$articleid') ");
				}
				else if($move_mode == 2)
				{
					$r = $db->get_one("select content from ".channel_table('article_data', $channelid)." where articleid=$articleid_tmp ");
					$r = new_addslashes($r);
					if($MOD['storage_mode'] < 3) $db->query("insert into ".channel_table('article_data', $tochannelid)." (articleid,content) values ('$articleid','$r[content]') ");
					if($MOD['storage_mode'] > 1) txt_update($tochannelid, $articleid, $r['content']);
					if($MOD['storage_mode'] == 3) $db->query("insert into ".channel_table('article_data', $tochannelid)." (articleid,content) values ('$articleid','$r[content]') ");
					if(!isset($save_original)) $art->delete($articleid_tmp, 0, 0);//保留了原始图片
				}
			}
		}
	}
	showmessage($LANG['move_success'],$referer);
}
else
{
	if(isset($request_channelid))// For Ajax
	{
		$CATEGORY = cache_read("categorys_".$request_channelid.".php");
		echo category_select('tocatid', $LANG['please_select']);
		exit;
	}
	else
	{
		$referer = isset($referer) ? $referer : "?mod=$mod&file=$file&action=move&channelid=$channelid";
		$articleids = (isset($articleids) ? $articleids : '') ;
		$articleids = is_array($articleids) ? implode(',',$articleids) : $articleids;
		$category_select = str_replace("<select name='catid' ><option value='0'></option>",'',category_select('catid'));
		include admintpl($mod.'_move');
	}
}
?>
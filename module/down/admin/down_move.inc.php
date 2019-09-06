<?php
defined('IN_PHPCMS') or exit('Access Denied');
//
if($dosubmit)
{
	if($totype == 1)
	{
		$targetcatid = isset($targetcatid) ? intval($targetcatid) : 0;
		$targetcatid or showmessage($LANG['target_category_no_air']);
		$CAT = cache_read("category_$targetcatid.php");
		if($CAT['child'] && !$CAT['enableadd']) showmessage($LANG['target_disallow_download']);
	}
	else if($totype == 2)
	{
		$tochannelid = isset($tochannelid) ? intval($tochannelid) : 0;
		$tocatid = isset($tocatid) ? intval($tocatid) : 0;
		$tochannelid && $tocatid or showmessage($LANG['id_channel_space']);
		$CAT = cache_read("category_$tocatid.php");
		if($CAT['child'] && !$CAT['enableadd']) showmessage($LANG['id_channel_space']);
	}

	if($fromtype == 1)
	{
		!empty($downids) or showmessage($LANG['illegal_parameters']);
		$downids=is_array($downids) ? implode(',',$downids) : $downids;
		if($totype == 1)
		{
			$db->query("UPDATE ".channel_table('down', $channelid)." SET catid='$targetcatid' WHERE downid IN ($downids) ");
		}
		else if($totype == 2)
		{
			$result = $db->query("select * from ".channel_table('down', $channelid)."  WHERE downid IN ($downids) ");
			while($r = $db->fetch_array($result))
			{
				$r = new_addslashes($r);
				if($move_mode == 1)
				{
					$r['linkurl'] = linkurl($r['linkurl']);
					if(!strpos($r['linkurl'], '://')) $r['linkurl'] = $PHP_SITEURL.substr($r['linkurl'], 1);
					$query = "insert into ".channel_table('down', $tochannelid)." (title,linkurl,islink,status,catid,addtime,username,edittime,editor,checktime,checker) values('$r[title]','$r[linkurl]','1','3','$tocatid','$r[addtime]','$r[username]','$r[edittime]','$r[editor]','$r[checktime]','$r[checker]')";
				}
				else if($move_mode == 2)
				{
					$sql1 = $sql2 = $s = "";
					$downid_tmp = $r['downid'];
					unset($r['downid']);//
					$r['catid'] = $tocatid;//
					foreach($r as $key=>$value)
					{
						$sql1 .= $s.$key;
						$sql2 .= $s."'".$value."'";
						$s = ",";
					}
					$query = "insert into ".channel_table('down', $tochannelid)." ($sql1) values($sql2)";
					if(!isset($save_original)) $d->delete($downid_tmp);
				}
				$db->query($query);
			}
		}
	}
	else if($fromtype == 2)
	{
		!empty($batchcatid) or showmessage($LANG['source_category_empty']);
		$batchcatids = is_array($batchcatid) ? implode(",",$batchcatid) : $batchcatid;
		if($totype == 1)
		{
			$db->query("UPDATE ".channel_table('down', $channelid)." SET catid='$targetcatid' WHERE catid IN ($batchcatids) ");
		}
		else if($totype == 2)
		{
			$result = $db->query("select * from ".channel_table('down', $channelid)."  WHERE downid catid IN ($batchcatids) ");
			while($r = $db->fetch_array($result))
			{
				$r = new_addslashes($r);
				if($move_mode == 1)
				{
					$r['linkurl'] = linkurl($r['linkurl']);
					if(!strpos($r['linkurl'], '://')) $r['linkurl'] = $PHP_SITEURL.substr($r['linkurl'], 1);
					$query = "insert into ".channel_table('down', $tochannelid)." (title,linkurl,islink,status,catid,addtime,username,edittime,editor,checktime,checker) values('$r[title]','$r[linkurl]','1','3','$tocatid','$r[addtime]','$r[username]','$r[edittime]','$r[editor]','$r[checktime]','$r[checker]')";
				}
				else if($move_mode == 2)
				{
					$sql1 = $sql2 = $s = "";
					$downid_tmp = $r['downid'];//查询内容时用
					unset($r['downid']);//
					$r['catid'] = $tocatid;//
					foreach($r as $key=>$value)
					{
						$sql1 .= $s.$key;
						$sql2 .= $s."'".$value."'";
						$s = ",";
					}
					$query = "insert into ".channel_table('down', $tochannelid)." ($sql1) values($sql2)";
					if(!isset($save_original)) $d->delete($downid_tmp);
				}

				$db->query($query);
			}
		}
	}
	showmessage($LANG['mobile_operated_success'],$referer);
}
else
{
	if(isset($request_channelid))// For Ajax
	{
		$CATEGORY = cache_read("categorys_".$request_channelid.".php");
		echo category_select('tocatid', $LANG['choose_target_category']);
		exit;
	}
	else
	{
		$referer = isset($referer) ? $referer : "?mod=$mod&file=$file&action=move&channelid=$channelid";
		$downids = (isset($downids) ? $downids : '') ;
		$downids = is_array($downids) ? implode(',',$downids) : $downids;
		$category_select = str_replace("<select name='catid' ><option value='0'></option>",'',category_select('catid'));
		include admintpl($mod.'_move');
	}
}
?>
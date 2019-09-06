<?php
defined('IN_PHPCMS') or exit('Access Denied');
//
if($dosubmit)
{
	if($totype == 1)
	{
		$targetcatid = isset($targetcatid) ? intval($targetcatid) : 0;
		$targetcatid or showmessage($LANG['distinct_category_not_null']);
		$CAT = cache_read("category_$targetcatid.php");
		if($CAT['child'] && !$CAT['enableadd']) showmessage($LANG['distinct_category_not_allow_to_add_info']);
	}
	else if($totype == 2)
	{
		$tochannelid = isset($tochannelid) ? intval($tochannelid) : 0;
		$tocatid = isset($tocatid) ? intval($tocatid) : 0;
		$tochannelid && $tocatid or showmessage($LANG['distinct_channel_id_or_category_id_not_null']);
		$CAT = cache_read("category_$tocatid.php");
		if($CAT['child'] && !$CAT['enableadd']) showmessage($LANG['distinct_category_not_allow_to_add_info']);
	}

	if($fromtype == 1)
	{
		!empty($infoids) or showmessage($LANG['illegal_parameters']);
		$infoids=is_array($infoids) ? implode(',',$infoids) : $infoids;
		if($totype == 1)
		{
			$db->query("UPDATE ".channel_table('info', $channelid)." SET catid='$targetcatid' WHERE infoid IN ($infoids) ");
		}
		else if($totype == 2)
		{
			$result = $db->query("select * from ".channel_table('info', $channelid)."  WHERE infoid IN ($infoids) ");
			while($r = $db->fetch_array($result))
			{
				$r = new_addslashes($r);
				if($move_mode == 1)
				{
					$r['linkurl'] = linkurl($r['linkurl']);
					if(!strpos($r['linkurl'], '://')) $r['linkurl'] = $PHP_SITEURL.substr($r['linkurl'], 1);
					$query = "insert into ".channel_table('info', $tochannelid)." (title,linkurl,islink,status,catid,addtime,username,edittime,editor,checktime,checker) values('$r[title]','$r[linkurl]','1','3','$tocatid','$r[addtime]','$r[username]','$r[edittime]','$r[editor]','$r[checktime]','$r[checker]')";
				}
				else if($move_mode == 2)
				{
					$sql1 = $sql2 = $s = "";
					$infoid_tmp = $r['infoid'];//查询内容时用
					unset($r['infoid']);//
					$r['catid'] = $tocatid;//
					foreach($r as $key=>$value)
					{
						$sql1 .= $s.$key;
						$sql2 .= $s."'".$value."'";
						$s = ",";
					}
					$query = "insert into ".channel_table('info', $tochannelid)." ($sql1) values($sql2)";
				}
				$db->query($query);
				if(!isset($save_original)) $info->delete($infoid_tmp);
			}
		}
	}
	else if($fromtype == 2)
	{
		!empty($batchcatid) or showmessage($LANG['source_category_not_null']);
		$batchcatids = is_array($batchcatid) ? implode(",",$batchcatid) : $batchcatid;
		if($totype == 1)
		{
			$db->query("UPDATE ".channel_table('info', $channelid)." SET catid='$targetcatid' WHERE catid IN ($batchcatids) ");
		}
		else if($totype == 2)
		{
			$result = $db->query("select * from ".channel_table('info', $channelid)."  WHERE catid IN ($batchcatids) ");
			while($r = $db->fetch_array($result))
			{
				$r = new_addslashes($r);
				if($move_mode == 1)
				{
					$r['linkurl'] = linkurl($r['linkurl']);
					if(!strpos($r['linkurl'], '://')) $r['linkurl'] = $PHP_SITEURL.substr($r['linkurl'], 1);
					$query = "insert into ".channel_table('info', $tochannelid)." (title,linkurl,islink,status,catid,addtime,username,edittime,editor,checktime,checker) values('$r[title]','$r[linkurl]','1','3','$tocatid','$r[addtime]','$r[username]','$r[edittime]','$r[editor]','$r[checktime]','$r[checker]')";
				}
				else if($move_mode == 2)
				{
					$sql1 = $sql2 = $s = "";
					$infoid_tmp = $r['infoid'];
					unset($r['infoid']);//
					$r['catid'] = $tocatid;//
					foreach($r as $key=>$value)
					{
						$sql1 .= $s.$key;
						$sql2 .= $s."'".$value."'";
						$s = ",";
					}
					$query = "insert into ".channel_table('info', $tochannelid)." ($sql1) values($sql2)";
				}

				$db->query($query);
				if(!isset($save_original)) $info->delete($infoid_tmp);
			}
		}
	}
	showmessage($LANG['operation_success'],$referer);
}
else
{
	if(isset($request_channelid))// For Ajax
	{
		$CATEGORY = cache_read("categorys_".$request_channelid.".php");
		echo category_select('tocatid', $LANG['select_distinct_category']);
		exit;
	}
	else
	{
		$referer = isset($referer) ? $referer : "?mod=$mod&file=$file&action=move&channelid=$channelid";
		$infoids = (isset($infoids) ? $infoids : '') ;
		$infoids = is_array($infoids) ? implode(',',$infoids) : $infoids;
		$category_select = str_replace("<select name='catid' ><option value='0'></option>",'',category_select('catid'));
		include admintpl($mod.'_move');
	}
}
?>
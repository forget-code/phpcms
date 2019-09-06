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
		if($CAT['child'] && !$CAT['enableadd']) showmessage($LANG['distinct_category_not_allow_to_add_picture']);
	}
	else if($totype == 2)
	{
		$tochannelid = isset($tochannelid) ? intval($tochannelid) : 0;
		$tocatid = isset($tocatid) ? intval($tocatid) : 0;
		$tochannelid && $tocatid or showmessage($LANG['distinct_category_not_null']);
		$CAT = cache_read("category_$tocatid.php");
		if($CAT['child'] && !$CAT['enableadd']) showmessage($LANG['distinct_category_not_allow_to_add_picture']);
	}

	if($fromtype == 1)
	{
		!empty($pictureids) or showmessage($LANG['illegal_parameters']);
		$pictureids=is_array($pictureids) ? implode(',',$pictureids) : $pictureids;
		if($totype == 1)
		{
			$db->query("UPDATE ".channel_table('picture', $channelid)." SET catid='$targetcatid' WHERE pictureid IN ($pictureids) ");
		}
		else if($totype == 2)
		{
			$result = $db->query("select * from ".channel_table('picture', $channelid)."  WHERE pictureid IN ($pictureids) ");
			while($r = $db->fetch_array($result))
			{
				$r = new_addslashes($r);
				if($move_mode == 1)
				{
					$r['linkurl'] = linkurl($r['linkurl']);
					if(!strpos($r['linkurl'], '://')) $r['linkurl'] = $PHP_SITEURL.substr($r['linkurl'], 1);
					$query = "insert into ".channel_table('picture', $tochannelid)." (title,linkurl,islink,status,catid,addtime,username,edittime,editor,checktime,checker) values('$r[title]','$r[linkurl]','1','3','$tocatid','$r[addtime]','$r[username]','$r[edittime]','$r[editor]','$r[checktime]','$r[checker]')";
				}
				else if($move_mode == 2)
				{
					$sql1 = $sql2 = $s = "";
					$pictureid_tmp = $r['pictureid'];//查询内容时用
					unset($r['pictureid']);//
					$r['catid'] = $tocatid;//
					foreach($r as $key=>$value)
					{
						$sql1 .= $s.$key;
						$sql2 .= $s."'".$value."'";
						$s = ",";
					}
					$query = "insert into ".channel_table('picture', $tochannelid)." ($sql1) values($sql2)";
					if(!isset($save_original)) $pic->delete($pictureid_tmp);
				}
				$db->query($query);
			}
		}
	}
	else if($fromtype == 2)
	{
		!empty($batchcatid) or showmessage($LANG['source_category_not_null']);
		$batchcatids = is_array($batchcatid) ? implode(",",$batchcatid) : $batchcatid;
		if($totype == 1)
		{
			$db->query("UPDATE ".channel_table('picture', $channelid)." SET catid='$targetcatid' WHERE catid IN ($batchcatids) ");
		}
		else if($totype == 2)
		{
			$result = $db->query("select * from ".channel_table('picture', $channelid)."  WHERE  catid IN ($batchcatids) ");
			while($r = $db->fetch_array($result))
			{
				$r = new_addslashes($r);
				if($move_mode == 1)
				{
					$r['linkurl'] = linkurl($r['linkurl']);
					if(!strpos($r['linkurl'], '://')) $r['linkurl'] = $PHP_SITEURL.substr($r['linkurl'], 1);
					$query = "insert into ".channel_table('picture', $tochannelid)." (title,linkurl,islink,status,catid,addtime,username,edittime,editor,checktime,checker) values('$r[title]','$r[linkurl]','1','3','$tocatid','$r[addtime]','$r[username]','$r[edittime]','$r[editor]','$r[checktime]','$r[checker]')";
				}
				else if($move_mode == 2)
				{
					$sql1 = $sql2 = $s = "";
					$pictureid_tmp = $r['pictureid'];//查询内容时用
					unset($r['pictureid']);//
					$r['catid'] = $tocatid;//
					foreach($r as $key=>$value)
					{
						$sql1 .= $s.$key;
						$sql2 .= $s."'".$value."'";
						$s = ",";
					}
					$query = "insert into ".channel_table('picture', $tochannelid)." ($sql1) values($sql2)";
					if(!isset($save_original)) $pic->delete($pictureid_tmp);
				}

				$db->query($query);
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
		$pictureids = (isset($pictureids) ? $pictureids : '') ;
		$pictureids = is_array($pictureids) ? implode(',',$pictureids) : $pictureids;
		$category_select = str_replace("<select name='catid' ><option value='0'></option>",'',category_select('catid'));
		include admintpl($mod.'_move');
	}
}
?>
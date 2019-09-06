<?php
defined('IN_PHPCMS') or exit('Access Denied');

// 取得广告位信息
$_values=$db->query("SELECT placeid,placename FROM ".TABLE_ADS_PLACE);
while($r=$db->fetch_array($_values))
{
	$_adsplaces[$r['placeid']] = $r;
}

if (isset($submit)) // 执行编辑
{
	if(strlen($ads['adsname']) < 2 || strlen($ads['adsname']) > 30) showmessage($LANG['invalid_name']);
	$ads['adsname'] = str_safe($ads['adsname']);
	$ads['introduce'] = str_safe($ads['introduce']);
  
	$badwords = array("\\",'&',' ',"'",'"','*',',','<','>',"\r","\t","\n",'#');
	foreach ($badwords as $value)
	{
		if(strpos($ads['linkurl'],$value)!==false) 
		{
			showmessage($LANG['illegal_name']);
		}
	}
  
	if(!$_adsplaces[$placeid]['placename']) showmessage($LANG['incorrect_advertisement_published']);
	if(!$ads['fromdate']) showmessage($LANG['input_the_advertising_begin_time']);   
	if(!$ads['todate']) showmessage($LANG['input_the_advertising_end_time']);

	if($ads['type']=="image") 
	{
		if(!strlen($imageurl)) showmessage($LANG['input_advertising_images_url']);
		$type_sql = ",type='".$ads['type']."',alt='".$ads['alt']."',linkurl='".$ads['linkurl']."',imageurl='$imageurl'";
	}
	elseif($ads['type']=="flash")
	{
		if(!$flashurl) showmessage($LANG['please_input_the_flash_url']);
		$type_sql = ",type='".$ads['type']."',flashurl='$flashurl',wmode='".($ads['wmode']=="transparent"?"transparent":"")."'";
	}
	elseif($ads['type']=="text")
	{
		if(!$ads['text'])
		{
			showmessage($LANG['please_input_the_advertising_content']);
		}
		$type_sql = ",type='{$ads['type']}',text='{$ads['text']}'";
	}
	elseif($ads['type']=="code") 
	{
		if(!$ads['code'])
		{
			showmessage($LANG['please_input_the_advertising_code']);
		}
		$type_sql = ",type='".$ads['type']."',code='".$ads['code']."'";
	}
      
	$ads['username'] = $ads['username'] ? $ads['username'] : $_username;
      
	$sql = "UPDATE ".TABLE_ADS." SET adsname='".$ads['adsname']."',introduce='".$ads['introduce']."',placeid='".$placeid."',passed=".($ads['passed']?1:0).",username='".$ads['username']."',fromdate=".strtotime($ads['fromdate']).",todate=".strtotime($ads['todate']).$type_sql." WHERE adsid=$adsid";
	$db->query($sql);
	showmessage($LANG['opration_successd_advertising_content_has_been_modified'],$referer);
}  
else
{
  $_ads = $db->get_one("SELECT * FROM ".TABLE_ADS." where adsid={$adsid}");
  $_ads['fromdate'] = date("Y-n-j",$_ads['fromdate']);
  $_ads['todate'] = date("Y-n-j",$_ads['todate']);

  $_adsplaces_select="";
  foreach ($_adsplaces as $r)
  {
    $_checked = ($_ads['placeid']==$r['placeid'])?" selected":"";
    $_adsplaces_select .= "<option value='{$r['placeid']}'{$_checked}>{$r['placename']}</option>";
  }
  $_adsplaces_select = "<SELECT name='placeid'>{$_adsplaces_select}</SELECT>";

}

include admintpl('ads_edit');
?>
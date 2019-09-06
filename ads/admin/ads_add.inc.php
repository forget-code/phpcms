<?php
defined('IN_PHPCMS') or exit('Access Denied');

$_values=$db->query("SELECT placeid,placename FROM ".TABLE_ADS_PLACE);
while($r=$db->fetch_array($_values))
{
	$_adsplaces[$r['placeid']] = $r;
}

if (isset($submit)) // 执行添加
{
	if(strlen($ads['adsname'])<2 || strlen($ads['adsname'])>30)
	{
		showmessage($LANG['invalid_name']);
	}
  
  $ads['adsname'] = str_safe($ads['adsname']);
  $ads['introduce'] = str_safe($ads['introduce']);
  $ads['alt'] = str_safe($ads['alt']);
  $ads['linkurl'] = linkurl($ads['linkurl']);
  $ads['text'] = str_safe($ads['text']);
  
	if(!$_adsplaces[$placeid]['placename'])
	{
		showmessage($LANG['incorrect_advertisement_published']);
	}

	if(!$ads['fromdate'])
	{
		showmessage($LANG['input_the_advertising_begin_time']);
	}
        
	if(!$ads['todate'])
	{
		showmessage($LANG['input_the_advertising_end_time']);
	}

	if($ads['type']=="image") 
	{
		if(!strlen($imageurl)) showmessage($LANG['input_advertising_images_url']);
		$type_sql = ",type='".$ads['type']."',alt='".$ads['alt']."',linkurl='".$ads['linkurl']."',imageurl='$imageurl'";
	}

	if($ads['type']=="flash")
	{
		if(!$flashurl) showmessage($LANG['please_input_the_flash_url']);
			$type_sql = ",type='".$ads['type']."',flashurl='$flashurl',wmode='".($ads['wmode']=="transparent"?"transparent":"")."'";
	}

	if($ads['type']=="text")
	{
		if(!$ads['text'])
		{
			showmessage($LANG['please_input_the_advertising_content']);
		}
		$type_sql = ",type='{$ads['type']}',text='{$ads['text']}'";
	}

	if($ads['type']=="code") 
	{
		if(!$ads['code'])
		{
			showmessage($LANG['please_input_the_advertising_code']);
		}
		$type_sql = ",type='{$ads['type']}',code='{$ads['code']}'";
	}
      
	$ads['username'] = isset($ads['username'])?$ads['username']:$_username;
      
	$sql = "INSERT INTO ".TABLE_ADS." SET adsname='{$ads['adsname']}',introduce='{$ads['introduce']}',addtime='".time()."',placeid='".$placeid."',passed=".($ads['passed']?1:0).",username='{$ads['username']}',checked='1',fromdate=".strtotime($ads['fromdate']).",todate=".strtotime($ads['todate']).$type_sql;

	$result=$db->query($sql);

	if($db->affected_rows()>0)
	{
		showmessage($LANG['opration_successd_you_can_select_record_in_advertisement_order_list'],"?mod=ads&file=adsplace&");
	} else 
	{
		showmessage($LANG['opration_failure_make_sure_enter_the_correct_content']);
	}  		

}

$_adsplaces_select = "";
foreach ($_adsplaces as $r)
{
  $_checked = ($placeid==$r['placeid'])?" selected":"";
  $_adsplaces_select .= "<option value='{$r['placeid']}'{$_checked}>{$r['placename']}</option>";
}
$_adsplaces_select = "<SELECT name='placeid'>{$_adsplaces_select}</SELECT>";

include_once(PHPCMS_ROOT."/include/date.class.php");
$date = new phpcms_date();
$date->set_date(date("Y-m-d"));
$date->monthadd();
$lastmonth =  $date->get_date();

include admintpl('ads_add');

?>
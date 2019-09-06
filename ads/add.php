<?php
require './include/common.inc.php';

if(!$_userid) showmessage($LANG['please_login_or_register'], $MODULE['member']['linkurl'].'login.php?forward='.urlencode($PHP_URL));

$ads['username'] = $_username;
$ads['placeid'] = intval($ads['placeid']);
if(!$ads['placeid']) showmessage($LANG['invalid_parameters']);

$sql = "select * from ".TABLE_ADS_PLACE." where placeid={$ads['placeid']} limit 1";
$result = $db->get_one($sql);
if(empty($result)) 
{
  showmessage($LANG['opration_failure_or_advertisement _not_exists']);
}
$place = $result;

if($_money<($place['price']*$ads['longtime'])) showmessage($LANG['not_enough_balance_please_charge'],PHPCMS_PATH."pay/");

if($submit)
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
  $ads['code'] = str_safe($ads['code']);

  if(!$ads['fromdate'])
  {
    showmessage($LANG['please_input_the_advertising_day']);
  }
			
  if(!is_numeric($ads['longtime']) && !($ads['longtime'])>0)
  {
    showmessage($LANG['invalid_advertising_time']);
  }
  else 
  {
    include_once(PHPCMS_ROOT."/include/date.class.php");
    $date = new phpcms_date();
    $date->set_date($ads['fromdate']);
    $date->monthadd($ads['longtime']);
    $ads['todate'] =  $date->get_date();				
  }

  if($ads['type']=="image") {
    if(!strlen($imageurl)) showmessage($LANG['input_advertising_images_url']);
    $type_sql = ",type='{$ads['type']}',alt='{$ads['alt']}',linkurl='{$ads['linkurl']}',imageurl='{$imageurl}'";
  }

  if($ads['type']=="flash")
  {
    if(!$flashurl) showmessage($LANG['please_input_the_flash_url']);
    $type_sql = ",type='{$ads['type']}',flashurl='{$flashurl}',wmode='".($ads['wmode']=="transparent"?"transparent":"")."'";
  }

  if($ads['type']=="text")
  {
    if(!$ads['text']) showmessage($LANG['please_input_the_advertising_content']);
    $type_sql = ",type='{$ads['type']}',text='{$ads['text']}'";
  }

  if($ads['type']=="code") 
  {
    if(!$ads['code']) showmessage($LANG['please_input_the_advertising_code']);
    $type_sql = ",type='{$ads['type']}',code='{$ads['code']}'";
  }

  $sql = "INSERT INTO ".TABLE_ADS." SET adsname='{$ads['adsname']}',introduce='{$ads['introduce']}',addtime='".time()."',placeid='{$ads['placeid']}',username='{$ads['username']}',checked=0,fromdate=".strtotime($ads['fromdate']).",todate=".strtotime($ads['todate']).$type_sql;

  $result=$db->query($sql);
  if($db->affected_rows()>0) 
  {
    showmessage($LANG['opration_success_waiting_for_check'], $MOD['linkurl']);
  }
  else
  {
    showmessage($LANG['opration_failure_make_sure_enter_the_correct_content']);
  }
}
showmessage($LANG['please_input_content'], $referer);
?>
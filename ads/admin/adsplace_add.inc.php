<?php
defined('IN_PHPCMS') or exit('Access Denied');

if (isset($submit)) // 添加动作
{

  if(strlen($place['placename']) <2 || strlen($place['placename']) >30) 
  {
    showmessage($LANG['invalid_name']);
  }

  $badwords = array("\\", '&', "'", '"', '/', '*', '<', '>', "\r", "\t", "\n", '#');

  foreach($badwords as $value)
  {
    if(strpos($place['placename'], $value) !== false)
    {
      showmessage($LANG['illegal_name']);
    }
  }

  foreach($badwords as $value) 
  {
    if(strpos($place['introduce'], $value) !== false) {
      showmessage($LANG['illegal_discription']);
    }
  }

  if(!$templateid) 
  {
    showmessage($LANG['please_enter_the_advertisement_template']);
  }

  if (!is_numeric($place['price'])) 
  {
    showmessage($LANG['please_enter_the_advertisement_price']);
  }

  if (!is_numeric($place['height']) && !is_numeric($place['weight']))
  {
    showmessage($LANG['the_height_and_width_of_the_advertisement_must_be_a_integer']);
  }

  $sql = "INSERT INTO ".TABLE_ADS_PLACE." 
    SET 
        placename='{$place['placename']}',introduce='{$place['introduce']}',
        templateid='$templateid',price='{$place['price']}',
        channelid='{$place['channelid']}',passed=".($place['passed'] ? 1 : 0) .",
        width='{$place['width']}',height='{$place['height']}'";

  $result = $db->query($sql);

  if ($db->affected_rows() >0) 
  {
    showmessage($LANG['opration_completed'], "?mod=$mod&file=$file&action=manage");
  }
  else
  {
    showmessage($LANG['opration_failure_make_sure_enter_the_correct_content']);
  }

}


// 添加广告位
$template_select = showtpl($mod, "ads", "templateid");


$referer = urlencode($referer);
include admintpl('adsplace_add');

?>
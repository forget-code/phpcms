<?php
defined('IN_PHPCMS') or exit('Access Denied');

$placeid = intval($placeid);

if (isset($submit)) { // 保存修改广告位

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

  $sql = "update ".TABLE_ADS_PLACE." 
    SET 
        placename='{$place['placename']}',introduce='{$place['introduce']}',
        templateid='$templateid',price='{$place['price']}',
        channelid='{$place['channelid']}',passed=".($place['passed'] ? 1 : 0) .",
        width='{$place['width']}',height='{$place['height']}' 
      where placeid={$placeid}";

  $result = $db->query($sql);

  if ($db->affected_rows() >0) 
  {
    showmessage($LANG['opration_completed'], "?mod={$mod}&file={$file}&action=manage");
  }
  else
  {
    showmessage($LANG['opration_failure_make_sure_enter_the_correct_content']);
  }

} else { // 调用修改广告位
  $sql = "select * from ".TABLE_ADS_PLACE." where placeid=$placeid limit 1";
  $result = $db->get_one($sql);
  if (empty($result)) 
  {
    showmessage($LANG['opration_failure_or_advertisement _not_exists']);
  }
  $place = $result;
  $template_select = showtpl($mod, "ads", "templateid",$place['templateid']);
}


$referer = urlencode($referer);
include admintpl('adsplace_edit');

?>
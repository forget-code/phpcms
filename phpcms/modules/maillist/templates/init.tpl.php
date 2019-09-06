<?php
/**
 * Description:
 * 
 * Encoding:    GBK
 * Created on:  2012-4-16-下午5:48:04
 * Author:      kangyun
 * Email:       KangYun.Yun@Snda.Com
 */
 
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');
?>

<div style="margin:20px; line-height:22px"><b><?php echo L('intro')?></b><br />
<a href="?m=maillist&c=maillist&a=<?php echo (isset ($groups['status'])) ? 'maillist_mgr' : 'maillist_create'; ?>&menuid=<?php echo $_GET['menuid']?>"><img src="http://o.sdo.com/images/banner.jpg"  border="0"   /></a>

<div style="margin-top:30px; width:70%; word-wrap:break-word; word-break:normal; word-break:break-all;">
<span style="font-size:14px; font-weight:bold"><?php echo L('act');?></span>
<?php 
if (!count($data['activityes'])) {
	echo '<br>' . L('no_act');
} else {
	foreach ($data['activityes'] as $key => $item) {
?>
<div style="padding:10px; border-bottom:solid 1px #cccccc">
	<div><?php echo L('act_id') . ': ' . $item['id'];?> </div> 
	<div><?php echo L('act_name') . ': ' . $item['name'];?> </div> 
	<div><?php echo L('act_time') . ': ' . date('Y-m-d H:i', $item['startTime']['time'] / 1000) . L('to') . date('Y-m-d H:i', $item['endTime']['time'] / 1000) ;?></div>
	<div><?php echo L('act_content') . ': ' . $item['content']?></div>
</div>
<?php }}?>
</div>
</div>

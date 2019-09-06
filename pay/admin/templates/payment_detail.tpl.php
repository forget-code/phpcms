<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<?=$menu?>
<form method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>&id=<?=$id?>" >
<table cellpadding="0" cellspacing="1" class="table_form">
  <caption>
  基本信息
  </caption>
  <tr>
    <th width="25%"><strong>支付方式名称</strong></th>
    <td width="75%"><?=$info['pay_name']?></td>
  </tr>
  <tr>
    <th><strong>支付方式描述</strong></th>
    <td><textarea name="pay_desc" cols="60" rows="8"><?=$info['pay_desc']?></textarea></td>
  </tr>
  <tr>
  <tr>
    <th><strong>排序</strong></th>
    <td><input name="pay_order" type="text" value="<?=$info['pay_order']?>" size="5" /></td>
  </tr>
  <tr>
    <th><strong>支付手续费</strong></th>
    <td><input name="pay_fee" type="text" value="<?=$info['pay_fee']?>" size="5" />&nbsp;<span style="color:red;">%</span></td>
  </tr>
  <?php foreach ($info['config'] as $conf => $name) {?>
 <tr>
  <th><strong><?=$name['name']?></strong></th>
  <td>
  <?php if($name['type'] == 'text'){?>
	<input type="text" size="40" name="config_value[]" value="<?=$name['value']?>" />
	<?php } elseif($name['type'] == 'select') { ?>
	 <select name="config_value[]" value="0">
	 <?php foreach ($name['range'] as $key => $v) {?>
		<option value="<?=$key?>" <?php if($key == $name['value']){ ?> selected="" <?php } ?> ><?=$v?></option>
	  <?php }?>
	</select>
<?php }?>
	<input type="hidden" value="<?=$conf?>" name="config_name[]"/>
  </td>
</tr>
<?php }?>
    <th>&nbsp;</th>
    <td>
	  <input name="pay_name" type="hidden" value="<?=$info['pay_name']?>" />
	  <input type="hidden"  name="pay_id" value=<?=$info['pay_id']?> />
      <input type="hidden"  name="pay_code" value=<?=$info['pay_code']?> />
      <input type="hidden"  name="is_cod" value=<?=$info['is_cod']?> />
      <input type="hidden"  name="is_online" value=<?=$info['is_online']?> />
      <input type="submit" class="button" name="dosubmit"  value=" 确定 " />
      <input type="reset" class="button"  name="Reset"  value=" 重置 " /></td>
  </tr>
</table></form></body>
</html>
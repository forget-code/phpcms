<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<style type="text/css">
ul, ol, li{
	list-style:none;
}
</style>
<form name="myform" action="" method="post">
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="table_form">
 <caption>添加新方案</caption>
  <tr>
  <th class="align_left"><strong>方案名称</strong></th>
    <td colspan="3"><input type="text" name="name" size="30" value="<?=$name?>"> 提示：最少为2个选项，最多为15个选项</td>
  </tr>
   <tr><th class="align_left"><strong>选项ID</strong></th><th class="align_left"><strong>名称</strong></th><th class="align_left"><strong>图片地址</strong></th></tr>
<?php
	for($i=1;$i<16;$i++)
	{
	$m = 'm'.$i;
	$p = 'p'.$i;
	  ?>
  <tr>
    <td class="align_left">选项<?=$i?>、</td><td><input type="text" name="m[]" size="30" value="<?=$$m?>"></td><td><input type="text" name="p[]" size="60" value="<?=$$p?>"> <?php if($$p) {?><img src='<?=$$p?>' width=20 height=20><?php } ?></td>
  </tr>
 <?php
  }
  ?>
 <tr>
    <td class="align_left" colspan="3"><input type="hidden" name="moodid" value="<?=$moodid?>">
<input type="submit" name="dosubmit" value=" 编辑 "></td>
  </tr>
</table>
</form>
</body>
</html>
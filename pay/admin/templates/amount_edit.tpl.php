<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<?=$menu?>
<form method="post" action="?mod=<?=$mod?>&file=useramount&action=check" name="theForm" >
<!--标签页-->
<table cellpadding="0" cellspacing="1" class="table_form">
  <caption>
  基本信息
  </caption>
  <tr>
    <th width="25%"><strong>会员名称：</strong></th>
    <td width="75%"><?=$info['username']?></td>
  </tr>
  <tr>
    <th><strong>金额：</strong>
    <td><?=$info['amount']?></td>
  </tr>
  <tr>
    <th><strong>操作日期：</strong></th>
    <td><?=$info['addtime']?></td>
  </tr>
  <tr>
    <th><strong>类型：</strong></th>
    <td><?if (!$info['type']) {?>充值<?}else{?>其他<?}?></td>
  </tr>
  <tr>
    <th><strong>会员描述：</strong>
    <td><?=$info['usernote']?></td>
  </tr>
  <tr>
    <th><strong>管理员备注：</strong>
    <td><textarea name="setting[adminnote]" cols="55" rows="5"><?=$info['adminnote']?></textarea></td>
  </tr>
  <tr>
  <tr>
    <th><strong>到款状态：</strong>
    <td><input type="radio" name="setting[ispay]" value="0" checked="true" />未确认
	<input type="radio" name="setting[ispay]" value="1" />已完成</td>
  </tr>
    <th>&nbsp;</th>
    <td><input type="hidden" name="" value="" />
      <input type="hidden" name="id" value="<?=$info['id']?>" />
      <input name="dosubmit" type="submit" value="确定" class="button" />
      <input type="reset" value="重置" class="button" /></td>
  </tr>
</table></form></body></html>
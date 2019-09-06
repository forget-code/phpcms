<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<script type="text/javascript" src="<?=PHPCMS_PATH?>images/js/validator.js"></script>
<body>
<form action="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>" method="post" name="myform">
<table cellpadding="0" cellspacing="1" class="table_form">
  <caption>
  <?=$typetitle?>点卡类型
  </caption>
  <tr>
    <th width="25%"><strong>名称</strong></th>
    <td width="75%"><input type="text" name="setting[name]" value="<?=$card['name']?>" size="30" require="true" datatype="require" msg="请填写类型名称" /></td>
  </tr>
  <tr>
    <th><strong>点数</strong></th>
    <td><input type="text" name="setting[point]" value="<?=$card['point']?>" size="10"  require="true" datatype="number" msg="必须为数字" msgid="point"/>点<span id="point"/></td>
  </tr>
  <tr>
    <th><strong>价格</strong></th>
    <td><input type="text" name="setting[amount]" value="<?=$card['amount']?>" size="10"  require="true" datatype="number" msg="必须为数字" msgid="amount"/>元<span id="amount"/></td>
  </tr>
  <tr>
    <th>&nbsp;</th>
    <td>
    <input type="hidden" name="pointid" value="<?=$pointid?>" />
      <input type="submit" name="dosubmit" value=" 确定" />
      &nbsp; <input type="reset" name="reset" value="清除" /></td>
  </tr>
</table></form></body>
</html>
<script language="javascript" type="text/javascript">
$().ready(function() {
	  $('form').checkForm(1);
	});
</script>
<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<script type="text/javascript" src="<?=PHPCMS_PATH?>images/js/validator.js"></script>
<body>
<table cellpadding="0" cellspacing="0" class="table_info">
  <caption>查询点卡</caption>
  <tr>
    <td>
      <a href="<?='?mod=pay&file=card&action=list'?>">全部点卡</a> | <a href="<?='?mod='.$mod.'&file='.$file.'&action=list&status=notused'?>">未使用的点卡</a> | <a href="<?='?mod='.$mod.'&file='.$file.'&action=list&status=used'?>">已使用的点卡</a>
    </td>
  </tr>
</table>
<!--标签页-->
<form name="myform" method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>">
<table cellpadding="0" cellspacing="1" class="table_form">
  <caption>批量产生点卡</caption>
  <tr>
    <th width="25%"><strong>点卡数量</strong></th>
    <td width="75%">
		<input name="cardnum" TYPE="text" value="100" size="15" msgid="code3"  require="true" datatype="number" msg="请输入数字"  />(只能是数字)<span id="code3"></span>
	</td>
  </tr>
  <tr>
    <th><strong>点卡类型</strong></th>
    <td>
		<?=form::select($cardtype,'ptypeid','','选择类型','require="true" datatype="require" msg="请选择类型"')?>
	</td>
  </tr>
  <tr>
    <th><strong>卡号前缀</strong></th>
    <td width="75%">
	   <input name="prefix" TYPE="text" value="<?=date("Y")?>" size="15"  msgid="code1" require="true" datatype="number" msg="请输入数字" /> (只能是数字)<span id="code1"></span>
	</td>
  </tr>
  <tr>
    <th><strong>卡号长度</strong></th>
    <td><input name="carlength" type="text" value="16" size="15" msgid="code2"  require="true" datatype="number" msg="请输入数字" /> (只能是数字)<span id="code2"></span></td>
  </tr>
  <tr>
    <th><strong>有效期</strong></th>
    <td><?=form::date('endtime')?>(留空默认过期时间为2年)<span id="code2"></span></td>
  </tr>
  <tr>
    <th>&nbsp;</th>
    <td>
		<input class="button_style" type="submit" name="dosubmit" value="产生点卡">
		<input class="button_style" type="reset" name="reset" value="重置">
	</td>
  </tr>
</table></form>
</body>
</html>
<script language="javascript" type="text/javascript">
$().ready(function() {
	  $('form').checkForm(1);
	});
</script>

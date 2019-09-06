<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<script type="text/javascript" src="images/js/validator.js"></script>
<body>
<!--标签页-->
<form method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>" >
<table cellpadding="0" cellspacing="1" class="table_form">
  <caption>
  添加财务
  </caption>
  <tr>
    <th width="25%"><strong>操作类型</strong></th>
    <td width="75%">
		<input type="radio" checked="" value="1" name="typeid" class="radio_style"/>&nbsp;入款(+)&nbsp;&nbsp;
		<input type="radio" value="0" name="typeid" class="radio_style"/>&nbsp;扣款(-)&nbsp;
	</td>
  </tr>
  <tr>
    <th><strong>充值类型</strong></th>
    <td>
        <input type="radio" checked="" value="amount" name="type" class="radio_style" onclick="javascript:change(1);"/>&nbsp;资金&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="radio" value="point" name="type" class="radio_style" onclick="javascript:change();"/>&nbsp;点数&nbsp;&nbsp;
	</td>
  </tr>
  <tr>
    <th><strong><span style="color:red;">*</span>用户名</strong></th>
    <td width="75%">
	   <input type="text" id = "username" name="username" value="<?=$username?>" size="20"  require="true" datatype="require|ajax" url="?mod=<?=$mod?>&file=<?=$file?>&action=checkuser"  msg="用户名不能为空|" />
	</td>
  </tr>
  <tr>
    <th><strong>数量</strong></th>
    <td><input type="text" name="number" value="<?=$amount?>" size="10"  require="true" datatype="currency|limit" max="6" msg="请输入数字|最大为6位" msgid="code1"/>&nbsp;<font id = "numberid" name="numberid" style="color:red">元</font><span id="code1"></span>
    </td>
  </tr>
  <tr>
    <th><strong>交易事由</strong></th>
    <td><textarea name="note" cols="60" rows="8"><?=$note?></textarea>&nbsp;<font style="color:red"></font></td>
  </tr>
  <tr>
    <th>&nbsp;</th>
    <td>
		<input type="hidden" name="forward" value="<?=$forward?>">
	    <input type="submit" name="dosubmit" value=" 确定 ">&nbsp;&nbsp;&nbsp;&nbsp;
	    <input type="reset" name="reset" value=" 重置 ">
	</td>
  </tr>
</table>
</form>
</body>
</html>
<script language="javascript" type="text/javascript">
function change(msg)
{
    if(msg == 1)
    {
        $('#numberid').html("元");
    }
    else
    {
        $('#numberid').html("点");
    }
}
$().ready(function() {
	  $('form').checkForm(1);
	});
</script>
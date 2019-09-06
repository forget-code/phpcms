<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<script type="text/javascript" src="images/js/validator.js"></script>
<body>
<form name="myform" method="post" action="?mod=mail&file=<?=$file?>&action=setting" >
<table cellpadding="0" cellspacing="1" class="table_form">
  <caption>获取邮件列表</caption>
  <tr>
      <th width="25%"><font color="red">*</font> 数据库来源</th>
      <td>
        <?=form::select($data, 'dataname', 'dataname', '请选择', $dataname, '')?>&nbsp;&nbsp;&nbsp;<a href="?mod=phpcms&file=datasource&action=add&forward=<?=urlencode(URL)?>">添加新数据源</a>
	  </td>
  </tr>
  <tr>
    <th><font color="red">*</font> 保存邮件列表的文件名<br />
      只能是英文，字母，下划线组成</th>
    <td>
	  <input name="mailname" type="text" value="<?php echo 'mailfiles_'.date('Ymdhis'); ?>" size="30" require="true" datatype="require" msg="不能为空" msgid = "msgid1"/>
	  .txt<span id="msgid1"/>
    </td>
  </tr>
  <tr>
  <th></th>
    <td>
    <input type="submit" name="submit" value=" 确定 " />
    <input type="reset" name="reset" value=" 重置 " />
    </td>
</tr>
</table>
</form>
<table cellspacing="1" cellpadding="2" border="0" class="table_info">
  <caption>提示信息</caption>
  <tr>
    <td>
<strong>PHPCMS 邮箱地址导出提示信息：</strong>
<br/>
1、通过配置数据源，配置好你想导出的邮箱的数据源<br/>
	</td>
  </tr>
</table>
</body>
</html>
<script language="javascript" type="text/javascript">
$().ready(function() {
	 $('form').checkForm(1);
	});
</script>
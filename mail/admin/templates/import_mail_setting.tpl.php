<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<script type="text/javascript" src="images/js/validator.js"></script>
<body>
<form name="myfrom" method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=setting">
<input name="setting[dataname]" type="hidden" value="<?=$setting['dataname']?>">
<input name="setting[mailname]" type="hidden" value="<?=$mailname?>">
<input name="type" value="<?=$type?>" type="hidden">
<table cellpadding="0" cellspacing="1" class="table_form">
	<caption><?=$name?>设置</caption>
    <tr>
    	<th width="20%"><strong>选择的数据源</strong></th>
        <td><?=$dataname?></td>
    </tr>
    <tr>
    	<th><strong>数据表</strong></th>
        <td><input type="text" name="setting[table]" value="<?=$setting['table'] ?$setting['table'] :$data['dbname']?>" size="40" require="true" datatype="safeString" msg="请输入正确的数据表名"/></td>
    </tr>
    <tr>
		<th><strong>数据提取E-mail字段</strong></th>
		<td><input type="text" name="setting[email]" value="<?=$setting['email']?$setting['email']:''?>" size="40" require="true" datatype="safeString" msg="请输入正确的E-mail字段名"/></td>
	</tr>
	<tr>
		<th><strong>数据提取条件</strong><br />例如：userid = 1</th>
		<td><input type="text" name="setting[condition]" value="<?=$setting['condition']?$setting['condition']:''?>" size="40" /></td>
	</tr>
</table>
<table cellpadding="0" cellspacing="1" class="table_form">
    <caption>用户数据导入执行设置</caption>
    <tr>
      <th width="20%"><strong>每次提取并导入数据条数</strong></th>
      <td><input type="text" name="setting[number]" value="<?=$setting['number']?$setting['number']:100?>" size="20" require="true" datatype="number" msg="请输入数字"> 条</td>
    </tr>
    <tr>
      <th><strong>php脚本执行超时时限</strong><br />当数据较多时程序执行时间会较长</th>
      <td><input type="text" name="setting[expire]" value="<?=$setting['expire']?$setting['expire']:90?>" require="true" datatype="number" msg="请输入数字"></td>
    </tr>
    <tr>
     <th>&nbsp;</th>
     <td>
       <input type="submit" name="dosubmit" value="提交">
       <input type="reset" name="reset" value="取消">
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
1、填写数据源对应的E-mail数据表<br/>
2、填写数据表中E-mai对应的字段<br/>
3、数据提取条件是导出的过滤条件，如(addtime >000000 and userid > 100)<br/>
	</td>
  </tr>
</table>
</body>
<script language="javascript" type="text/javascript">
$().ready(function() {
	  $('form').checkForm(1);
	});
</script>
</html>

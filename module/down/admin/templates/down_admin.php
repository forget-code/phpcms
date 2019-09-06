<?php include admintpl('header'); ?>

<body>
<br />
<?php echo $dwonmenu; ?>
<form name="form1" id="form1" method="post" action="">
<table align="center" cellpadding="2" cellspacing="1" class="tableborder">
	<tr><th colspan="2">管理选项</th>
	<tr>
		<td class="tablerow">
		<input type="radio" name="passed" value="all" />所有
		<input type="radio" name="passed" value="0" />待审核
		<input type="radio" name="passed" value="1" />已审核
		<input name="istop" type="checkbox" id="istop" value="1" />置顶
		<input name="iselite" type="checkbox" id="iselite" value="1" />推荐
	</td>
	<td class="tablerow">
		<select name="select">
		<option selected>软件名称</option>
		</select>
		<select name="select">
		<option selected>所有栏目</option>
		</select>
		<input name="keywords" type="text" id="keywords" value="关键字">
		<input name="submit" type="submit" id="submit" value=" 搜 索 ">
	</td>
	</tr>
</table>
</form>
<form name="form1" id="form1" method="post" action="">
  <table width="100%" align="center" cellpadding="2" cellspacing="1" class="tableborder">
  <th colspan="8">下载管理</th>
    <tr align="center">
      <td width="4%" class="tablerowhighlight">选中</td>
      <td width="9%" class="tablerowhighlight">ID</td>
      <td width="20%" class="tablerowhighlight">名称</td>
      <td width="12%" class="tablerowhighlight">添加者</td>
      <td width="8%" class="tablerowhighlight">软件属性</td>
      <td width="8%" class="tablerowhighlight">下载次数</td>
      <td width="8%" class="tablerowhighlight">审核状态</td>
      <td width="31%" class="tablerowhighlight">管理操作</td>
    </tr>
    <tr>
      <td class="tablerow">&nbsp;</td>
      <td class="tablerow">&nbsp;</td>
      <td class="tablerow">&nbsp;</td>
      <td class="tablerow">&nbsp;</td>
      <td class="tablerow">&nbsp;</td>
      <td class="tablerow">&nbsp;</td>
      <td class="tablerow">&nbsp;</td>
      <td class="tablerow">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="8" class="tablerow">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="8" class="tablerow">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="8" class="tablerow"><input type="checkbox" name="checkbox" value="checkbox">
        全选/不选</td>
    </tr>
  </table>
</form>

</body>
</html>

<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td ></td>
  </tr>
</table>
<?=$menu?>
<table cellpadding="2" cellspacing="1" class="tableborder">
<form action="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>&confirm=1" method="post" name="myform">
  <tr>
    <th colspan=2>安装模块</th>
  </tr>
    <tr>
    <td class="tablerowhighlight" colspan=2>第一步：填写模块目录</td>
  </tr>
	<tr> 
      <td class="tablerow">模块目录</td>
      <td class="tablerow">
          <input type="text" name="installdir" size="30">
       </td>
    </tr>
    <tr> 
      <td class="tablerow"></td>
      <td class="tablerow"> 
	  <input type="submit" name="submit" value=" 下一步 "> 
      &nbsp; <input type="button" name="cancel" value=" 取消安装 " onclick="window.location='?mod=<?=$mod?>&file=module'">
	  </td>
    </tr>
	</form>
</table>
</body>
</html>
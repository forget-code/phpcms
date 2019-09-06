<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include managetpl('header');
?>
<br>
<form name="myform1" method="post" action="">

<table cellpadding="2" cellspacing="1" border="0" align="center" class="tableBorder" >
  <tr>
    <td class="submenu" align="center" colspan="2" width='10%'>导航菜单管理</td>
  </tr>
  <tr>
    <td class="tablerow" valign="middle">系统菜单：</td><td class="tablerow">
	<?=$menus?>
</td>
  </tr>
  <tr >
    <td class="tablerow" valign="middle">用户菜单:</td>
<td class="tablerow"><textarea name='usermenu' cols='100' rows='8'><?=$usermenu?></textarea>
<BR>例子：<BR>
我的菜单1|http://www.phpcms.cn/<BR>
我的菜单2|http://down.phpcms.cn/
</td>
  </tr>
</table>
<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
  <tr>
     <td width="40%"></td>
     <td><input type="submit" name="dosubmit" value=" 确定 ">&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="reset" value=" 重置 "></td>
  </tr>
</table>
</form>
<BR>
<table cellpadding="2" cellspacing="1" border="0" align="center" class="tableBorder" >
  <tr>
    <td class="submenu" align="center">提示信息</td>
  </tr>
  <tr>
    <td class="tablerow">
<font color="blue">重新选择模板后，需要更新下缓存和重新生成列表才能显示最新的模板。</font>
</td>
  </tr>
</table>
</body>
</html>
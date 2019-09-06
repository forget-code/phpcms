<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
$rulecontent=file_get_contents("http://www.phpcms.cn/spider/rulemgt.php?action=getcontent&type=$type&id=$id");
?>
<body>
<script language='JavaScript'>
function checkform()
{
	var obj1 = document.getElementById("jobSiteId");
	if(obj1.value=="0")
	{
		alert("您还没有选择该任务所属站点！");
		return false;
	}
	return true;
}
</script>

<table cellpadding="0" cellspacing="0" border="0" width="100%" height="5">
  <tr>
    <td></td>
  </tr>
</table>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="5">
  <tr>
    <td></td>
  </tr>
</table>
<table cellpadding="2" cellspacing="1" class="tableborder">

<form action="?mod=<?=$mod?>&file=rulemgr&action=installjob" method="post" enctype="multipart/form-data" name="formimport" id="formimport" >
  <table width="100%" border="0" align="center" cellpadding="2" cellspacing="1" class="tableborder">
    <tr>
      <th colspan="3">在线安装共享任务规则</th>
    </tr>
    <tr>
      <td colspan="2" class="tablerow">选择任务站点</td>
      <td class="tablerow"><?=$site_select?></td>
    </tr>
    <tr>
      <td colspan="2" class="tablerow">操作</td>
      <td class="tablerow">
      <textarea name="rulecontent" style="display:none"><?=$rulecontent?></textarea>
	  <input name="submit" type="submit" id="submit" value=" 导 入 " onclick="return checkform();" />&nbsp;
	  <input name="reset" type="reset" id="reset" value=" 清 除 " />
      </td>
    </tr>
  </table>
</form>


<table width="100%" height="30" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align=center></td>
  </tr>
</table>

<table cellpadding="2" cellspacing="1" border="0" align=center class="table_info" >
  <tr>
    <td class="submenu" align=center>提示信息</td>
  </tr>
  <tr>
    <td class="tablerow">
	  <p>这里将从官方共享区直接下载站点或任务规则，安装后即可直接使用！</p>    </td>
  </tr>
</table>
</body>
</html>
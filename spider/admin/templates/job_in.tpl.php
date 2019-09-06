<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<script language='JavaScript'>
function checkform()
{
	var obj1 = document.getElementById("jobSiteId");
	var obj2 = document.getElementById("uploadfile");
	if(obj1.value=="0")
	{
		alert("您还没有选择该任务所属站点！");
		return false;
	}
	else if(obj2.value=="")
	{
		alert("您还没有选择任何.pjob任务文件");
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
<?=$menu?>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="5">
  <tr>
    <td></td>
  </tr>
</table>
<table cellpadding="2" cellspacing="1" class="table_form">

<form action="?mod=<?=$mod?>&file=jobmgr&action=jobin" method="post" enctype="multipart/form-data" name="formimport" id="formimport" >
  <table width="100%" border="0" align="center" cellpadding="2" cellspacing="1" class="table_form">
	<caption>导入任务规则</caption>
    <tr>
      <td colspan="2" class="tablerow">选择任务站点</td>
      <td class="tablerow"><?=$site_select?></td>
    </tr>
    <tr>
      <td colspan="2" class="tablerow">导入任务文件(.pjob)</td>
      <td class="tablerow">
	  <input name="uploadfile" type="file"  id="uploadfile" size="40" /></td>
    </tr>
    <tr>
      <td colspan="2" class="tablerow">操作</td>
      <td class="tablerow">
	  <input name="uploadjob" type="submit" id="submit" value=" 导 入 " onclick="return checkform();" />&nbsp;
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
  <caption>提示信息</caption>
  <tr>
    <td class="tablerow">
	  <p>请到官方网站与大家共享更多的采集站点规则和任务规则，导入后即可直接使用！</p>    </td>
  </tr>
</table>
</body>
</html>
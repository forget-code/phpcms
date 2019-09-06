<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
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
<?=$menu?>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="5">
  <tr>
    <td></td>
  </tr>
</table>
<table cellpadding="2" cellspacing="1" class="tableborder">

<form action="?mod=<?=$mod?>&file=jobmgr&jobid=<?=$jobid?>&action=jobcopy" method="post" name="formimport" id="formimport" >
  <table width="100%" border="0" align="center" cellpadding="2" cellspacing="1" class="tableborder">
    <tr>
      <th colspan="3">复制粘贴任务</th>
    </tr>
    <tr>
      <td colspan="2" class="tablerow">选择任务站点</td>
      <td class="tablerow"><?=$site_select?></td>
    </tr>
    <tr>
      <td colspan="2" class="tablerow">粘贴任务</td>
      <td class="tablerow">
	  <input name="copyjob" type="submit" id="submit" value=" 开 始 " onclick="return checkform();" />&nbsp;
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
</body>
</html>
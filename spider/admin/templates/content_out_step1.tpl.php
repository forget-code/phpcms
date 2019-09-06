<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<script language='JavaScript'>
function checkform()
{
	var obj2 = document.getElementById("catid");
	if(obj2.value=="0")
	{
		alert("您还没有选择栏目");
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
<form method="post" name="myform">
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="5">
  <tr>
    <td></td>
  </tr>
</table>
<table cellpadding="2" cellspacing="1" class="table_form">
<th colspan=10><a href="?mod=<?=$mod?>&file=<?=$file?>&action=outcontent"><font color="white">发布内容</font></a></th>
<tr align="center">
<td colspan="10" class="tablerowhighlight">第一步:  选择发布到的栏目</td>
</tr>
<tr>
<td colspan="3"></td>
</tr>
<tr>
<td  align="right" class="tablerow"><strong>选择栏目&nbsp;&nbsp;</strong></td>
<td width="60%"  class="tablerow"><input name="job[CatId]" id="catid" type="hidden" size="10" value="<?=$job_CatId?>"/>
	<?=form::select_category('phpcms', 0, 'parentid', 'parentid', '无（作为一级栏目）', $job_CatId,$cat_js)?>&nbsp;<font color="Red">*</font></td>
<td width="10%"  class="tablerow"></td>
</tr>
<tr align="center">
<td colspan="3"></td>
</tr>
</table>
<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0"  class="table_form">
  <tr>
    <td align="center">
<input type="submit" name="submit" value="下一步" onClick="if(checkform()) document.myform.action='?mod=<?=$mod?>&file=collect&action=outcontent&jobid=<?=$jobid?>&step=2'">&nbsp;&nbsp;&nbsp;&nbsp;
</td>
  </tr></form>
</table>
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
	  <p>选择系统频道和相应栏目后，您可以将您采集的数据内容发布到不同的频道及栏目中去，该处两项必选！</p>    </td>
  </tr>
</table>
</body>
</html>
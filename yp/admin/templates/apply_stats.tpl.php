<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<?=$menu?>

<table width="100%" height="25" border="0" cellpadding="3" cellspacing="0" class="tableborder">
  <tr>
    <td class="tablerow"> <img src="<?=PHPCMS_PATH?>admin/skin/images/pos.gif" align="absmiddle" alt="当前位置" > 当前位置：<a href="?mod=<?=$mod?>&file=<?=$file?>&action=manage">招聘首页</a> &gt;&gt; 招聘统计报表</td>
  </tr>
</table>

<table width="100%" cellpadding="0" cellspacing="0">
<tr>
<td height="10"> </td>
</tr>
</table>

<table cellpadding="3" cellspacing="1" class="tableborder">
  <tr>
    <th colspan="7">招聘统计报表</th>
  </tr>
<tr align="center">
<td width="10%" class="tablerowhighlight">ID</td>
<td width="20%" class="tablerowhighlight">岗位名称</td>
<td class="tablerowhighlight">数目</td>
</tr>
<?=$station?>
<tr align="center" height="25">
<td class="tablerow"><font color="blue"><b>总 数</b></font></td>
<td class="tablerow" colspan=2><font color="red"><?php echo $total; ?></font></td>
</tr>
</table>


<table width="100%" cellpadding="0" cellspacing="0">
<tr>
<td height="10"> </td>
</tr>
</table>

</body>
</html>
<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<?=$menu?>

<table width="100%" height="25" border="0" cellpadding="3" cellspacing="0" class="tableborder">
  <tr>
    <td class="tablerow"> <img src="<?=PHPCMS_PATH?>admin/skin/images/pos.gif" align="absmiddle" alt="当前位置" > 当前位置：<a href="?mod=<?=$mod?>&file=<?=$file?>&action=manage">新闻首页</a> &gt;&gt; 新闻统计报表</td>
  </tr>
</table>

<table width="100%" cellpadding="0" cellspacing="0">
<tr>
<td height="10"> </td>
</tr>
</table>

<table cellpadding="3" cellspacing="1" class="tableborder">
  <tr>
    <th colspan="7">新闻统计报表</th>
  </tr>
<tr align="center">
<td width="10%" class="tablerowhighlight">ID</td>
<td width="20%" class="tablerowhighlight">栏目名称</td>
<td class="tablerowhighlight">已通过</td>
<td class="tablerowhighlight">待审核</td>
<td class="tablerowhighlight">回收站</td>
</tr>
<?=$categorys?>
<tr align="center">
<td width="10%" class="tablerowhighlight">ID</td>
<td width="20%" class="tablerowhighlight">栏目名称</td>
<td class="tablerowhighlight">已通过</td>
<td class="tablerowhighlight">待审核</td>
<td class="tablerowhighlight">回收站</td>
</tr>
<tr align="center" height="25">
<td class="tablerow"><font color="blue"><b>总 数</b></font></td>
<td class="tablerow"><font color="red"><?php echo $sum_3+$sum_1+$sum__1; ?></font></td>
<td class="tablerow"><font color="red"><?=$sum_3?></font></td>
<td class="tablerow"><font color="red"><?=$sum_1?></font></td>
<td class="tablerow"><font color="red"><?=$sum__1?></font></td>
</tr>
</table>


<table width="100%" cellpadding="0" cellspacing="0">
<tr>
<td height="10"> </td>
</tr>
</table>

<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th>统计查询</th>
  </tr>

<form name="search" action="?" method="get">
<tr>
  <td class="tablerow" height="30">
  <input name='mod' type='hidden' value='<?=$mod?>'>
  <input name='file' type='hidden' value='<?=$file?>'>
  <input name='action' type='hidden' value='<?=$action?>'>
  <input name='channelid' type='hidden' value='<?=$channelid?>'>
  用户名：<input name='username' type='text' size='20' value='<?=$username?>'>&nbsp;&nbsp;&nbsp;&nbsp;发布时间：<?=date_select('fromdate', $fromdate)?> 至 <?=date_select('todate', $todate)?>&nbsp;格式：yyyy-mm-dd&nbsp;&nbsp;<input name='search' type='submit' value=' 查询 '> <input  type='button' value=' 重查 ' onclick="window.location='?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>&channelid=<?=$channelid?>'">
  </td>
</tr>
</form>
</table>
</body>
</html>
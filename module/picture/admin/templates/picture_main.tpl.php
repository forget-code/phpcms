<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<?=$menu?>

<table width="100%" height="25" border="0" cellpadding="3" cellspacing="0" class="tableborder">
  <tr>
    <td class="tablerow"> <img src="<?=PHPCMS_PATH?>admin/skin/images/pos.gif" align="absmiddle" alt="当前位置" > 当前位置：<a href="?mod=<?=$mod?>&file=<?=$file?>&action=main&channelid=<?=$channelid?>">图片首页</a> &gt;&gt; </td>
    <td class="tablerow" align="right"><?php echo $category_jump; ?></td>
  </tr>
</table>

<table width="100%" cellpadding="0" cellspacing="0">
<tr>
<td height="10"> </td>
</tr>
</table>

<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan="4">图片管理</th>
  </tr>
<tr align="center">
<td width="10%" class="tablerowhighlight">ID</td>
<td width="20%" class="tablerowhighlight">栏目名称</td>
<td width="15%" class="tablerowhighlight">图片总数</td>
<td class="tablerowhighlight">管理操作</td>
</tr>
<?=$categorys?>
</table>
</body>
</html>
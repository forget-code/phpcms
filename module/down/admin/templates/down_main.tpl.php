<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<?=$menu?>

<table width="100%" height="25" border="0" cellpadding="3" cellspacing="0" class="tableborder">
  <tr>
    <td class="tablerow"> <img src="<?=PHPCMS_PATH?>admin/skin/images/pos.gif" align="absmiddle" alt="当前位置" > 当前位置：<a href="?mod=<?=$mod?>&file=<?=$file?>&action=main&channelid=<?=$channelid?>">下载首页</a> &gt;&gt; </td>
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
    <th colspan="4">下载管理</th>
  </tr>
<tr align="center">
<td width="10%" class="tablerowhighlight">ID</td>
<td width="20%" class="tablerowhighlight">栏目名称</td>
<td width="15%" class="tablerowhighlight">下载总数</td>
<td class="tablerowhighlight">管理操作</td>
</tr>
<?=$categorys?>
</table>


<table width="100%" cellpadding="0" cellspacing="0">
<tr>
<td height="10"> </td>
</tr>
</table>

<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th>批量添加下载</th>
  </tr>
  
<tr>
<td class="tablerow">&nbsp;<font color="red">Tips:</font> 本功能允许您将服务器端指定目录的文件批量添加至下载列表中</td>
</tr>

<tr>
<td class="tablerow" height="30">&nbsp;
<font color="blue">模式一：</font><a href="?mod=<?=$mod?>&file=<?=$file?>&action=add_batch_local&channelid=<?=$channelid?>">从本服务器添加</a>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<font color="blue">模式二：</font><a href="?mod=<?=$mod?>&file=<?=$file?>&action=add_batch_remote&channelid=<?=$channelid?>">从远程FTP服务器添加</a>
</td>
</tr>
</table>

</body>
</html>
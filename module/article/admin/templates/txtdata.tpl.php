<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<?=$menu?>

<table width="100%" height="25" border="0" cellpadding="3" cellspacing="0" class="tableborder">
  <tr>
    <td class="tablerow"> <img src="<?=PHPCMS_PATH?>admin/skin/images/pos.gif" align="absmiddle" alt="当前位置" > 当前位置：<a href="?mod=<?=$mod?>&file=<?=$mod?>&action=main&channelid=<?=$channelid?>">文章首页</a> &gt;&gt; 文本数据管理 </td>
  </tr>
</table>

<table width="100%" cellpadding="0" cellspacing="0">
<tr>
<td height="10"> </td>
</tr>
</table>

<table cellpadding="2" cellspacing="1" border="0" align=center class="tableBorder" >
  <tr>
    <th colspan="4">批量数据转换</th>
  </tr>
<tr align="center">
<td width="25%" class="tablerowhighlight">文章起始ID</td>
<td width="25%" class="tablerowhighlight">文章结束ID</td>
<td width="25%" class="tablerowhighlight">每轮转换文章数</td>
<td width="25%" class="tablerowhighlight">管理操作</td>
</tr>
<form method="post" name="myform2" action="?mod=<?=$mod?>&file=<?=$file?>&channelid=<?=$channelid?>">
<input type="hidden" name="action" value="database2txt" id="action">
  <tr align="center">
    <td class="tablerow"><input name="fid" type="text" size="15" value="<?=$minarticleid?>"></td>
    <td class="tablerow"><input name="tid" type="text" size="15" value="<?=$maxarticleid?>"></td>
    <td class="tablerow"><input name="pernum" type="text" size="15" value="100"></td>
    <td class="tablerow"><input name='submit' type='submit' value='数据库转文本'>&nbsp;&nbsp;<input onclick="$('action').value='txt2database';" type="submit" value="文本转数据库" ></td>
  </tr>
</form>
</table>

<table width="100%" cellpadding="0" cellspacing="0">
<tr>
<td height="10"> </td>
</tr>
</table>

<table cellpadding="2" cellspacing="1" border="0" align="center" class="tableborder" >
  <tr>
    <th>清空操作</th>
  </tr>

    <tr>
    <td class="tablerow">&nbsp;&nbsp;<font color="red">以下操作非常危险，请谨慎！！！</font></td>
  </tr>
 
  <tr height="30">
    <td class="tablerow">
	
	&nbsp;&nbsp;<input type='button' value=' 清空内容数据库数据 ' onclick="if(confirm('你确认清空内容数据库数据？此操作不可恢复，确定继续？')) window.location='?mod=<?=$mod?>&file=<?=$file?>&action=deldatabase&channelid=<?=$channelid?>'">

	&nbsp;&nbsp;当模块配置里，启用了文本存储时，方可执行此操作(<a href="?mod=phpcms&file=database" target="_blank">当前存放表为<?=channel_table('article_data', $channelid)?></a>)

  </tr>

  <tr height="30">
    <td class="tablerow">
	
	&nbsp;&nbsp;<input type='button' value=' 清空内容文本数据 ' onclick="if(confirm('你确认清空内容文本数据？此操作不可恢复，确定继续？')) window.location='?mod=<?=$mod?>&file=<?=$file?>&action=deltxt&channelid=<?=$channelid?>'">

	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;当模块配置里，启用了数据库存储时，方可执行此操作(<a href="?mod=phpcms&file=filemanager&dir=./data/<?=$MOD['storage_dir']?>/<?=$channelid?>/" target="_blank">当前存放目录为./data/<?=$MOD['storage_dir']?>/<?=$channelid?>/</a>)

  </tr>

</table>

<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td></td>
  </tr>
</table>

</body>
</html>
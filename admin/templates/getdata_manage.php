<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<?=$menu?>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td></td>
  </tr>
</table>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=6>外部数据导入管理 [注:仅限文章模块和会员模块数据导入]</th>
  </tr>
<form method="post" name="myform">
<tr align="center">
<td class="tablerowhighlight">配置名称</td>
<td class="tablerowhighlight">配置说明</td>
<td class="tablerowhighlight">修改时间</td>
<td class="tablerowhighlight">上次提取时间</td>
<td class="tablerowhighlight">管理操作</td>
</tr>
<? if(is_array($getdatas)) foreach($getdatas AS $g) { ?>
<tr align="center" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5' height="23">
<td><?=$g[name]?></td>
<td align="left"><?=$g[introduce]?></td>
<td><?=$g[edittime]?></td>
<td><?=$g[gettime]?></td>
<td><a href="#" onclick="javascript:confirmurl('?mod=<?=$mod?>&file=<?=$file?>&channelid=<?=$channelid?>&action=get&name=<?=$g[name]?>','确认开始导入数据吗？')">导入数据</a> | <a href='?mod=<?=$mod?>&file=<?=$file?>&channelid=<?=$channelid?>&action=config&name=<?=$g[name]?>'>修改</a> | <a href="#" onclick="javascript:confirmurl('?mod=<?=$mod?>&file=<?=$file?>&channelid=<?=$channelid?>&action=delete&name=<?=$g[name]?>','确认删除此配置文件吗？本操作不可恢复')">删除</a> | <a href='?mod=<?=$mod?>&file=<?=$file?>&channelid=<?=$channelid?>&action=down&name=<?=$g[name]?>'>下载配置</a> </td>
</tr>
<? } ?>
</table>
</form>
</body>
</html>
<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<?=$menu?>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=6>外部数据导入管理</th>
  </tr>
<form method="post" name="myform">
<tr align="center">
<td class="tablerowhighlight">配置名称</td>
<td class="tablerowhighlight">配置说明</td>
<td class="tablerowhighlight">修改时间</td>
<td class="tablerowhighlight">上次提取时间</td>
<td class="tablerowhighlight">管理操作</td>
</tr>
<?php foreach($settings AS $setting) { ?>
<tr align="center" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5' height="23">
<td><a href='?mod=<?=$mod?>&file=<?=$file?>&action=setting&name=<?=$setting['name']?>'><?=$setting['name']?></a></td>
<td align="left"><?=$setting['note']?></td>
<td><?=date('Y-m-d h:i:s', $setting['edittime'])?></td>
<td><?=$setting['importtime'] ? date('Y-m-d h:i:s', $setting['importtime']) : ''?></td>
<td><a href="#" onclick="javascript:confirmurl('?mod=<?=$mod?>&file=<?=$file?>&action=import&name=<?=$setting['name']?>','确认开始导入数据吗？')">导入数据</a> | <a href='?mod=<?=$mod?>&file=<?=$file?>&action=setting&name=<?=$setting['name']?>'>修改</a> | <a href="#" onclick="javascript:confirmurl('?mod=<?=$mod?>&file=<?=$file?>&action=delete&name=<?=$setting['name']?>','确认删除此配置文件吗？本操作不可恢复')">删除</a> | <a href='?mod=<?=$mod?>&file=<?=$file?>&action=down&name=<?=$setting['name']?>'>下载配置</a> </td>
</tr>
<? } ?>
</table>
</form>
</body>
</html>
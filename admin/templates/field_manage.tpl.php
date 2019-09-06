<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<?=$menu?>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan="8">自定义字段管理</th>
  </tr>
<tr align="center">
<td width="5%" class="tablerowhighlight">ID</td>
<td width="15%" class="tablerowhighlight">字段名称</td>
<td width="15%" class="tablerowhighlight">字段标题</td>
<td width="20%" class="tablerowhighlight">字段说明</td>
<td width="15%" class="tablerowhighlight">字段类型</td>
<td width="10%" class="tablerowhighlight">默认值</td>
<td width="10%" class="tablerowhighlight">搜索条件</td>
<td width="10%" class="tablerowhighlight">管理操作</td>
</tr>
<?php 
if(is_array($fieldlist)){
	foreach($fieldlist as $fieldinfo){
?>
<tr align="center" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
<td class="tablerow"><?=$fieldinfo['fieldid']?></td>
<td class="tablerow"><?=$fieldinfo['name']?></td>
<td class="tablerow"><?=$fieldinfo['title']?></td>
<td class="tablerow"><?=$fieldinfo['note']?></td>
<td class="tablerow"><?=$fieldinfo['type']?></td>
<td class="tablerow"><?=$fieldinfo['defaultvalue']?></td>
<td class="tablerow"><?php if($fieldinfo['enablesearch']){ ?>是 <?php }else{ ?>否 <?php } ?> </td>
<td class="tablerow">
<a href='?mod=<?=$mod?>&channelid=<?=$channelid?>&file=field&action=edit&fieldid=<?=$fieldinfo['fieldid']?>&tablename=<?=$tablename?>'>修改</a> | 
<a href='?mod=<?=$mod?>&channelid=<?=$channelid?>&file=field&action=delete&fieldid=<?=$fieldinfo['fieldid']?>&tablename=<?=$tablename?>&forward=<?=urlencode($PHP_URL)?>'>删除</a>
</td>
</tr>
<?php 
	}
}
?>
</table>
</body>
</html>
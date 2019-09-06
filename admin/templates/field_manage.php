<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td ></td>
  </tr>
</table>
<?=$menu?>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td ></td>
  </tr>
</table>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=8>自定义字段管理</th>
  </tr>
<tr align=center>
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
if(is_array($fields)){
	foreach($fields as $field){
?>
<tr align=center onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
<td class=forumrow><?=$field['fieldid']?></td>
<td class=forumrow><?=$field['fieldname']?></td>
<td class=forumrow><?=$field['title']?></td>
<td class=forumrow><?=$field['note']?></td>
<td class=forumrow><?=$field['fieldtype']?></td>
<td class=forumrow><?=$field['defaultvalue']?></td>
<td class=forumrow><?php if($field['enablesearch']){ ?>是 <?php }else{ ?>否 <?php } ?> </td>
<td class=forumrow>
<a href='?mod=<?=$mod?>&channelid=<?=$channelid?>&file=field&action=edit&fieldid=<?=$field[fieldid]?>'>修改</a> | 
<a href='?mod=<?=$mod?>&channelid=<?=$channelid?>&file=field&action=delete&fieldid=<?=$field[fieldid]?>&fieldname=<?=$field[fieldname]?>'>删除</a>
</td>
</tr>
<?php 
	}
}
?>
</table>
</body>
</html>
<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<?php
if($action=='manage')
{
	?>

<form method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=listorder">
<table cellpadding="0" cellspacing="1" class="table_list">
  <caption>招聘岗位管理</caption>
  <tr>
    <th width="60">排序</th>
    <th width="40">ID</th>
    <th>岗位名称</th>
    <th width="100">管理操作</th>
	 <th width="60">排序</th>
    <th width="40">ID</th>
    <th>岗位名称</th>
    <th width="100">管理操作</th>
  </tr>
<?php
if(is_array($infos)){
$cols = 0;
	foreach($infos as $info){
if($cols%2==0) echo "<tr>";
?>
<td style="text-align:center"><input type="text" name="info[<?=$info['typeid']?>]" value="<?=$info['listorder']?>" size="5"></td>
<td style="text-align:center"><?=$info['typeid']?></td>
<td style="text-align:left"> <?=$info['name']?></td>
<td style="text-align:center"><a href="?mod=<?=$mod?>&file=<?=$file?>&action=edit&typeid=<?=$info['typeid']?>&module=<?=$module?>">修改</a> | <a href="###" onClick="javascript:confirmurl('?mod=<?=$mod?>&file=<?=$file?>&action=delete&typeid=<?=$info['typeid']?>&module=<?=$module?>','确认要删除<?=$info['name']?>吗？')">删除</a> </td>
<?php
if($cols%2==1) echo "</tr>";
$cols++;
	}
}
?>
</table>
<div class="button_box"><input type="submit" value=" 更新排序 " size="4" name="submit"/></div>
</form>
<?php
}
else
{
?>
<form name="addform" method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=edit">
<table cellpadding="0" cellspacing="1" class="table_form">
  <caption>修改岗位</caption>
<tr>
<td class="align_c">
岗位名称：<input type="text" name="info[name]" size="20" value="<?=$name?>"/>&nbsp;
<input type="submit" name="dosubmit" value=" 确认修改 " />
<input type="hidden" name="typeid" value="<?=$typeid?>" />
</td>
</tr>
</table>
</form>
<?php
}
?>
<form name="addform" method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=add">
<table cellpadding="0" cellspacing="1" class="table_form">
  <caption>添加新岗位</caption>
<tr>
<td class="align_c">
岗位名称：<input type="text" name="station" size="20" />&nbsp;
<input type="submit" name="dosubmit" value=" 新增岗位 " />
</td>
</tr>
</table>
</form>

</body>
</html>
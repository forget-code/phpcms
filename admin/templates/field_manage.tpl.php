<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
$formtypes = array('text'=>'单行文本', 'textarea'=>'多行文本', 'select'=>'下拉框', 'radio'=>'单选框', 'checkbox'=>'多选框', 'password'=>'密码框', 'hidden'=>'隐藏域');
$inputtools = array('dateselect'=>'日期选择', 'fileupload'=>'文件上传', 'imageupload'=>'图片上传', 'styleedit'=>'样式设置', 'editor'=>'可视化编辑器');
?>
<body>
<?=$menu?>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan="11">自定义字段管理</th>
  </tr>
<tr align="center">
<td width="6%" class="tablerowhighlight">排序</td>
<td width="5%" class="tablerowhighlight">ID</td>
<td width="15%" class="tablerowhighlight">字段标题</td>
<td width="15%" class="tablerowhighlight">字段名称</td>
<td width="*" class="tablerowhighlight">字段类型</td>
<td width="10%" class="tablerowhighlight">表单类型</td>
<td width="12%" class="tablerowhighlight">辅助工具</td>
<td width="6%" class="tablerowhighlight">列表</td>
<td width="6%" class="tablerowhighlight">搜索</td>
<td width="10%" class="tablerowhighlight">管理操作</td>
</tr>
<form method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=listorder&channelid=<?=$channelid?>&tablename=<?=$tablename?>">
<?php 
if(is_array($fieldlist)){
	foreach($fieldlist as $fieldinfo){
?>
<tr align="center" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
<td class="tablerow"><input type="text" name="listorder[<?=$fieldinfo['fieldid']?>]" value="<?=$fieldinfo['listorder']?>" size="3"></td>
<td class="tablerow"><?=$fieldinfo['fieldid']?></td>
<td class="tablerow" align="left"><?=$fieldinfo['title']?></td>
<td class="tablerow" align="left"><?=$fieldinfo['name']?></td>
<td class="tablerow"><?=$fieldinfo['type']?>(<?=$fieldinfo['size']?>)</td>
<td class="tablerow"><?=$formtypes[$fieldinfo['formtype']]?></td>
<td class="tablerow"><?=$inputtools[$fieldinfo['inputtool']]?></td>
<td class="tablerow"><?=($fieldinfo['enablelist'] ? '√' : '')?></td>
<td class="tablerow"><?=($fieldinfo['enablesearch'] ? '√' : '')?></td>
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
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="30">
  <tr>
    <td><input name="dosubmit" type="submit" value=" 排序 "></td>
  </tr>
</table>
</form>
</body>
</html>
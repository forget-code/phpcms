<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<?=$menu?>
<form name="myform" method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>">
<input type="hidden" name="keyid" value="<?=$keyid?>" />
<table align="center" cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan="8">自由调用分类管理</th>
  </tr>
<tr align="center">
<td class="tablerowhighlight" width="8%">删除</td>
<td class="tablerowhighlight" width="20%">分类名称</td>
<td class="tablerowhighlight" width="8%">链接数</td>
<td class="tablerowhighlight" width="15%">显示方式</td>
<td class="tablerowhighlight" width="8%">宽度</td>
<td class="tablerowhighlight" width="8%">高度</td>
<td class="tablerowhighlight">调用标签</td>
<td class="tablerowhighlight">操作</td>
</tr>
<?php 
	foreach($types as $id=>$type)
	{ 
?>
<tr align="left" onMouseOut="this.style.backgroundColor='#F1F3F5'" onMouseOver="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'> 
<td align="center"><input type="checkbox" name="type[<?=$id?>][delete]" value="1" /></td>
<td align="center"><input type="hidden" name="type[<?=$id?>][name]" value="<?=$type['name']?>"><a href="?mod=<?=$mod?>&file=<?=$file?>&action=manage&type=<?=urlencode($type['name'])?>" title="点击管理该分类的链接"><?=$type['name']?></a></td>
<td align="center"><input type="text" name="type[<?=$id?>][number]" value="<?=$type['number']?>" size="3"></td>
<td align="center">
<select name="type[<?=$id?>][showtype]">
<option value="freelink_list" <?=($type['showtype'] == 'freelink_list' ? 'selected' : '')?>>文字链接1</option>
<option value="freelink_list-wbtj" <?=($type['showtype'] == 'freelink_list-wbtj' ? 'selected' : '')?>>文字链接2</option>
<option value="freelink_thumb" <?=($type['showtype'] == 'freelink_thumb' ? 'selected' : '')?>>图片链接</option>
<option value="freelink_slide" <?=($type['showtype'] == 'freelink_slide' ? 'selected' : '')?>>幻灯片链接</option>
<option value="freelink_slide-3d" <?=($type['showtype'] == 'freelink_slide-3d' ? 'selected' : '')?>>幻灯片3d-flash</option>
</select>
</td>
<td align="center"><input type="text" name="type[<?=$id?>][width]" value="<?=$type['width']?>" size="3"></td>
<td align="center"><input type="text" name="type[<?=$id?>][height]" value="<?=$type['height']?>" size="3"></td>
<td align="center">{tag_<?=$type['name']?>}</td>
<td align="center"><a href="?mod=<?=$mod?>&file=<?=$file?>&action=manage&type=<?=urlencode($type['name'])?>">管理</a> | <a href="?mod=<?=$mod?>&file=<?=$file?>&action=preview&type=<?=urlencode($type['name'])?>" target="_blank">预览</a></td>
</tr>
<?php 
	}
$n = $id+1;
?>
<tr align="left" onMouseOut="this.style.backgroundColor='#F1F3F5'" onMouseOver="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
<td align="right">增加：</td>
<td align="center"><input type="text" name="type[<?=$n?>][name]" size="15"></td>
<td align="center"><input type="text" name="type[<?=$n?>][number]" size="3" value="5"></td>
<td align="center">
<select name="type[<?=$n?>][showtype]">
<option value="freelink_list">文字链接1</option>
<option value="freelink_list-wbtj">文字链接2</option>
<option value="freelink_thumb">图片链接</option>
<option value="freelink_slide">幻灯片链接</option>
<option value="freelink_slide-3d">幻灯片3d-flash</option>
</select>
</td>
<td align="center"><input type="text" name="type[<?=$n?>][width]" size="3" value="200"></td>
<td align="center"><input type="text" name="type[<?=$n?>][height]" size="3" value="200"></td>
<td></td>
<td></td>
</tr>
</table>

<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="15%">
	<input name='chkall' title="全部选中" type='checkbox' id='chkall' onclick='checkall(this.form)' value='checkbox' /> 全选/不选
	</td>
	<td>
	<input type="submit" name="dosubmit" value=" 更新分类 " /> &nbsp;<font color="red">注意:选中分类表示删除该分类</font>
	</td>
  </tr>
</table>
</form>
</body>
</html>
<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<?=$menu?>
<form name="myform" method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>&type=<?=urlencode($type)?>">
<input type="hidden" name="keyid" value="<?=$keyid?>" />
<table align="center" cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan="4"><?=$type?>管理</th>
  </tr>
<tr align="center">
<td class="tablerowhighlight">删除</td>
<td class="tablerowhighlight">标题</td>
<td class="tablerowhighlight">链接</td>
<td class="tablerowhighlight">图片</td>
</tr>
<?php 
	foreach($freelinks as $id=>$freelink)
	{ 
?>
<tr align="left" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'  <?if($freelink['disabled']) echo " style='color:#888888;'";?> title="单击√×启用或禁用该分类"> 
<td align="center"><input type="checkbox" name="freelink[<?=$id?>][delete]" value="1" /></td>
<td align="center"><input type="text" name="freelink[<?=$id?>][title]" value="<?=$freelink['title']?>" size="35" style="width:250px;<?=$freelink['style']?>"> <?=style_edit('freelink['.$id.'][style]', $freelink['style'])?></td>
<td align="center"><input type="text" name="freelink[<?=$id?>][url]" value="<?=$freelink['url']?>" size="25"></td>
<td align="center"><input type="text" name="freelink[<?=$id?>][image]" id="image<?=$id?>" value="<?=$freelink['image']?>" size="20"> <input type="button" name="upload<?=$id?>" value="上 传" onClick="javascript:openwinx('?mod=phpcms&file=uppic&uploadtext=image<?=$id?>','upload','350','200')"></td>
</tr>
<?php 
	}
    $n = $id + 1;
    for($i = $n; $i < $n + $number; $i++)
    {
?>
<tr align="left" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
<td align="center"></td>
<td align="center"><input type="text" name="freelink[<?=$i?>][title]" size="35" style="width:250px;"> <?=style_edit('freelink['.$i.'][style]')?></td>
<td align="center"><input type="text" name="freelink[<?=$i?>][url]" size="25"></td>
<td align="center"><input type="text" name="freelink[<?=$i?>][image]" id="image<?=$i?>" size="20">  <input type="button" name="upload<?=$id?>" value="上 传" onClick="javascript:openwinx('?mod=phpcms&file=uppic&uploadtext=image<?=$i?>','upload','350','200')"></td>
</tr>
<?php 
	}
?>
</table>

<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="15%">
	<input name='chkall' title="全部选中" type='checkbox' id='chkall' onclick='checkall(this.form)' value='checkbox' /> 全选/不选
	</td>
	<td>
	<input name="dosubmit" type="submit" value=" 更新链接 " />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<input name="preview" type="button" value=" 预览 " onclick="window.open('?mod=<?=$mod?>&file=<?=$file?>&action=preview&type=<?=urlencode($type)?>')" />
	</td>
  </tr>
</table>
</form>
</body>
</html>
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
<form name="myform" method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>">
<input type="hidden" name="keyid" value="<?=$keyid?>" />
<table align="center" cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan="9">评论管理</th>
  </tr>
<tr align="center">
<td width="10%" class="tablerowhighlight">排序</td>
<td class="tablerowhighlight">图片</td>
<td  width="20%" class="tablerowhighlight">预览</td>
<td  width="10%" class="tablerowhighlight">管理操作</td>
</tr>
<?php 
	foreach($smilies as $id=>$smile)
	{ 
?>
<tr  align="center" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'> 
<td><input type="text" name="listorder[<?=$id?>]" value="<?=$smile['listorder']?>" size="3"></td>
<td align="left">&nbsp;&nbsp;<input type="text" name="src[<?=$id?>]" id="src<?=$id?>" value="<?=$smile['img']?>" size="50">&nbsp;&nbsp;
<a href="###" onclick="$('preview<?=$id?>').src=$('src<?=$id?>').value">预览</a></td>
<td width="20%"><img id="preview<?=$id?>" src="<?=PHPCMS_PATH?><?=$smile['img']?>" border="0" /></td>
<td><a href="javascript:if(confirm('确认删除该表情吗？')) location='?mod=<?=$mod?>&file=<?=$file?>&action=delete&smilesrc=<?=basename($smile['img'])?>'">删除</a></td>
</tr>
<?php 
	}
?>
  <tr  bgcolor="#F1F3F5">
    <td colspan="10">&nbsp;
	</td>
  </tr>
<tr align="left" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
<td align="center" colspan="1">增加：</td>
<td colspan="4">上传gif表情图片： <input name='newsmile' type='text' id='newsmile' size='45' maxlength='50'> <input type="button" value=" 上传 " onclick="javascript:openwinx('?mod=<?=$mod?>&file=uppic&uploadtext=newsmile&rename=smile_<?php echo $id+2;?>.gif&width=100&height=100','upload','350','200')">
&nbsp;&nbsp;<input type="button" value=" 完 成 " onclick="window.location.reload();"></td>
</tr>
</table>

<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="35%">
	</td>
	<td>
	<input name="dosubmit" type="submit" value=" 更新评论标签缓存 " />
	</td>
  </tr>
</table>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td></td>
  </tr>
</table>
<table cellpadding="0" cellspacing="0" border="0" width="100%" class="tableborder">
  <tr>
    <td class="tablerow">&nbsp;<font color="Blue">提示信息：</font></br>&nbsp;请在删除表情或上传表情图标完成后，点击更新评论标签缓存按纽同步前台表情缓存</td>
  </tr>
</table>
</form>

</body>
</html>
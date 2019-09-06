<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td></td>
  </tr>
</table>
<?=$menu?>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=6>自定义标签管理</th>
  </tr>
<form method="post" name="myform">
<tr align="center">
<td width="8%" class="tablerowhighlight">选中</td>
<td width="12%" class="tablerowhighlight">标签名</td>
<td width="30%" class="tablerowhighlight">标签说明</td>
<td width="20%" class="tablerowhighlight">自定义标签</td>
<td width="10%" class="tablerowhighlight">是否启用</td>
<td width="20%" class="tablerowhighlight">管理操作</td>
</tr>
<?php 
if(is_array($mytags)){
	foreach($mytags as $tag){
?>
<tr align="center" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
<td><input type="checkbox" name="tagid[]"  id="tagid[]" value="<?=$tag[tagid]?>"></td>
<td><?=$tag[tagname]?></td>
<td align="left"><?=$tag[introduce]?></td>
<td>{$mytag('<?=$tag[tagname]?>')}</td>
<td><?php if($tag[passed]){?>是<?php }else{ ?>否<?php }?></td>
<td><?php if($tag[passed]){?><a href='?mod=<?=$mod?>&file=mytag&action=pass&val=0&channelid=<?=$channelid?>&tagid=<?=$tag[tagid]?>'>禁用</a><?php }else{ ?><a href='?mod=<?=$mod?>&file=mytag&action=pass&val=1&channelid=<?=$channelid?>&tagid=<?=$tag[tagid]?>'>启用</a><?php }?> | <a href='?mod=<?=$mod?>&file=mytag&action=edit&channelid=<?=$channelid?>&tagid=<?=$tag[tagid]?>'>修改</a> | <a href='?mod=<?=$mod?>&file=mytag&action=delete&channelid=<?=$channelid?>&tagid=<?=$tag[tagid]?>'>删除</a></td>
</tr>
<?php 
	}
}
?>
</table>
<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="10%"><input name='chkall' type='checkbox' id='chkall' onclick='checkall(this.form)' value='checkbox'>全部选中</td>
    <td>
<input type="submit" name="submit" value="删除选定的自定义标签" onClick="document.myform.action='?file=mytag&action=delete'">&nbsp;&nbsp;
 </td>
  </tr>
</table>
</form>
<br>
<table cellpadding="2" cellspacing="1" border="0" align=center class="tableBorder" >
  <tr>
    <td class="submenu" align=center>提示信息</td>
  </tr>
  <tr>
    <td class="tablerow">
	自定义标签内容中可以插入html代码，也可以插入多个函数标签或者变量标签，具有非常强的灵活性。
	<br>自定义标签与单网页或者自定义网页功能联合使用即可实现自由显示站内内容。
	</td>
  </tr>
</table>
</body>
</html>
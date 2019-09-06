<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
echo $menu;
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
function _submitform(formname,actionurl) {
  var f=$(formname);	
	if (!checkhased(f))	 {
		alert("您未选择记录。");
		return false;
	}
	if (!confirm('确定选择的记录?'))	{
		return false;
	}
  f.action = actionurl;
  f.submit();
}

function checkhased(form) {
  for(var i = 0;i < form.elements.length; i++) {
    var e = form.elements[i];
    if (e.type == 'checkbox' && e.disabled != true) {
			if (e.checked)	{
				return true;
			}
    }
  }
	return false;
}
//-->
</SCRIPT>
<table cellpadding="2" cellspacing="1" class="tableborder"><form method="post" name="myform">
  <tr>
    <th colspan=13><a href="?mod=<?=$mod?>&file=<?=$file?>&action=manage&channelid=<?=$channelid?>"><font color="white">广告位管理</font></a></th>
  </tr>
<tr align="center">
<td width="5%" class="tablerowhighlight">选中</td>
<td width="*" class="tablerowhighlight">广告位名称</td>
<td width="8%" class="tablerowhighlight">所属频道</td>
<td width="10%" class="tablerowhighlight">尺寸</td>
<td width="5%" class="tablerowhighlight">状态</td>
<td width="8%" class="tablerowhighlight">广告数</td>
<td width="8%" class="tablerowhighlight">价格</td>
<td width="35%" class="tablerowhighlight">管理操作</td>
</tr>
<?php 
if(is_array($places)){
	foreach($places as $place){
?>
<tr align="center" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
<td><input type="checkbox" name="placeid[]"  id="placeid[]" value="<?=$place['placeid']?>"></td>
<td> <A HREF="?mod=ads&file=adsplace&action=view&placeid=<?=$place['placeid']?>" target="_blank"><?=$place['placename']?></A></td>
<td><?=$place['channelid']?$CHANNEL[$place['channelid']]['channelname']:"全站"?></td>
<td><?=$place['width']?>x<?=$place['height']?></td>
<td><?=$place['passed']?"<b style='color:green'>开放</b>":"<b style='color:red'>锁定</b>"?></td>
<td><?=$place['ads']['users']?></td>
<td><?=$place['price']?>元</td>
<td>
<A HREF="?mod=ads&file=ads&action=add&placeid=<?=$place['placeid']?>&referer=<?=$referer?>">添加广告</A> | 
<A HREF="?mod=ads&file=adssign&action=manage&adsplaceid=<?=$place['placeid']?>">广告客户列表</A> | 
<A HREF="?mod=ads&file=<?=$file?>&action=edit&placeid=<?=$place['placeid']?>">编辑</A> | 
<A HREF="?mod=ads&file=<?=$file?>&action=loadjs&placeid=<?=$place['placeid']?>">调用代码</A>
</td>
</tr>
<?php 
	}
}
?>
</table>
<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="10%"><input name='chkall' type='checkbox' id='chkall' onclick='checkall(this.form)' value='checkbox'>全选/反选</td>
    <td>
<input type="submit" name="submit" value="批量锁定" onClick="_submitform('myform','?mod=<?=$mod?>&file=<?=$file?>&action=lock&val=0');">&nbsp;&nbsp;
<input type="submit" name="submit" value="批量解锁" onClick="_submitform('myform','?mod=<?=$mod?>&file=<?=$file?>&action=lock&val=1');">&nbsp;&nbsp;
<input type="submit" name="submit" value="批量删除" onClick="_submitform('myform','?mod=<?=$mod?>&file=<?=$file?>&action=delete');">&nbsp;&nbsp;
</td>
  </tr></form>
</table>
<table width="100%" height="30" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align=center><?=$pages?></td>
  </tr>
</table>

<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td></td>
  </tr>
</table>
</body>
</html>
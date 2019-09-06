<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<?=$menu?>

<SCRIPT LANGUAGE="JavaScript">
<!--
function _submitform(formname,actionurl) {
  var f=$(formname);	
	if (!checkhased(f))	 {
		alert("您未选择记录。");
		return false;
	}
	if (!confirm('确认操作?'))	{
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

<div style="width:100%;text-align:right;margin-bottom: 5px;">
广告位选择:&nbsp;<?php echo $adsplaces_select;?>
<?php echo $ads_expired_select; ?>
</div>

<table cellpadding="2" cellspacing="1" class="tableborder"><form method="post" name="myform">
  <tr>
    <th colspan=13><a href="?mod=<?=$mod?>&file=<?=$file?>&action=manage&adsplaceid=<?=$adsplaceid?>"><font color="white"><?=($adsplaceid ? '['.$adsplaces[$adsplaceid]['placename'].'] ' : '')?>广告管理</font></a></th>
  </tr>
<tr align="center">
<td width="5%" class="tablerowhighlight">选中</td>
<td width="*" class="tablerowhighlight">广告名称</td>
<td width="15%" class="tablerowhighlight">所属广告位</td>
<td width="10%" class="tablerowhighlight">当前客户</td>
<td width="10%" class="tablerowhighlight">起始日期</td>
<td width="10%" class="tablerowhighlight">结束日期</td>
<td width="8%" class="tablerowhighlight">点击数</td>
<td width="5%" class="tablerowhighlight">状态</td>
<td width="5%" class="tablerowhighlight">审核</td>
<td width="10%" class="tablerowhighlight">管理操作</td>
</tr>
<?php 
if(is_array($adssigns)){
	foreach($adssigns as $value){
?>
<tr align="center" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
<td><input type="checkbox" name="adsid[]"  id="adsid[]" value="<?=$value['adsid']?>"></td>
<td align="left">&nbsp;<A HREF="?mod=ads&file=<?php echo $file?>&action=view&adsid=<?=$value['adsid']?>" target="_blank"><?=$value['adsname']?></A></td>
<td><?=$value['placename']?></td>
<td><?=$value['username']?></td>
<td><?php echo date("Y.m.d",$value['fromdate'])?></td>
<td><?php echo date("Y.m.d",$value['todate'])?></td>
<td><?php echo $value['hits'];?></td>
<td><?php echo $value['status'];?></td>
<td><?php echo $value['checked'];?></td>
<td>
<A HREF="?mod=ads&file=<?=$file?>&action=edit&adsid=<?=$value['adsid']?>">修改</A>
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
<INPUT TYPE="hidden" name="referer" value="<?php echo $referer;?>">
<input type="submit" name="submit" value="批量锁定" onClick="_submitform('myform','?mod=<?=$mod?>&file=<?=$file?>&action=lock&val=0');">&nbsp;&nbsp;
<input type="submit" name="submit" value="批量解锁" onClick="_submitform('myform','?mod=<?=$mod?>&file=<?=$file?>&action=lock&val=1');">&nbsp;&nbsp;
<input type="submit" name="submit" value="批量审核通过" onClick="_submitform('myform','?mod=<?=$mod?>&file=<?=$file?>&action=checked&val=1');">&nbsp;&nbsp;
<input type="submit" name="submit" value="批量取消审核" onClick="_submitform('myform','?mod=<?=$mod?>&file=<?=$file?>&action=checked&val=0');">&nbsp;&nbsp;
<input type="submit" name="submit" value="批量删除" onClick="_submitform('myform','?mod=<?=$mod?>&file=<?=$file?>&action=delete');">&nbsp;&nbsp;</td>
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
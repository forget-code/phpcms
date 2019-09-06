<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include managetpl('header');
?>
<?=$menu?>
<script language="javascript">
<!--

function update(stockid)
{
	var checkurl = '<?=$SITEURL?>/yp/admin.php';
	var pars = "file=<?=$file?>&action=update&stockid="+stockid;
	var myAjax = new Ajax.Request(checkurl, {method: 'post', parameters: pars, onComplete: alertmessage});
}

function alertmessage(Request)
{
	alert('更新成功');
	window.location.reload();
}

//-->
</script>
<form action="" method="post" name="myform" >
<table width="100%"  border="0" cellpadding="2" cellspacing="1" class="tableborder">
<th colspan=7>人才管理</th>
<tr align="center">
<td width="30" class="tablerowhighlight">选中</td>
<td width="40" class="tablerowhighlight">ID</td>
<td width="100" class="tablerowhighlight">申请人</td>
<td width="80" class="tablerowhighlight">申请时间</td>
<td width="100" class="tablerowhighlight">招聘职位</td>
<td class="tablerowhighlight">标题</td>
<td width="70" class="tablerowhighlight">当前状态</td>
</tr>
<? if(is_array($stocks)) foreach($stocks AS $stock) { ?>
<tr align="center" onmouseout="this.style.backgroundColor='#F1F3F5'"  onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5' ondblclick="$('stock_<?=$stock['stockid']; ?>').checked = ($('stock_<?=$stock['stockid']; ?>').checked ? false : true);">
<td><input name="stockid[]" type="checkbox" value="<?=$stock['stockid']?>" id="stock_<?=$stock['stockid']?>"></td>
<td><?=$stock['stockid']?></td>
<td><?=$stock['username']?></td>
<td><?=$stock['addtime']?></td>
<td><?=$stock['station']?></td>
<td align="left"><a href="<?=$stock['linkurl']?>" target="_blank"><?=$stock['title']?></a></td>
<td>
<?php
if($stock['status']==0)
{
	echo '<a href="?file='.$file.'&action=show&stockid='.$stock["stockid"].'"><font color="#ff0000">未查看</font></a>';
}
elseif($stock['status']==1)
{
	echo '<a href="?file='.$file.'&action=show&stockid='.$stock["stockid"].'"><font color="#0000ff">未邀请</font></a>';
}
else
{
	echo '<a href="?file='.$file.'&action=show&stockid='.$stock["stockid"].'">已邀请</a>';
}
?>
</td>
</tr>
<? } ?>
</table>

<table width="100%" align="center" cellpadding="2" cellspacing="1" >
   <tr>
    <td width="100"><input name='chkall' type='checkbox' id='chkall' onclick='checkall(this.form)' value='check'>全选/反选</td>
    <td>
		<input type='submit' value='删除该人才信息' onClick="document.myform.action='?file=<?=$file?>&action=delete'">
</td>
  </tr>
</table>
</form>
<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align='center'><?=$pages?></td>
  </tr>
</table>
</form>
<br />


</body>
</html>

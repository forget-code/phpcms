<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include managetpl('header');
?>
<?=$menu?>
<form action="" method="post" name="myform" >
<table width="100%"  border="0" cellpadding="2" cellspacing="1" class="tableborder">
<th colspan=10>订单查看</th>
<tr align="center">
<td width="30" class="tablerowhighlight">选中</td>
<td width="40" class="tablerowhighlight">ID</td>
<td width="120" class="tablerowhighlight">订单号</td>
<td class="tablerowhighlight">订购物品</td>
<td class="tablerowhighlight">数量</td>
<td width="50" class="tablerowhighlight">联系人</td>
<td width="100" class="tablerowhighlight">联系电话</td>
<td width="120" class="tablerowhighlight">订购时间</td>
<td width="50" class="tablerowhighlight">状态</td>
</tr>
<? if(is_array($orders)) foreach($orders AS $order) { ?>
<tr align="center" onmouseout="this.style.backgroundColor='#F1F3F5'"  onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'  ondblclick="$('order_<?=$order['orderid']; ?>').checked = ($('order_<?=$order['orderid']; ?>').checked ? false : true);">
<td><input name="orderid[]" type="checkbox" value="<?=$order['orderid']?>" id="order_<?=$order['orderid']?>"></td>
<td><?=$order['orderid']?></td>
<td><a href="?mod=<?=$mod?>&file=<?=$file?>&action=view&orderid=<?=$order['orderid']?>"><?=$order['order_no']?></a></td>
<td><a href="<?=$order['linkurl']?>" target="_blank"><?=$order['title']?></a></td>
<td><?=$order['number']?></td>
<td><?=$order['linkman']?></td>
<td><?=$order['telephone']?></td>
<td><?=$order['addtime']?></td>
<td>
<a href="?mod=<?=$mod?>&file=<?=$file?>&action=view&orderid=<?=$order['orderid']?>"><?php if($order['status']) echo '已读'; else echo "<font color='#FF0000'>未查看</font>";?></a>
</td>
</tr>
<? } ?>
</table>

<table width="100%" align="center" cellpadding="2" cellspacing="1">
   <tr>
    <td width="100"><input name='chkall' type='checkbox' id='chkall' onclick='checkall(this.form)' value='check'>全选/反选</td>
    <td>
		<input type='submit' value='删除订单' onClick="document.myform.action='?file=<?=$file?>&action=delete'">
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
<table width="100%" cellpadding="0" cellspacing="0" class="tableborder">
<form method="get" name="search" action="?">
  <tr>
    <td height="30" class="tablerow" align="center">
	<input name='file' type='hidden' value='<?=$file?>'>
	<input name='action' type='hidden' value='<?=$action?>'>
	<input name='keywords' type='text' size='20' value='<?if(isset($keywords)){echo $keywords;}?>' onclick="this.value='';" title="关键词...">&nbsp;
	<select name="searchtype">
	<option value="order_no" <?if($searchtype=='order_no'){?>selected<?}?>>按订单号</option>
	<option value="linkman" <?if($searchtype=='linkman'){?>selected<?}?>>按联系人</option>
	<option value="username" <?if($searchtype=='username'){?>selected<?}?>>按会员名</option>
	<option value="unit" <?if($searchtype=='unit'){?>selected<?}?>>按单位</option>
	</select>&nbsp;
	<input name='pagesize' type='text' size='3' value='<?if(isset($pagesize)){echo $pagesize;}?>' title="每页显示的数据数目,最大值为500" maxlength="3"> 条数据/页
	<input type='submit' value=' 搜索 '></td>
  </tr>
</form>
</table>
</body>
</html>

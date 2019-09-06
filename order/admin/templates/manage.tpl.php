<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<form method="get" name="search" action="?" >
<table cellpadding="0" cellspacing="1" class="table_info">
  <caption>订单管理</caption>
  <tr>
  <td>订单状态：
<a href="?mod=<?=$mod?>&file=<?=$file?>&action=manage">全部</a> | 
<?php 
foreach($order->STATUS as $k=>$v)
{
	if($k) echo ' | ';
?>
<a href="?mod=<?=$mod?>&file=<?=$file?>&action=manage&status=<?=$k?>"><?=$v?></a>
<?php
}
?>
  </td>
  </tr>
 <tr>
  <td>
	<input name='action' type='hidden' value='<?=$action?>'>
	<input name='mod' type='hidden' value='<?=$mod?>'>
	<input name='file' type='hidden' value='<?=$file?>'>
    <select id="field" name="field">
      <option value="">交易状态</option>
<?php 
foreach($order->STATUS as $k=>$v)
{
	$selected = (is_numeric($status) && $k == $status) ? 'selected' : '';
?>
      <option value="<?=$k?>" <?=$selected?>><?=$v?></option>
<?php
}
?>
    </select>
	下单时间：<?=form::date('startdate', $startdate)?>~ <?=form::date('enddate', $enddate)?>
	付款金额：<input type="text" name="minamount" value="<?=$minamount?>" size="10"> ~ <input type="text" name="maxamount" value="<?=$maxamount?>" size="10">
    <select id="field" name="field">
      <option value="orderid" <?php if($field == 'orderid') echo 'selected';?>>订单ID</option>
      <option value="username" <?php if($field == 'username') echo 'selected';?>>用户名</option>
      <option value="userid" <?php if($field == 'userid') echo 'selected';?>>用户ID</option>
      <option value="goodsname" <?php if($field == 'goodsname') echo 'selected';?>>产品名称</option>
    </select>
    <input name='q' type='text' size='15' value='<?php if(isset($q)) echo $q;?>'>
    <select id="orderby" name="orderby">
      <option value="orderid desc" <?php if($orderby == 'orderid desc') echo 'selected';?>>ID降序</option>
      <option value="orderid asc" <?php if($orderby == 'orderid asc') echo 'selected';?>>ID升序</option>
      <option value="amount desc" <?php if($orderby == 'amount desc') echo 'selected';?>>金额降序</option>
      <option value="amount asc" <?php if($orderby == 'amount asc') echo 'selected';?>>金额升序</option>
    </select>
	<input type='submit' name="dosubmit" value='查询'>
  </td>
</tr>
</table>
</form>
<form name="myform" method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=delete">
<table cellpadding="0" cellspacing="1" class="table_list">
  <caption>订单列表</caption>
  <tr>
	<th width="40">选中</th>
    <th width="40">ID</th>
    <th>产品名称</th>
	<th width="80">付款金额</th>
	<th width="120">下单时间</th>
	<th width="80">买家</th>
	<th width="60">状态</th>
	<th width="120">管理操作</th>
  </tr>

<?php
	foreach($data as $n=>$r)
	{
?>
  <tr>
	<td><input name='orderid[]' type='checkbox' value='<?=$r['orderid']?>'></td>
    <td class="align_c"><a href="?mod=<?=$mod?>&file=<?=$file?>&orderid=<?=$r['orderid']?>&action=view"><?=$r['orderid']?></a></td>
    <td><a href="<?=$r['goodsurl']?>" target="_blank"><?=$r['goodsname']?></a></td>
	<td class="align_c"><?=$r['amount']?>元</td>
	<td><?=date('Y-m-d H:i:s', $r['time'])?></td>
	<td class="align_c"><a href="<?=member_view_url($r['userid'])?>"><?=$r['username']?></a></td>
	<td class="align_c"><?=$order->STATUS[$r['status']]?>
	<?php if($r['status'] == 0){ ?>
		<br /><a href="javascript:confirmurl('?mod=<?=$mod?>&file=<?=$file?>&action=cancel&orderid=<?=$r['orderid']?>&forward='+escape('<?=URL?>'), '确认删除此订单吗？');" style="color:red;font-weight:bold">取消订单</a>
	<?php }elseif($r['status'] == 1){ ?>
		<br /><a href="?mod=<?=$mod?>&file=<?=$file?>&action=deliver&orderid=<?=$r['orderid']?>" style="color:red;font-weight:bold">确认发货</a>
	<?php } ?>
	</td>
	<td class="align_c">
	    <a href="?mod=<?=$mod?>&file=<?=$file?>&action=view&orderid=<?=$r['orderid']?>">查看</a> |
        <?php if($r['status'] == 0){ ?>
		<a href="?mod=<?=$mod?>&file=<?=$file?>&action=edit&orderid=<?=$r['orderid']?>">修改</a> | 
		<?php }else{ ?>
		<font color="#cccccc">修改</font> | 
		<?php } ?>
		<a href="javascript:confirmurl('?mod=<?=$mod?>&file=<?=$file?>&action=delete&orderid=<?=$r['orderid']?>&forward='+escape('<?=URL?>'), '确认删除此订单吗？');">删除</a>
	</td>
   </tr>
<?php
    }
?>
</table>
<div class="button_box">
	<input type='button' name='selectall' title="全部选中" id='selectall' onclick="javascript:$('input[type=checkbox]').attr('checked', true);"  value="全 选" />
	<input type='submit' name='delete' value='批量删除'>&nbsp;
</div>
</form>
<div id="pages"><?=$pages?></div>
</body>
</html>




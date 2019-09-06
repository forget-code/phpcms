<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<style type='text/css'>
td {text-align:center;}
</style>
<script type="text/javascript" language="JavaScript">
function del_customer()
{
	var mycoler = document.getElementsByName("amountid[]");
	var flag = false;
	for(var i = 0; i< mycoler.length ;i++){
		if(mycoler[i].checked){
			flag = true;
			break;
		}
	}
	if(!flag){
		alert("请选择要删除的对象");
		return false;
	}
	var msg = "你真的要删除吗!!!";
	if(! window.confirm(msg)){
		return false;
	}
	document.getElementsByName("thisForm").submit();
}

function CheckedRev(){
	var arr = $(':checkbox');
	for(var i=0;i<arr.length;i++)
	{
		if (arr[i].checked = ! arr[i].checked)
		{
			$("#selectall").val("取消全选");
		}
        else
		{
			$("#selectall").val("全选");
		}

	}
}
</script>
<body>
<form name="searchForm" action="?" method="get">
<input type="hidden" name="mod" value="<?=$mod?>">
<input type="hidden" name="file" value="payonline">
<input type="hidden" name="action" value="list">
<table cellpadding="0" cellspacing="1" class="table_list">
   <caption>查询支付记录</caption>

  <tr>
	<th style="width:8%;">会员名称</th>
	<th style="width:25%;">申请时间</th>
    <th style="width:10%;">操作员</th>
    <th style="width:30%;">审核时间</th>
    <th style="width:15%;">支付方式</th>
    <th style="width:8%;">到款状态</th>
    <th>操作</th>
  </tr>
    <td><input type="text" size="10" name="username" VALUE="<?=$username?>" /></td>
    <td><?=form::date('addtimebe',$addtimebe?date('Y-m-d',$addtimebe):'')?>-<?=form::date('addtimeend',$addtimeend?date('Y-m-d',$addtimeend):'')?></td>
    <td><input type="text" size="10" name="inputer" VALUE="<?=$inputer?>" /></td>
    <td><?=form::date('paidtimebe',$paidtimebe?date('Y-m-d',$paidtimebe):'')?>-<?=form::date('paidtimeend',$paidtimeend?date('Y-m-d',$paidtimeend):'')?></td>
    <td><select name="payment">
	  <option value="">支付方式</option>
	  <?php
        foreach ($paytypes as $paytype ) {
            $selected = $payment == $paytype['pay_name'] ? "selected" : "";
		echo  "<option value=".$paytype['pay_name']." $selected>".$paytype['pay_name']."</option>\n";
	   }
       ?>
	  </select>
    </td>
    <td style="text-align:center;"><select name="ispay">
        <option value="-1">到款状态</option>
        <option value="0" <? if($ispay == 0){?>selected<?}?>>没完成</option>
        <option value="1" <? if($ispay ==1){?>selected<?}?>>已完成</option>
      </select>
    </td>
    <td><input type="submit" class="button" value="搜索"/></td>
  <tr>
  </tr>


</table></form>

<form method="POST" name="thisForm" action="?mod=<?=$mod?>&file=<?=$file?>&action=delete"  onsubmit="return del_customer();" >
<table cellpadding="0" cellspacing="1" class="table_list">
  <caption>管理支付记录</caption>
  <tr>
    <th style="width:30px;">全选</th>
	<th style="width:80px;">会员名称</th>
    <th style="width:110px;">申请时间</th>
	<th style="width:120px;">支付号</th>
    <th style="width:100px;">资金</th>
    <th style="width:80px;">支付方式</th>
    <th style="width:80px;">到款状态</th>
    <th style="width:80px;">操作员</th>
	<th style="width:130px;">审核时间</th>
    <th style="width:80px;">操作</th>
  </tr>

	 <?php foreach ($lists['info'] as $amount ) {?>
  <tr>
	<td class="align_c"><input type="checkbox" name="amountid[]" id="checkbox" value="<?=$amount['id']?>"/></td>
	<td><a href="?mod=member&file=member&action=view&userid=<?=$amount['userid']?>"><?=$amount['username']?></a></td>
    <td style="text-align:center;"><?=$amount['addtime']?></td>
	<td style="text-align:center;"><a href="?mod=<?=$mod?>&file=<?=$file?>&action=view&payid=<?=$amount['id']?>"><?=$amount['sn']?></a></td>
    <td align="right">￥<?=$amount['amount']?>元</td>
    <td><?=$amount['payment']?></td>
    <td style="text-align:center;"><?if ($amount['ispay']) {?>已经完<? }else{?>未确认<?}?></td>
    <td style="text-align:center;"><a href="?mod=member&file=member&action=view&userid=<?=$amount['inputerid']?>"><?=$amount['inputer']?></a></td>
	<td style="text-align:center;"><?=$amount['paytime']?></td>
	<td style="text-align:center;">
	<?php if(!$amount['ispay']){?>
	<a href="javascript:if(confirm('确定要审核吗？')) location='?mod=<?=$mod?>&file=<?=$file?>&action=check&id=<?=$amount['id']?>'">审核</a>
	<?php }else{ ?><span style="color:red">已审核</span><?php }?>
	</td>
  </tr>
	<?php } ?>
</table>

<div class="button_box">
  <input name='selectall' title="全部选中" type='button' id='selectall' onclick='javascript:CheckedRev();'  value="全选" />
  <input  type="submit" name="submit" value="删除" />
</div>
</form>
<!--分页-->
<div id="pages"><?=$pages?></div>
</body>
</html>

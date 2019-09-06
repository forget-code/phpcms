<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<script type="text/javascript" language="JavaScript">
function CheckedRev(){
	var arr = $(':checkbox');
	for(var i=0;i<arr.length;i++)
	{
		if (arr[i].checked = ! arr[i].checked)
		{
			$("#selectall").val("取消全选");
		}else
		{
			$("#selectall").val("全选");
		}

	}
}
function del_customer()
{
	var mycoler = document.getElementsByName("id[]");
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

</script>
<body>
<table cellpadding="0" cellspacing="1" class="table_list">
<caption>查询汇款</caption>
	<form name="searchForm" action="?" method="get">
    <input type="hidden" name="mod" value="<?=$mod?>">
    <input type="hidden" name="file" value="useramount">
    <input type="hidden" name="action" value="list">
   <tr>
	<th style="width:10%;">会员名称</th>
	<th style="width:18%;">申请时间</th>
    <th style="width:10%;">操作员</th>
    <th style="width:18%;">审核时间</th>
    <th >支付方式</th>
    <th >到款状态</th>
    <th >操作</th>
  </tr>
  <tr>
  <td class="align_c"><input type="text" size="10" name="username" VALUE="<?=$username?>" /></td>
  <td class="align_c"><?=form::date('addtimebe',$addtimebe?date('Y-m-d',$addtimebe):'')?>~<?=form::date('addtimeend',$addtimeend?date('Y-m-d',$addtimeend):'')?></td>
  <td class="align_c"><input type="text" size="10" name="inputer" VALUE="<?=$inputer?>" /></td>
  <td style="text-align:center;"><?=form::date('paidtimebe',$paidtimebe?date('Y-m-d',$paidtimebe):'')?>~<?=form::date('paidtimeend',$paidtimeend?date('Y-m-d',$paidtimeend):'')?></td>
  <td style="text-align:center;"><select name="payment">
	  <option value="">支付方式</option>
	  <?php
        foreach ($paytypes as $paytype ) {
            $selected = $payment == $paytype['pay_name'] ? "selected" : "";
		echo  "<option value=".$paytype['pay_name']." $selected>".$paytype['pay_name']."</option>\n";
	   }
       ?>
      </select>
  </td>
  <td style="text-align:center;"><select name="is_paid">
        <option value="-1">到款状态</option>
        <option value="0" <? if($is_paid == 0){?>selected<?}?>>未确认</option>
        <option value="1" <? if($is_paid == 1){?>selected<?}?>>已完成</option>
      </select>
  </td>
  <td style="text-align:center;"><input type="submit" class="button" value=" 搜索 "/></td>
  </tr>

  </form>
</table>

<form method="POST" name="thisForm" action="?mod=<?=$mod?>&file=<?=$file?>&action=del"  onsubmit="return del_customer();" >
<table cellpadding="0" cellspacing="1" class="table_list">
  <caption>管理汇款记录</caption>
  <tr>
    <th style="width:30px;">全选</th>
	<th style="width:80px;">会员名称</th>
    <th>申请时间</th>
	<th style="width:100px;">支付号</th>
    <th>资金</th>
    <th>支付方式</th>
    <th>到款状态</th>
    <th>操作员</th>
	<th>审核时间</th>
    <th style="width:60px;">操作</th>
  </tr>

	 <?php foreach ($amounts['info'] as $amount ) {?>
  <tr>
	<td class="align_c"><input type="checkbox" name="id[]" id="checkbox" value="<?=$amount['id']?>"/></td>
	<td><a href="?mod=member&file=member&action=view&userid=<?=$amount['userid']?>"><?=$amount['username']?></a></td>
    <td style="text-align:center;"><?=$amount['addtime']?></td>
	<td style="text-align:center;"><?=$amount['sn']?></td>
    <td style="text-align:center;">￥<?=$amount['amount']?>元</td>
    <td style="text-align:center;"><?=$amount['payment']?></td>
    <td style="text-align:center;"><?if ($amount['ispay']) {?>已经完<? }else{?>未确认<?}?></td>
    <td style="text-align:center;"><a href="?mod=member&file=member&action=view&userid=<?=$amount['inputerid']?>"><?=$amount['inputer']?></a></td>
	<td style="text-align:center;"><?=$amount['paytime']?></td>
	<td style="text-align:center;">
	<?if(!$amount['ispay']){?>
		<a href="javascript:if(confirm('确定要审核吗？')) location='?mod=<?=$mod?>&file=useramount&action=check&id=<?=$amount['id']?>'">审核
		<?}else{?>
		<a href="?mod=<?=$mod?>&file=useramount&action=list&id=<?=$amount['id']?>"><span style="color:red">查看</span></a>
		<?}?>
		<a href="javascript:if(confirm('确定要删除吗？')) location='?mod=<?=$mod?>&file=useramount&action=del&id=<?=$amount['id']?>'">删除</a>
    </td>
  </tr>
	<?php } ?>
</table>

<div class="button_box">
  <input name='selectall' title="全部选中" type='button' id='selectall' onclick='javascript:CheckedRev();'  value="全选" />
  <input type="submit" name="submit" value=" 删除" />
</div>
</form>
<!--分页-->
<div id="pages"><?=$pages?></div>
</body>
</html>

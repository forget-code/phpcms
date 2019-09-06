<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<script type="text/javascript" language="JavaScript">

//全选
function CheckedAll(){
	$(':checkbox').attr('checked','checked');
}

//全不选
function CheckedNo(){
	$(':checkbox').attr('checked','');
}

//反选
function CheckedRev(){
	var arr = $(':checkbox');
	for(var i=0;i<arr.length;i++)
	{
		arr[i].checked = ! arr[i].checked;
	}
}
function del_customer()
{
	var mycoler = document.getElementsByName("payid[]");
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
<?=$menu?>
<table cellpadding="0" cellspacing="1" class="table_list">
   <caption>查询交易记录</caption>
<form method="get" name="search" action="?">
<input name="mod" type="hidden" value="<?=$mod?>">
<input name="file" type="hidden" value="<?=$file?>">
<input name="action" type="hidden" value="list">
  <tr>
	<th style="width:10%;">用户名</th>
	<th style="width:10%;">模块</th>
    <th style="width:10%;">交易类型</th>
    <th style="width:25%;">交易时间</th>
    <th>交易数量</th>
    <th style="width:8%;">操作者</th>
    <th>操作</th>
  </tr>
  <tr>
	<td style="text-align:center;"><input name='username' type='text' value="<?=$username?>" size=12></td>
	<td style="text-align:center;"><select name="module" >
        <option value=''>不限</option>
        <?php
        if(is_array($MODULE)){
            foreach($MODULE as $k=>$m){
                $selected = $module==$k ? "selected" : "";
                echo "<option value='".$k."' $selected>".trim($m['name'])."</option>\n";
            }
        }
        ?>
        </select>
    </td>
    <td style="text-align:center;"><select name="type">
		<option value="">交易类型</option>
		<option value="amount" <?=($type == 'amount') ? 'selected' : ''?>>资金</option>
		<option value="point" <?=($type == 'point') ? 'selected' : ''?>>点数</option>
		</select>
    </td>
    <td style="text-align:center;"><?=form::date('begindate',$begindate)?>-<?=form::date('enddate',$enddate)?></td>
    <td style="text-align:center;" >
      <input type="text" size="10" id="beginnum" name="num1" value="<?=$num1?>"/>-<input type="text" size="10" id="endnum" name="num2" value="<?=$num2?>"/>
    </td>
    <td><input name='inputer' type='text' value="<?=$inputer?>" size=12></td>
    <td style="text-align:center;"><input name='submit' type='submit' value=' 搜索 '></td>
	</tr>
</table>
</form>
</table>
<form method="POST" name="thisForm" action="?mod=<?=$mod?>&file=<?=$file?>&action=delete"  onsubmit="return del_customer();" >
<table cellpadding="0" cellspacing="1" class="table_list">
  <caption>财务列表</caption>
  <tr>
    <th style="width:5%;">全选</th>
    <th style="width:6%;">用户名</th>
	<th style="width:8%;">交易模块</th>
	<th style="width:8%;"><a href="<?=RELATE_URL?>&sort=type&order=<?php if($order==''|| $order =='asc'){?>desc<?php }else{?>asc<?php }?>" title="点击排序">交易类型</a></th>
	<th style="width:6%;"><a href="<?=RELATE_URL?>&sort=number&order=<?php if($order==''|| $order =='asc'){?>desc<?php }else{?>asc<?php }?>" title="点击排序">数量</a></th>
	<th style="width:5%;"><a href="<?=RELATE_URL?>&sort=blance&order=<?php if($order==''|| $order =='asc'){?>desc<?php }else{?>asc<?php }?>" title="点击排序">余额</a></th>
    <th style="width:6%;">操作者</th>
	<th style="width:15%;"><a href="<?=RELATE_URL?>&sort=time&order=<?php if($order==''|| $order =='asc'){?>desc<?php }else{?>asc<?php }?>" title="点击排序">交易时间</a></th>
	<th style="width:16%;">交易地址</th>
	<th>说明</th>
  </tr>

	<?php
	foreach($exchanges['info'] as $exchange)
	{
	?>
	  <tr>
	<td class="align_c"><input type="checkbox" name="payid[]" id="checkbox" value="<?=$exchange['id']?>"/></td>
	<td style="text-align:center;"><a href="?mod=member&file=member&action=view&userid=<?=$exchange['userid']?>"><?=$exchange['username']?></a></td>
	<td style="text-align:center;"><?=$exchange['module']?></td>
	<td style="text-align:center;"><?=$exchange['type']?></td>
	<td style="text-align:center;"><?=$exchange['number']?></td>
	<td style="text-align:center;"><?=$exchange['blance']?></td>
	<td style="text-align:center;"><a href="?mod=member&file=member&action=view&userid=<?=$exchange['inputid']?>"><?=$exchange['inputer']?></a></td>
    <td style="text-align:center;"><?=$exchange['time']?></td>
	<td style="text-align:center;"><span title="<?=$exchange['ip_area']?>"><?=$exchange['ip']?></span></td>
	<td style="text-align:center;"><?=$exchange['note']?></td>
	</tr>
	<?php
	}
	?>
</table>
<table cellpadding="0" cellspacing="1" class="table_list">
<caption></caption>
<tr>
    <th>点数</th>
    <th>资金</th>
</tr>
<tr>
    <td style="text-align:center">
        <font style="color:red"><?=$exchanges['point']?>点</font>
    </td>
    <td style="text-align:center">
        <font style="color:red"><?=$exchanges['amount']?>元</font>
	</td>
  </tr>
</table>

<div class="button_box">
  <input type="button" name="selectall" id="selectall" value="全选" onclick='javascript:CheckedRev();' />
  <input type="submit"  value="删除" />
</div>
</form>
<!--分页-->
<div id="pages"><?=$pages?></div>
</body>
</html>

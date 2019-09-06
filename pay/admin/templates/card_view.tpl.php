<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<script type="text/javascript" language="JavaScript" >
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
<table cellpadding="0" cellspacing="0" class="table_info">
  <caption>查询点卡</caption>
  <tr>
    <td>
      <a href="<?='?mod=pay&file=card&action=list'?>">全部点卡</a> | <a href="<?='?mod='.$mod.'&file='.$file.'&action=list&status=notused'?>"> 未使用的点卡</a> | <a href="<?='?mod='.$mod.'&file='.$file.'&action=list&status=used'?>">已使用的点卡</a>
    </td>
  </tr>
</table>
<form method="post" name="myform" action="?mod=<?=$mod?>&file=<?=$file?>&action=delete" onSubmit="return del_customer();">
<table cellpadding="0" cellspacing="1" class="table_list">
  <caption>管理点卡</caption>
  <tr>
	<th width="5%">选中</th>
	<th width="13%">卡号</th>
	<th width="8%">类型</th>
	<th width="5%">面值</th>
	<th width="5%">点数</th>
    <th width="8%">有限期</th>
	<th width="8%">生成者</th>
	<th width="8%">使用者</th>
	<th width="8%">生成日期</th>
	<th width="8%">充值日期</th>
	<th width="6%">生成IP</th>
	<th width="15%">状态</th>
  </tr>
	<?php
	foreach($cards['info'] as $card)
	{
	?>
	<tr>
		<td class="align_c"><input type="checkbox" name="id[]"  id="id" value="<?=$card['id']?>"></td>
		<td><?=$card['cardid']?></td>
		<td style="text-align:center;"><?=$card['name']?></td>
		<td style="text-align:center;"><?=$card['amount']?></td>
		<td style="text-align:center;"><?=$card['point']?></td>
        <td style="text-align:center;"><?=$card['endtime']?></td>
		<td style="text-align:center;"><a href="?mod=member&file=member&action=view&userid=<?=$card['inputerid']?>"><?=$card['inputer']?></a></td>
		<td style="text-align:center;"><a href="?mod=member&file=member&action=view&userid=<?=$card['userid']?>"><?=$card['username']?></a></td>
		<td style="text-align:center;"><?=$card['mtime']?></td>
		<td style="text-align:center;"><?=$card['regtime']?></td>
		<td style="text-align:center;"><?=$card['regip']?></td>
		<td ><?php if($card['status']) { ?><span style="color:red">已使用</span><?php }else{?>未使用<?php } ?><?php if($card['endstatus']){ ?>|<span style="color:red;">过期</span><?php }?></td>
	</tr>
	<?php
		}
?>
</table>
<div class="button_box">
  <input type="button" name='selectall' id='selectall'  value="全选" onClick="javascript:CheckedRev();"/>
  <input type="submit" name="submit" value="删除"  />
</div>
</form>
<!--分页-->
<div id="pages"><?=$pages?></div>
</body>
</html>

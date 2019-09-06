<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<style type='text/css'>
td {text-align:center;}
</style>
<script type="text/javascript" src="<?=PHPCMS_PATH?>images/js/validator.js"></script>

<script type="text/javascript" language="JavaScript" >
function CheckedRev(){
	var arr = $(':checkbox');
	for(var i=0;i<arr.length;i++)
	{
		if (arr[i].checked = ! arr[i].checked)
		{
			$("#chkall").val("取消全选");
		}
        else
		{
			$("#chkall").val("全选");
		}

	}
}
function del_customer()
{
	var mycoler = document.getElementsByName("ids[]");
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
<form name="myform" method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=drop" onSubmit="return del_customer();">
<table cellpadding="0" cellspacing="1" class="table_list">
  <caption>管理点卡类型</caption>
  <tr>
    <th width="50px">全选</th>
    <th>ID</th>
	<th>名称</th>
	<th>点数</th>
	<th>价格</th>
    <th>操作</th>
  </tr>
	<?php
	foreach($pointcards['info'] as $id=>$point)
	{
	?>
	<tr>
        <td style="text-align:center;"><input type="checkbox" name="ids[]" id="typeid" value="<?=$id?>" /></td>
        <td style="text-align:center;"><?=$id?></td>
        <td style="text-align:center;"><?=$point['name']?></td>
        <td style="text-align:center;"><?=$point['point']?>点</td>
        <td style="text-align:center;"><?=$point['amount']?>元</td>
        <td style="text-align:center;"><a href="?mod=pay&file=pointcard&action=update&pointid=<?=$id?>" />修改</td>
	</tr>
	<?php
	}
	?>
</table>
<div class="button_box">
  <input name='chkall' title="全部选中" type='button' id='chkall' onclick='javascript:CheckedRev();'  value="全选" />
  <input type="submit" name="dosubmit" value="删除" />
</div>
</form>
<!--分页-->
<div id="pages"><?=$pages?></div>
</body>
</html>

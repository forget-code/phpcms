<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<?=$menu?>
<form action="?mod=<?=$mod?>&file=<?=$file?>&action=delete" method="post" onsubmit="return del_customer();">
<table width="100%" cellpadding="0" cellspacing="1"  class="table_list">
 <caption>会员头衔管理</caption>
	<tr>
		<th width="4%" >选</th>
		<th width="10%"  >ID</th>
		<th width="14%"  >所属系列</th>
		<th width="10%"  >等级</th>
		<th width="18%"  >头衔名称</th>
		<th width="30%"  >积分</th>
		<th width="15%"  >管理操作</th>
	</tr>		
<?php
	foreach ($infos as $info) {
?>
	<tr>
	   <td  style="text-align:center;"><input type="checkbox" name="id[]"  id="id" value="<?=$info['id']?>"></td>
		<td  style="text-align:center;"><?=$info['id']?></td>
		<td  style="text-align:center;"><?=$TYPES[$info['typeid']]?></td>
		<td  style="text-align:center;"><?=$info['grade']?></td>
		<td  style="text-align:center;"><?=$info['actor'];?></td>
		<td  style="text-align:center;"><?=$info['min'];?>&nbsp;--&nbsp;<?=$info['max']?></td>
		<td  style="text-align:center;"><a href="?mod=<?=$mod?>&file=<?=$file?>&action=edit&id=<?=$info['id']?>&typeid=<?=$info['typeid']?>">修改</a> | <a href="?mod=<?=$mod?>&file=<?=$file?>&action=delete&id=<?=$info['id']?>&typeid=<?=$info['typeid']?>" onclick="return confirm('您确定要删除此项吗？')">删除</a>
		</td>
	</tr>
<?php
}
?>
</tbody>
</table>
<div class="button_box">
<input type="button" name="selectall" id="selectall" value="全选" onclick='javascript:CheckedRev();' />
<input type="hidden" name="dosubmit" value="submitted">
<input type="submit" name="dosubmit" value="删除选定" >
</div>
</form>
<div id="pages"><?=$actor->pages?></div>
</body>
</html>
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

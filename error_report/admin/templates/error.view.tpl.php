<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<table width="100%" cellspacing="1" cellpadding="0" class="table_list">
<caption>搜索报告</caption>
	<tr class="">
		<td class="align_left">
        <a href="?mod=error_report&file=error_report&action=list" />错误报告|<a href="?mod=error_report&file=error_report&action=list&status=1" />已审核报告|<a href="?mod=error_report&file=error_report&action=list&status=0"/>未审核报告</td>
	</tr>
</table>
<form action="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>" method="post" name="thisform">
<table cellpadding="0" cellspacing="1" class="table_list">
  <caption>错误报告</caption>
  <tr>
    <th style="width:5%">全选</th>
    <th style="width:8%">错误类型</th>
    <th>标题</th>
    <th>内容</th>
    <th>报告地址</th>
	<th>用户名</th>
    <th style="width:10%">提交时间</th>
	<th width="15%">管理操作</th>
  </tr>
<?
  foreach($error['info'] as $error)
  {
?>
  <tr>
    <td style="text-align:center;"><input type="checkbox" name="errorid[]" id="errorid" value="<?=$error['error_id']?>"/></td>
    <td style="text-align:center;"><?=output::style($TYPE[$error['typeid']]['name'], $TYPE[$error['typeid']]['style'])?></td>
    <td style="text-align:center;"><a href="?mod=phpcms&file=content&action=edit&catid=0&contentid=<?=$error['contentid']?>"><?=$error['error_title']?></a></td>
    <td style="text-align:center;"><?=$error['error_text']?></td>
	<td style="text-align:center;"><a href="<?=$error['error_link']?>" target="_blank"><?=$error['error_link']?></a></td>
    <td style="text-align:center;"><? if($error['userid']) {?><a href="?mod=member&file=member&action=view&userid=1"><?=$error['username']?></a><?}else{?> <?=$error['username']?><?}?></td>
	<td style="text-align:center;"><?=date('Y-m-d', $error['addtime'])?></td>
	<td style="text-align:center;"><a href="?mod=phpcms&file=content&action=edit&catid=0&contentid=<?=$error['contentid']?>">原文</a> | <? if ($error['status']){?>已审核<?  }else{ ?><a href="javascript:if(confirm('确定要审核该条记录吗？')) location='?mod=<?=$mod?>&file=<?=$file?>&action=check&errorid=<?=$error['error_id']?>'">未审核</a><? } ?> | <a href="javascript:if(confirm('确定删除该条记录吗？')) location='?mod=<?=$mod?>&file=<?=$file?>&action=delete&errorid=<?=$error['error_id']?>'" >删除</a></td>
  </tr>
<?
    }
?>
</table>
<div class="button_box">
  <input name='chkall' type='button' id='chkall' onclick="javascript:CheckedRev();" value="全选">
  <input name="submit1" type="submit"  value="删除" onClick="document.thisform.action='?mod=<?=$mod?>&file=<?=$file?>&action=delete'"/>
  <input name="submit1" type="submit"  value="审核" onClick="document.thisform.action='?mod=<?=$mod?>&file=<?=$file?>&action=check'"/>
</div>
</form>
<div id="pages"><?=$pages?></div>
</body>
</html>
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
</script>

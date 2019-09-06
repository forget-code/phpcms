<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>

<body>
<?=$menu?>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=10><?=($status ? '已审核' : '待审核')?>楼盘信息列表</th>
  </tr>
<form method="post" name="myform" action="">
<tr align="center">
<td width="5%" class="tablerowhighlight">选中</td>
<td width="5%"" class="tablerowhighlight">ID</td>
<td class="tablerowhighlight">楼盘名称</td>
<td width="20%" class="tablerowhighlight">开发商</td>
<td width="10%" class="tablerowhighlight">区域</td>
<td width="10%" class="tablerowhighlight">发布人</td>
<td width="10%" class="tablerowhighlight">日期</td>
<td width="5%" class="tablerowhighlight">点击</td>
<td width="10%" class="tablerowhighlight">管理操作</td>
</tr>
<?php
foreach($displays as $display)
{
?>
<tr align="center" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor="#F1F3F5" title="联系人：<?=$display['contract']?>&#10;电话：<?=$display['saletele']?>&#10;网址：<?=$display['url']?>&#10;地址：<?=$display['address']?>">
<td><input name='displayids[]' type='checkbox' value='<?=$display['displayid']?>'></td>
<td><?=$display['displayid']?></td>
<td><a href="<?=$display['linkurl']?>" target="_blank"><?=$display['name']?></a></td>
<td><?=$display['develop']?></td>
<td><a href="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>&areaid=<?=$display['areaid']?>"><?=$display['areaname']?></a></td>
<td><a href="?mod=member&file=member&action=view&username=<?=urlencode($display['username'])?>"><?=$display['username']?></a></td>
<td><?=$display['addtime']?></td>
<td>
<?=$display['hits']?></td>
<td>
<a href="?mod=<?=$mod?>&file=<?=$file?>&displayid=<?=$display['displayid']?>&action=edit">编辑</a> 
<a href="javascript:if(confirm('确认删除该条数据吗？')) location='?mod=<?=$mod?>&file=<?=$file?>&displayid=<?=$display['displayid']?>&action=delete'">删除</a></td>
</tr>
<?php
}
?>
</table>
<table width="100%" height="10" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td></td>
  </tr>
</table>
<table width="100%" height="30" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><input name='chkall' type='checkbox' id='chkall' onclick='checkall(this.form)' value='check'>全选/反选</td>
    <td align="left">
		<input name='submit0' type='submit' value='批量更新html' onClick="if(confirm('确认批量更新这些html吗（请确认每篇设置为生成html）？')) document.myform.action='?mod=<?=$mod?>&file=createhtml&action=create_newhouse&dosubmit=1&referer=<?=urlencode($PHP_URL)?>'">&nbsp;
		<input name='submit0' type='submit' value='批量删除' onClick="if(confirm('确认批量删除这些新楼市吗？')) document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=delete&dosubmit=1'">&nbsp;
		<?php if($status == 0){ ?>
        <input name='submit1' type='submit' value='批量设置为已审核' onClick="if(confirm('确认批量改变为已审核状态吗？')) document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=changestatus&status=1&typeid=<?=$typeid?>&dosubmit=1&referer=<?=urlencode($PHP_URL)?>'; else return false;">
        <?php }else{ ?>
		<input name='submit1' type='submit' value='批量设置为未审核' onClick="if(confirm('确认批量改变为未审核状态吗？')) document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=changestatus&status=0&typeid=<?=$typeid?>&dosubmit=1&referer=<?=urlencode($PHP_URL)?>'; else return false;">
		<?php } ?>
  </tr>
</table>
<table width="100%" height="30" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align=center><?=$pages?></td>
  </tr>
</table>
</form>
<a name="advancedsearch"></a>
</body>
</html>
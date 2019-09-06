<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>

<body>
<?=$menu?>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=10><?=($status ? '已审核' : '待审核')?><?=$infotypename?>信息列表</th>
  </tr>
<form method="post" name="myform">
<tr align="center">
<td width="5%" class="tablerowhighlight">选中</td>
<td width="5%"" class="tablerowhighlight">ID</td>
<td class="tablerowhighlight">名称</td>
<td width="10%" class="tablerowhighlight">区域</td>
<td width="15%" class="tablerowhighlight">房型</td>
<td width="10%" class="tablerowhighlight">价格</td>
<td width="10%" class="tablerowhighlight">发布人</td>
<td width="10%" class="tablerowhighlight">日期</td>
<td width="5%" class="tablerowhighlight">点击</td>
<td width="10%" class="tablerowhighlight">管理操作</td>
</tr>
<?php
foreach($houses as $house)
{
?>
<tr align="center" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor="#F1F3F5" title="联系人：<?=$house['contract']?>&#10;电话：<?=$house['telephone']?>&#10;手机：<?=$house['mobile']?>&#10;地址：<?=$house['address']?>">
<td><input name='houseids[]' type='checkbox' value='<?=$house['houseid']?>'></td>
<td><a href="<?=$house['linkurl']?>" target="_blank"><?=$house['houseid']?></a></td>
<td><a href="<?=$house['linkurl']?>" target="_blank"><?=$house['title']?></a></td>
<td><a href="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>&typeid=<?=$typeid?>&areaid=<?=$house['areaid']?>"><?=$house['areaname']?></a></td>
<td><?=$house['housetype']?></td>
<td><?php if($house['price']){?><?=$house['price']?> <?=$PARS['unit'][$house['unit']]?><?php }else{?>面议<?php }?></td>
<td><a href="?mod=member&file=member&action=view&username=<?=urlencode($house['username'])?>"><?=$house['username']?></a></td>
<td><?=$house['addtime']?></td>
<td><?=$house['hits']?></td>
<td>
<a href="?mod=<?=$mod?>&file=<?=$file?>&houseid=<?=$house['houseid']?>&typeid=<?=$typeid?>&action=edit">编辑</a> | 
<a href="javascript:if(confirm('确认删除该条数据吗？')) location='?mod=<?=$mod?>&file=<?=$file?>&houseid=<?=$house['houseid']?>&typeid=<?=$typeid?>&action=delete'">删除</a></td>
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
    <td width="11%"><input name='chkall' type='checkbox' id='chkall' onclick='checkall(this.form)' value='check'>全选/反选</td>
    <td width="89%" align="left">
		<input name='submit0' type='submit' value='批量更新html' onClick="if(confirm('确认批量更新这些html吗（请确认每篇设置为生成html）？')) document.myform.action='?mod=<?=$mod?>&file=createhtml&action=create_showinfo&typeid=<?=$typeid?>&dosubmit=1&referer=<?=urlencode($PHP_URL)?>'">
		&nbsp;
        <input name='submit0' type='submit' value='批量删除' onClick="if(confirm('确认批量删除这些房产信息吗？')) document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&typeid=<?=$typeid?>&action=delete&dosubmit=1'">
        &nbsp;
		<?php if($status == 0){ ?>
        <input name='submit1' type='submit' value='批量设置为已审核' onClick="if(confirm('确认批量改变为已审核状态吗？')) document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=changestatus&status=1&typeid=<?=$typeid?>&dosubmit=1&referer=<?=urlencode($PHP_URL)?>'; else return false;">
        <?php }else{ ?>
		<input name='submit1' type='submit' value='批量设置为未审核' onClick="if(confirm('确认批量改变为未审核状态吗？')) document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=changestatus&status=0&typeid=<?=$typeid?>&dosubmit=1&referer=<?=urlencode($PHP_URL)?>'; else return false;">
		<?php } ?>
		</td>
  </tr>
</table>
<table width="100%" height="30" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align=center><?=$pages?></td>
  </tr>
</table>
<a name="advancedsearch"></a>
</body>
</html>
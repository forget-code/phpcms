<?php 
defined('IN_PHPCMS') or exit('Access Denied');

include admintpl('header');
echo $menu;
?>
<table width="100%" cellpadding="0" cellspacing="0" class="tableBorder">
<form method="get" name="search" action="?">
  <tr>
    <td height="30" class="tablerow" align="center">
	<input name='action' type='hidden' value='<?=$action?>'>
	<input name='mod' type='hidden' value='<?=$mod?>'>
	<input name='file' type='hidden' value='<?=$file?>'>
	<input name='job' type='hidden' value='<?=$job?>'>
	<input name='catid' type='hidden' value='<?=$catid?>'>
	<select name="srchtype">
	<option value="0" <?if($srchtype==0){?>selected<?}?>> 按名称 </option>
	<option value="1" <?if($srchtype==1){?>selected<?}?>> 按编号 </option>
	<option value="2" <?if($srchtype==2){?>selected<?}?>> 按价格 </option>
	<option value="3" <?if($srchtype==3){?>selected<?}?>> 按品牌 </option>
	</select>&nbsp;<input name='keywords' type='text' size='40' value='<?if(isset($keywords)){echo $keywords;}?>' onclick="this.value='';" title="关键词...">&nbsp;
	<?php echo $category_select; ?>
	<input type="checkbox" class="radio" name="posid" value="1" <?if(isset($posid)){?>checked<?}?>> 推荐
	<select name="ordertype">
	<option value="0" <?if($ordertype==0){?>selected<?}?>>按商品排序降序</option>
	<option value="1" <?if($ordertype==1){?>selected<?}?>>按商品排序升序</option>
	<option value="2" <?if($ordertype==2){?>selected<?}?>>按更新时间降序</option>
	<option value="3" <?if($ordertype==3){?>selected<?}?>>按更新时间升序</option>
	<option value="4" <?if($ordertype==4){?>selected<?}?>>按浏览次数降序</option>
	<option value="5" <?if($ordertype==5){?>selected<?}?>>按浏览次数升序</option>
	</select>&nbsp;
	<input name='pagesize' type='text' size='3' value='<?php if(isset($pagesize)){echo $pagesize;}?>' title="每页显示的数据数目,最大值为500" maxlength="3"> 条数据/页
	<input type='submit' value=' 搜索 '></td>
  </tr>
</form>
</table>

<form method="post" name="myform">
<table width="100%" height="25" border="0" cellpadding="3" cellspacing="0">
  <tr>
    <td>当前位置：<a href="?mod=<?=$mod?>&file=<?=$file?>&action=manage">商品管理</a> &gt;&gt; <?=$cat_pos?> </td>
    <td align="right"><?php echo $category_jump; ?><?php if($catid) { ?>&nbsp;<input type="button" value="添加商品" onclick="window.location='?mod=<?=$mod?>&file=<?=$file?>&action=add&catid=<?=$catid?>'"><?php } ?>
	</td>
  </tr>
</table>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan="10">商品管理</th>
  </tr>
<tr align="center">
<td width="30" class="tablerowhighlight">选中</td>
<td width="40" class="tablerowhighlight">ID</td>
<td width="50" class="tablerowhighlight">排序</td>
<td class="tablerowhighlight">商品名称</td>
<td width="140" class="tablerowhighlight">商品编号</td>
<td width="40" class="tablerowhighlight">推荐</td>
<td width="72" class="tablerowhighlight">添加时间</td>
<td width="40" class="tablerowhighlight">点击</td>
<td width="80" class="tablerowhighlight">管理操作</td>
</tr>
<? if(is_array($products)) foreach($products AS $product) { ?>
<tr align="center" class="mout" onmouseover="this.className='mover'" onmouseout="this.className='mout'">

<td><input name='productids[]' type='checkbox' value='<?=$product['productid']?>'></td>

<td><?=$product['productid']?></td>

<td><input name='listorders[<?=$product['productid']?>]' type='input' value='<?=$product['listorder']?>' size="3" /></td>

<td align="left"><? if(!$catid) { ?>[<a href="<?php echo $CATEGORY[$product['catid']]['linkurl'];?>" target="_blank"><?=$CATEGORY[$product['catid']]['catname']?></a>] <? } ?><a href="<?=$product['linkurl']?>" target="_blank"><?=$product['pdt_name']?></a></td>

<td>
<?=$product['pdt_No']?>
</td>

<td title=""><a href="" target="_blank"><?=$product['posid']?></a></td>
<td><?=$product['addtime']?></td>
<td><?=$product['hits']?></td>
<td>
<a href="?mod=<?=$mod?>&file=<?=$file?>&action=edit&productid=<?=$product['productid']?>&catid=<?=$product['catid']?>&referer=<?=$referer?>" title="编辑商品">编辑</a> |
<a href="?mod=comment&file=comment&action=manage&item=productid&productid=<?=$product['productid']?>" title="管理评论">评论</a>
</td>
</tr>
<? } ?>


<table width="100%" height="10" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td></td>
  </tr>
</table>
<table width="100%" height="30" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><input name='chkall' type='checkbox' id='chkall' onclick='checkall(this.form)' value='check'>全选/反选</td>
    <td>
	<input name='submit0' type='submit' value='更新排序' onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=listorder&referer=<?=$referer?>'" >&nbsp;
		<input name='submit7' type='submit' value='删除商品' onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=action&job=disabled&value=1&referer=<?=$referer?>&isrecycle=<? echo isset($job)&&$job=='recycle'? 1:0;?>'">&nbsp;
        <input name='submit8' type='submit' value='移动商品' onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=move&movetype=1'"></td>
  </tr>
</table>
<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align='center'><?=$pages?></td>
  </tr>
</table>
</form>

</body>
</html>

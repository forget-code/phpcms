<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include managetpl('header');
?>
<?=$menu?>
<form action="" method="post" name="myform" >
<table width="100%"  border="0" cellpadding="2" cellspacing="1" class="tableborder">
<th colspan=7>求购管理</th>
<tr align="center">
<td width="30" class="tablerowhighlight">选中</td>
<td width="40" class="tablerowhighlight">ID</td>
<td width="150" class="tablerowhighlight">所属栏目</td>
<td class="tablerowhighlight">标题</td>
<td width="80" class="tablerowhighlight">发表时间</td>
<td width="40" class="tablerowhighlight">点击</td>
<td width="70" class="tablerowhighlight">管理操作</td>
</tr>
<? if(is_array($products)) foreach($products AS $product) { ?>
<tr align="center" onmouseout="this.style.backgroundColor='#F1F3F5'"  onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5' title="文章ID:<?=$product['productid']?>&#10;添加时间:<?=$product['addtime']?>&#10;审核:<?=$product['checker']?>&#10;审核时间:<?=$product['checktime']?>&#10;编辑:<?=$product['editor']?>&#10;编辑时间:<?=$product['edittime']?>" ondblclick="$('product_<?=$product['productid']; ?>').checked = ($('product_<?=$product['productid']; ?>').checked ? false : true);">

<td><input name="productid[]" type="checkbox" value="<?=$product['productid']?>" id="product_<?=$product['productid']?>"></td>

<td><?=$product['productid']?></td>
<td><a href="<?=$TRADE[$product['catid']]['linkurl']?>" target="_blank"><?=$TRADE[$product['catid']]['tradename']?></a></td>

<td align="left"><a href="<?=$product['linkurl']?>" target="_blank"><span style="<?=$product['style']?>"><?=$product['title']?><span></a>
<?php if($product['thumb']) { ?> <font color="blue">[图]</font><?php } ?>
</td>

<td><?=$product['addtime']?></td>
<td><?=$product['hits']?></td>
<td>
<a href="?file=<?=$file?>&action=edit&label=<?=$product['label']?>&productid=<?=$product['productid']?>&catid=<?=$product['catid']?>" title="编辑产品">编辑</a>
</td>
</tr>
<? } ?>
</table>

<table width="100%" align="center" cellpadding="2" cellspacing="1">
   <tr>
    <td width="100"><input name='chkall' type='checkbox' id='chkall' onclick='checkall(this.form)' value='check'>全选/反选</td>
    <td>
		<input type='submit' value='删除促销' onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=status&status=-1'">
</td>
  </tr>
</table>
</form>
<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align='center'><?=$pages?></td>
  </tr>
</table>
</form>
<br />
<table width="100%" cellpadding="0" cellspacing="0" class="tableborder">
<form method="get" name="search" action="?">
  <tr>
    <td height="30" class="tablerow" align="center">
	<input name='file' type='hidden' value='<?=$file?>'>
	<input name='action' type='hidden' value='<?=$action?>'>
	<input name='catid' type='hidden' value='<?=$catid?>'>
	<input name='keyword' type='text' size='20' value='<?if(isset($keyword)){echo $keyword;}?>' onclick="this.value='';" title="关键词...">&nbsp;
	<?php echo $categorys; ?>
	<select name="ordertype">
	<option value="0" <?if($ordertype==0){?>selected<?}?>>按产品ID降序</option>
	<option value="1" <?if($ordertype==1){?>selected<?}?>>按产品ID升序</option>
	<option value="2" <?if($ordertype==2){?>selected<?}?>>按更新时间降序</option>
	<option value="3" <?if($ordertype==3){?>selected<?}?>>按更新时间升序</option>
	<option value="4" <?if($ordertype==4){?>selected<?}?>>按浏览次数降序</option>
	<option value="5" <?if($ordertype==5){?>selected<?}?>>按浏览次数升序</option>
	</select>&nbsp;
	<input name='pagesize' type='text' size='3' value='<?if(isset($pagesize)){echo $pagesize;}?>' title="每页显示的数据数目,最大值为500" maxlength="3"> 条数据/页
	<input type='submit' value=' 搜索 '></td>
  </tr>
</form>
</table>

</body>
</html>
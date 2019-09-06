<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include managetpl('header');
?>
<?=$menu?>
<form action="" method="post" name="myform" >
<table width="100%"  border="0" cellpadding="2" cellspacing="1" class="tableborder">
<th colspan=7><?php if($status==-1) echo "回收站"; else echo "新闻管理";?></th>
<tr align="center">
<td width="30" class="tablerowhighlight">选中</td>
<td width="40" class="tablerowhighlight">ID</td>
<td width="150" class="tablerowhighlight">所属栏目</td>
<td class="tablerowhighlight">标题</td>
<td width="80" class="tablerowhighlight">发表时间</td>
<td width="40" class="tablerowhighlight">点击</td>
<td width="70" class="tablerowhighlight">管理操作</td>
</tr>
<? if(is_array($articles)) foreach($articles AS $article) { ?>
<tr align="center" onmouseout="this.style.backgroundColor='#F1F3F5'"  onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5' title="文章ID:<?=$article['articleid']?>&#10;添加时间:<?=$article['addtime']?>&#10;审核:<?=$article['checker']?>&#10;审核时间:<?=$article['checktime']?>&#10;编辑:<?=$article['editor']?>&#10;编辑时间:<?=$article['edittime']?>" ondblclick="$('article_<?=$article['articleid']; ?>').checked = ($('article_<?=$article['articleid']; ?>').checked ? false : true);">

<td><input name="articleid[]" type="checkbox" value="<?=$article['articleid']?>" id="article_<?=$article['articleid']?>"></td>

<td><?=$article['articleid']?></td>
<td><a href="<?=$MOD['linkurl']?><?=$TRADE[$article['catid']]['linkurl']?>" target="_blank"><?=$TRADE[$article['catid']]['tradename']?></a></td>

<td align="left"><a href="<?=$article['linkurl']?>" target="_blank"><span style="<?=$article['style']?>"><?=$article['title']?></span></a>
<?php if($article['thumb']) { ?> <font color="blue">图</font><?php } ?>
</td>

<td><?=$article['addtime']?></td>
<td><?=$article['hits']?></td>
<td>
<a href="?mod=<?=$mod?>&file=<?=$file?>&action=edit&articleid=<?=$article['articleid']?>&catid=<?=$article['catid']?>" title="编辑信息">编辑</a>
</td>
</tr>
<? } ?>
</table>

<table width="100%" align="center" cellpadding="2" cellspacing="1" >
   <tr>
    <td width="100"><input name='chkall' type='checkbox' id='chkall' onclick='checkall(this.form)' value='check'>全选/反选</td>
    <td>
	<?php
	if($status=='status=-1')
	{
	?>
		<input type='submit' value='删除文章' onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=delete'">
		<?php
	}
	else
	{
	?>
		<input type='submit' value='删除文章' onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=status&status=-1'">
	<?php
	}	?>
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
	<input name='keywords' type='text' size='20' value='<?if(isset($keywords)){echo $keywords;}?>' onclick="this.value='';" title="关键词...">&nbsp;
	<?php echo $categorys; ?>
	<select name="ordertype">
	<option value="0" <?if($ordertype==0){?>selected<?}?>>按信息ID降序</option>
	<option value="1" <?if($ordertype==1){?>selected<?}?>>按信息ID升序</option>
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

<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<?=$menu?>
<table cellpadding='2' cellspacing='0' border='0' align='center' class='tableBorder'>
  <tr>
    <td class='tablerow' align="left">
	分类名称：
	<?php 
	$i = 1;
	foreach($TYPE as $typeid=>$v)
	{
		if($i > 10) break;
		echo "<a href='?mod=".$mod."&file=".$file."&action=manage&typeid=".$v['typeid']."'>".$v['name']."</a> | ";
		$i++;
	}
	?>
	</td>
	</tr>
</table>
<BR>
<table cellpadding="2" cellspacing="1" border="0" align=center class="tableBorder" >
  <tr>
    <th colspan="8">友情链接管理</th>
  </tr>
  <tr align="center">
    <td class="tablerowhighlight">选中</td>
    <td class="tablerowhighlight">排序</td>
    <td class="tablerowhighlight">所属分类</td>
    <td class="tablerowhighlight">链接类型</td>
    <td class="tablerowhighlight">网站名称</td>
    <td class="tablerowhighlight">网站Logo</td>
    <td class="tablerowhighlight">网站概况</td>
    <td class="tablerowhighlight">操作</td>
  </tr>
  <form name="myform" method="post" action="?mod=link&file=link&action=updatelistorderid">
<? if(is_array($links)) foreach($links AS $link) { ?>
  <tr align="center" >
    <td class="tablerow"><input name='linkid[]' type='checkbox' id='linkid[]' value='<?=$link['linkid']?>'></td>
    <td class="tablerow"><input size="2" name="listorder[<?=$link['linkid']?>]" type="text" value="<?=$link['listorder']?>"></td>

	<td class="tablerow"><a href="?mod=link&file=link&action=manage&typeid=<?=$link['typeid']?>" title="点击显示该类别链接"><?=$TYPE[$link['typeid']]['name']?></a></td>

    <td class="tablerow"><? if($link['linktype']) { ?>Logo<? } else { ?>文字<? } ?></td>
    <td align="center" class="tablerow" onmouseout="this.style.backgroundColor='#F1F3F5'"  onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5' title='<?php echo "网站地址：".$link['url']."&#10;点击次数：".$link['hits']."次";?>'><a href='<?=$link['url']?>' target='_blank' ><span style="<?=$link['style']?>"><?=$link['name']?></span></a><? if($link['elite']) { ?> <font color='red'>荐</font><?}?></td>
    <td class="tablerow"><? if($link['linktype']) { ?><a href='<?=$link['url']?>' target="_blank" title='<?=$link['logo']?>'><img src='<?=$link['logo']?>' width='88' height='31' border='0'></a><? } ?></td>
    <td class="tablerow">
	<textarea name="introduce" cols="35" rows="2" id="introduce">简介:<?=$link['introduce']?><?=chr(13)?>站长:<?=$link['username']?>
    </textarea></td>
    <td class="tablerow"><a href="?mod=link&file=link&action=edit&linkid=<?=$link['linkid']?>">修改</a> </td>
  </tr>

<? } ?>

</table>

<table width="100%" height="30" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><input name='chkall' type='checkbox' id='chkall' onclick='checkall(this.form)' value='check'>全选/反选</td>
    <td>
		<input type="submit" name="submit" value=" 更新排序 ">&nbsp;
       <? if($passed) { ?>
        <input name='submit5' type='submit' value='取消批准' onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=pass&passed=0'" >&nbsp;
		<? } else { ?>
		<input name='submit4' type='submit' value='批准链接' onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=pass&passed=1'" >&nbsp;
		<? } ?>
        <input name='submit2' type='submit' value='推荐链接' onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=elite&elite=1'" >&nbsp;
        <input name='submit3' type='submit' value='取消推荐' onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=elite&elite=0'" >&nbsp;
		<input name='submit6' type='submit' value='删除链接'		onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=delete'"></td>
  </tr>
</table>
<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align='center'><?=$pages?></td>
  </tr>
</table>
</form>






<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td></td>
  </tr>
</table>

<table cellpadding="2" cellspacing="1" border="0" align=center class="tableBorder" >
  <tr>
    <th align="center"> 链接搜索 </th>
  </tr>
<form method="post" name="search">
  <tr>
    <td class="tablerow">&nbsp;
	<b>显示选项：</b> <input name='passed' type='radio' value='1' onclick="location='?mod=link&file=link&action=manage&passed=1&keyword=<?=$keyword?>&typeid=<?=$typeid?>'" <? if($passed==1) { ?>checked<? } ?>><a href='?mod=link&file=link&action=manage&passed=1&keyword=<?=$keyword?>&typeid=<?=$typeid?>'>已审核的链接</a>&nbsp;<input name='passed' type='radio' value='0' onclick="location='?mod=link&file=link&action=manage&passed=0&keyword=<?=$keyword?>&typeid=<?=$typeid?>'" <? if(!$passed) { ?>checked<? } ?>><a href='?mod=link&file=link&action=manage&passed=0&keyword=<?=$keyword?>&typeid=<?=$typeid?>'>未审核的链接</a>&nbsp;
	关键字：<input name='keyword' type='text' size='15' value='<?=$keyword?>'>&nbsp;
    <input type="radio" name="linktype" value="1" <?if($linktype==1){?>checked<?}?>> <a href='?mod=link&file=link&action=manage&passed=<?=$passed?>&linktype=1'>Logo链接</a>	
	<input type="radio" name="linktype" value="0" <?if($linktype==0){?>checked<?}?>> <a href='?mod=link&file=link&action=manage&passed=<?=$passed?>&linktype=0'>文字链接</a>
	<input type="checkbox" name="elite" value="1" <?if($elite){?>checked<?}?>> 推荐
	<input name='submit' type='submit' value='链接搜索'></td>
  </tr>
</form>
</table>

</body>
</html>
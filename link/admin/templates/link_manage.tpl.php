<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<table cellpadding="0" cellspacing="1" class="table_form" >
<caption>管理友情链接</caption>
<form method="get" name="search">
<input name='mod' type='hidden' value='<?=$mod?>'>
<input name='file' type='hidden' value='<?=$file?>'>
<input name='action' type='hidden' value='<?=$action?>'>
  <tr>
    <td>&nbsp;
	<b>显示选项：</b> <input name='passed' type='radio' value='1' onclick="location='?mod=link&file=link&action=manage&passed=1&keyword=<?=$keyword?>'" <? if($passed==1) { ?>checked<? } ?>><a href='?mod=link&file=link&action=manage&passed=1&keyword=<?=$keyword?>'>已审核的链接</a>&nbsp;<input name='passed' type='radio' value='0' onclick="location='?mod=link&file=link&action=manage&passed=0&keyword=<?=$keyword?>'" <? if(!$passed) { ?>checked<? } ?>><a href='?mod=link&file=link&action=manage&passed=0&keyword=<?=$keyword?>'>未审核的链接</a>&nbsp;
	关键字：<input name='keyword' type='text' size='15' value='<?=$keyword?>'>&nbsp;
    <input type="radio" name="linktype" value="1" <?if($linktype==1){?>checked<?}?>> <a href='?mod=link&file=link&action=manage&passed=<?=$passed?>&linktype=1'>Logo链接</a>
	<input type="radio" name="linktype" value="0" <?if($linktype==0){?>checked<?}?>> <a href='?mod=link&file=link&action=manage&passed=<?=$passed?>&linktype=0'>文字链接</a>
	<input type="checkbox" name="elite" value="1" <?if($elite){?>checked<?}?>> 推荐
	<input name='submit' type='submit' value='搜索'></td>
  </tr>
</form>
</table>
 <form name="myform" method="post" action="?mod=link&file=link&action=updatelistorderid">
<table cellpadding="0" cellspacing="1" class="table_list">
  <caption>管理友情链接</caption>
  <tr>
    <th style="width:5%">选中</th>
    <th style="width:5%">排序</th>
    <th>网站名称</th>
    <th>网站Logo</th>

    <th>所属分类</th>
	<th>链接类型</th>
	<th>点击次数</th>
	<th style="width:10%;">操作</th>
  </tr>
<? if(is_array($links)) foreach($links AS $link) { ?>
  <tr>
    <td style="text-align:center"><input name='linkid[]' type='checkbox' id='linkid[]' value='<?=$link['linkid']?>'></td>
    <td style="text-align:center"><input size="3" name="listorder[<?=$link['linkid']?>]" type="text" value="<?=$link['listorder']?>"></td>
    <td title='<?php echo "网站地址：".$link['url']."&#10;点击次数：".$link['hits']."次";?>'><a href='<?=$link['url']?>' target='_blank' ><span class="<?=$link['style']?>"><?=$link['name']?></span></a><? if($link['elite']) { ?> <font color='red'>荐</font><?}?></td>
    <td style="text-align:center"><? if($link['linktype']) { ?><a href='<?=$link['url']?>' target="_blank" title='<?=$link['logo']?>'><img src='<?=$link['logo']?>' width='88' height='31' border='0'></a><? } ?></td>
	<td style="text-align:center"><a href="?mod=link&file=link&action=manage&typeid=<?=$link['typeid']?>" title="点击显示该类别链接"><?=$TYPE[$link['typeid']]['name']?></a></td>
    <td style="text-align:center"><? if($link['linktype']) { ?>Logo<? } else { ?>文字<? } ?></td>
    <td style="text-align:center"><?=$link['hits']?></td>
    <td style="text-align:left"><a href="?mod=link&file=link&action=edit&linkid=<?=$link['linkid']?>">修改</a> | <?php echo $link[elite]?"<a href='?mod=link&file=link&action=elite&linkid=$link[linkid]&elite=0'>取消推荐</a>":"<a href='?mod=link&file=link&action=elite&linkid=$link[linkid]&elite=1'>推荐</a>";?></td>
  </tr>
<?php } ?>
</table>
<div class="button_box"><a href="#" onclick="javascript:$('input[type=checkbox]').attr('checked', true)">全选</a>/<a href="#" onclick="javascript:$('input[type=checkbox]').attr('checked', false)">取消</a>
		<input type="submit" name="submit" value=" 更新排序 ">&nbsp;
       <? if($passed) { ?>
        <input name='submit5' type='submit' value='取消批准' onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=pass&passed=0'" >&nbsp;
		<? } else { ?>
		<input name='submit4' type='submit' value='批准链接' onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=pass&passed=1'" >&nbsp;
		<? } ?>
        <input name='submit2' type='submit' value='推荐链接' onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=elite&elite=1'" >&nbsp;
        <input name='submit3' type='submit' value='取消推荐' onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=elite&elite=0'" >&nbsp;
		<input name='submit6' type='submit' value='删除链接'		onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=delete';return confirm('您确定要删除吗？');"></div>
</form>

<div id="pages"><?=$pages?></div>

</body>
</html>
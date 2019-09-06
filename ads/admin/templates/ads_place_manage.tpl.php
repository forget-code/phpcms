<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<form name="search" method="get" action="">
<input type="hidden" name="mod" value="<?=$mod?>">
<input type="hidden" name="file" value="<?=$file?>">
<input type="hidden" name="action" value="<?=$action?>">
<table cellpadding="0" cellspacing="1" class="table_form">
  <caption>广告位查询</caption>
<tr>
<td class="align_c">
<input type="radio" name="passed" value="-1" <?php if($passed==-1) echo "checked";?>  onclick="redirect('?mod=ads&&file=ads_place&action=manage&passed='+this.value)"/> 全部 <input type="radio" name="passed" value="1"  <?php if($passed==1) echo "checked";?> onclick="redirect('?mod=ads&file=ads_place&action=manage&passed='+this.value)"/> 开放 <input type="radio" name="passed" value="0"   <?php if($passed==0) echo "checked";?> onclick="redirect('?mod=ads&file=ads_place&action=manage&passed='+this.value)"/> 锁定
</td>
<td class="align_c">
<select name='field'>
<option value='placename' <?=$field == 'placename' ? 'selected' : ''?> >名称</option>
<option value='introduce' <?=$field == 'introduce' ? 'selected' : ''?> >介绍</option>
<option value='placeid' <?=$field == 'placeid' ? 'selected' : ''?> >广告ID</option>
</select>
<input type="text" name="q" value="<?=$q?>" size="20" />&nbsp;
<input type="submit" name="dosubmit" value=" 查询 " />
</td>
</tr>
</table>
</form>
<table cellpadding="3" cellspacing="1" class="table_list" id='Tabs0'><form method="post" name="myform">
  <caption>管理广告位</caption>
<tr>
<th width="30"><strong>选中</strong></th>
<th width="160" ><strong>广告位名称</strong></th>
<th><strong>介绍</strong></th>
<th width="5%"><strong>尺寸</strong></th>
<th width="8%"><strong>状态</strong></th>
<th width="50"><strong>广告数</strong></th>
<th width="5%"><strong>价格</strong></th>
<th width="245"><strong>管理操作</strong></th>
</tr>
<?php
if(is_array($places)){
	foreach($places as $place){
?>
<tr>
<td class="align_c"><input type="checkbox" id="checkbox" name="placeid[]"  id="placeid[]" value="<?=$place['placeid']?>"></td>
<td><A HREF="?mod=ads&file=ads_place&action=view&placeid=<?=$place['placeid']?>" target="_blank"><?=$place['placename']?></A></td>
<td><?=$place['introduce']?></td>
<td class="align_c"><?=$place['width']?>x<?=$place['height']?></td>
<td class="align_c"><?=$place['passed']?"<b style='color:green'>开放</b>":"<b style='color:red'>锁定</b>"?></td>
<td class="align_c"><?=$place['items']?></td>
<td class="align_c"><?=$place['price']?>元</td>
<td class="align_c">
<a HREF="?mod=ads&file=ads&action=add&placeid=<?=$place['placeid']?>&referer=<?=$referer?>">添加广告</A> |
<a HREF="?mod=ads&file=ads&action=manage&adsplaceid=<?=$place['placeid']?>">广告列表</A> |
<a HREF="?mod=ads&file=<?=$file?>&action=edit&placeid=<?=$place['placeid']?>">编辑</A> |
<a HREF="?mod=ads&file=<?=$file?>&action=loadjs&placeid=<?=$place['placeid']?>">调用代码</A>
</td>
</tr>
<?php
	}
}
?>
</table>
<div class="button_box">
    <input type="button" value="全选" onClick="checkall()">
	<input type="submit" name="submit" value="批量锁定" onClick="myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=lock&val=0';return confirm('您确定要锁定吗？');">
	<input type="submit" name="submit" value="批量解锁" onClick="myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=lock&val=1';return confirm('您确定要解锁吗？');">
	<input type="submit" name="submit" value="批量删除" onClick="myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=delete'; return confirm('您确定要删除吗？');">
</div>
</form>
<div id="pages"><?=$pages?></div>
</body>
</html>
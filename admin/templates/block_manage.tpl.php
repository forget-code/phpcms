<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<div class="button_box">
<span class="button_style" style="width:100px;margin-left:10px;"><a href='?mod=phpcms&file=block&action=list'>栏目模式</a></span>
</div>
<form method="post" name="myform" action="?mod=<?=$mod?>&file=<?=$file?>&action=manage">
<table cellpadding="0" cellspacing="1" class="table_list">
    <caption>碎片管理</caption>
<tr>
<th width="5%">选中</th>
<th width="5%">排序</th>
<th>碎片名称</th>
<th width="25%">调用代码</th>
<th width="20%">管理操作</th>
</tr>
<?php 
if(is_array($data)){
	foreach($data as $r){
?>
<tr>
<td class="align_c"><input type="checkbox" name="blockid[<?=$r['blockid']?>]" value="<?=$r['blockid']?>" id="block_<?=$r['blockid']?>" /></td>
<td class="align_c"><input type="text" name="info[<?=$r['blockid']?>]" value="<?=$r['listorder']?>" size="5"></td>
<td><?=$r['name']?></td>
<td>{block('<?=$r['pageid']?>', <?=$r['blockno']?>)}</td>
<td class="align_c">
<a href="?file=<?=$file?>&action=update&blockid=<?=$r['blockid']?>">更新</a> | 
<a href="?file=<?=$file?>&action=edit&blockid=<?=$r['blockid']?>">修改</a> | 
<a href="?mod=<?=$mod?>&file=<?=$file?>&action=disable&blockid=<?=$r['blockid']?>&disabled=<?=($r['disabled']==1 ? 0 : 1)?>"><?=($r['disabled']==1 ? '<font color="red">启用</font>' : '禁用')?></a> | 
<a href="javascript:confirmurl('?file=<?=$file?>&action=delete&blockid=<?=$r['blockid']?>','确认要删除‘<?=$r['name']?>’吗？')">删除</a>
</td>
</tr>
<?php 
	}
}
?>
</table>
<div class="button_box"><input type="button" name="dodelete" value=" 删除 " onclick="myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=delete&forward=<?=urlencode(URL)?>';myform.submit();"> <input type="button" name="dolistorder" value=" 排序 " onclick="myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=listorder&forward=<?=urlencode(URL)?>';myform.submit();"/> <input type="button" name="dorefresh" value=" 刷新碎片 " onclick="myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=refresh&forward=<?=urlencode(URL)?>';myform.submit();"/></div>
<div id="pages"><?=$block->pages?></div>
</form>
<table cellpadding="0" cellspacing="1" class="table_info">
  <caption>提示信息</caption>
  <tr>
    <td>碎片功能支持完全手动更新，并且可以搜索内容，可恢复数据至任何历史版本，常用于专题制作和首页频繁更新的内容。<br />
	您可以在模板中直接插入 <font color="red">{block('news', 1)}</font> 格式的碎片标签，然后进后台模板管理点击“<a href="?mod=phpcms&file=template&action=tag&template=index&module=phpcms&project=<?=TPL_NAME?>">可视化</a>”即可看到添加碎片的链接。<br />
	碎片参数说明：<br />
	1、第一个参数“<font color="red">news</font>”是页面唯一标识，您可以自己命名；<br />
	2、第二个参数“<font color="red">1</font>”是当前页面的碎片序号，为正整数，保证同一页面不重复即可。
	</td>
  </tr>
</table>
</body>
</html>
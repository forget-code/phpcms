<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<div class="button_box">
<?php if(in_array(1, $_roleid) || in_array(2, $_roleid)){ ?>
<span class="button_style" style="width:100px;margin-left:10px;"><a href='?mod=<?=$mod?>&file=<?=$file?>&action=manage&forward=<?=urlencode(URL)?>'>管理碎片</a></span>
<?php } ?>
</div>
<table cellpadding="0" cellspacing="1" class="table_list">
    <caption>碎片管理</caption>
<tr>
<th width="5%">ID</th>
<th>栏目名称</th>
<th width="8%">类型</th>
<th width="20%">碎片维护</th>
</tr>
<tr>
	<td class='align_c'>0</td>
	<td><a href='<?=$PHPCMS['siteurl']?>' style="color:red">网站首页</a></td>
	<td class='align_c'>首页</td>
	<td class='align_c'><a href='?mod=phpcms&file=block&action=index'>首 页</a> | <font color='#cccccc'>内容页</font></td>
</tr>
<?=$categorys?>
</table>
<div class="button_box">
<span class="button_style" style="width:100px;margin-left:10px;"><a href='?mod=<?=$mod?>&file=<?=$file?>&action=refresh&forward=<?=urlencode(URL)?>'>刷新碎片</a></span>
</div>
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
<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<form method="get" name="myform">
<table cellpadding="0" cellspacing="1" class="table_form">
	<tr>
	  <td align="center"  height="30">
	  <font color="red">标签快速操作：</font><input name="tagname" id="tagname" type="text" value="请输入标签名" size="30" onclick="if(this.value == '请输入标签名') this.value=''"> 
	  <input name="preview" id="preview" type="button" value=" 预览 "> &nbsp;&nbsp;
	  <input name="edit" id="edit" type="button" value=" 编辑 "> &nbsp;&nbsp;
	  <input name="copy" id="copy" type="button" value=" 复制 "> &nbsp;&nbsp;
	  <input name="delete" id="delete" type="button" value=" 删除 ">
	  </td>
	</tr>
</table>
</form>
<table cellpadding="0" cellspacing="1" border="0" width="100%" height="10">
	<tr>
		<td></td>
	</tr>
</table>
<table cellpadding="2" cellspacing="1" class="table_list">
  <caption><?=$functions[$function]?>标签管理</caption>
<tr>
<th width="20%">标签名称</th>
<th width="25%">站内标签调用</h>
<th width="35%">跨站JS调用</th>
<th width="20%">管理操作</th>
</tr>
<?php 
foreach($tags AS $tagname=>$tag)
{
?>
<tr align="center" title="提示：双击鼠标复制标签内容至剪贴板...">
<td align="center">
<a href="?mod=<?=$mod?>&file=<?=$file?>&action=edit&tagname=<?=urlencode($tagname)?>"><?=$tagname?></a>
</td>
<td align="left">
<input type='text' value="{tag_<?=$tagname?>}" size='25' name='tag<?=$tagname?>a' onDblClick="clipboardData.setData('text',this.value); alert(this.value +'已复制到剪贴板');"><br/>
</td>
<td align="left">
<input type='text' value="<script type='text/javascript' src='<?=SITE_URL?>api/js.php?tagname=<?=urlencode($tagname)?>'></script>" size='45' onDblClick="clipboardData.setData('text',this.value); alert(this.value +'已复制到剪贴板');">
</td>
<td class="align_c"><a href="?mod=phpcms&file=tag&action=preview&module=<?=$module?>&tagname=<?=urlencode($tagname)?>">预览</a> | <a href="?mod=<?=$mod?>&file=<?=$file?>&action=edit&module=<?=$module?>&tagname=<?=urlencode($tagname)?>">修改</a> | <a href="?mod=<?=$mod?>&file=<?=$file?>&action=copy&module=<?=$module?>&tagname=<?=urlencode($tagname)?>">复制</a> | <a href="###" onClick="javascript:confirmurl('?mod=<?=$mod?>&file=<?=$file?>&action=delete&module=<?=$module?>&tagname=<?=urlencode($tagname)?>','确认删除此标签吗？如果您在模板中使用了此标签或JS调用，则请不要删除！')">删除</a></td>
</tr>
<?php 
}
?>
</table>
<div class="pages"><?=$t->pages?></div>
<br/>
<table cellpadding="2" cellspacing="1" border="0" class="table_info">
  <caption>提示信息</caption>
  <tr>
    <td>
<strong>PHPCMS 模板制作与标签设置的基本流程：</strong>
<br/>
1、通过Deamweaver、Fireworks、Flash 和 Photoshop 等软件设计好 html 页面；<br/>
2、根据页面布局插入中文标签<br/>
3、在 ./templates 目录下建立一个新的模板目录，然后把做好的 html 页面按照 PHPCMS 模板命名规则命名并存放到模板目录；<br/>
4、登录PHPCMS后台，进入“模板风格”管理，把自己新建的模板方案设置为默认方案；<br/>
5、进入 PHPCMS 后台模板编辑，通过模板编辑面板的标签管理功能定义好中文标签参数；<br/>
4、更新前台页面即可看到效果。<br/>
	</td>
  </tr>
</table>
</body>
</html>
<script language="javascript">
$('#edit').click(function(){
	var tagname = $('#tagname').val();
	window.open('?mod=phpcms&file=template&action=gettag&operate=edit&job=edittemplate&tagname='+tagname,'tag','height=500,width=700,,top=0,left=0,toolbar=no,menubar=no,scrollbars=yes,resizable=no,location=no,status=no');
});

$('#preview').click(function(){
	var tagname = $('#tagname').val();
	var url = '?mod=phpcms&file=tag&action=preview&tagname='+tagname;
	window.open(url,'tag','height=500,width=700,,top=0,left=0,toolbar=no,menubar=no,scrollbars=yes,resizable=no,location=no,status=no');
});

$('#delete').click(function(){
	var mod = "<?=$mod?>";
	var file = "<?=$file?>";
	var module = "<?=$module?>";
	var tagname = $('#tagname').val();
	confirmurl('?mod='+mod+'&file='+file+'&action=delete&module='+module+'&tagname='+tagname,'确认删除此标签吗？如果您在模板中使用了此标签或JS调用，则请不要删除！');
});

$('#copy').click(function(){
	var mod = "<?=$mod?>";
	var file = "<?=$file?>";
	var module = "<?=$module?>";
	var tagname = $('#tagname').val();
	var url = '?mod='+mod+'&file='+file+'&action=copy&module='+module+'&tagname='+tagname;
	window.open(url,'tag','height=500,width=700,,top=0,left=0,toolbar=no,menubar=no,scrollbars=yes,resizable=no,location=no,status=no');
});
</script>
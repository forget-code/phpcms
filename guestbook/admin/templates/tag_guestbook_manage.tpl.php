<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<form method="get" name="myform">
<table cellpadding="0" cellspacing="1" class="table_list">
	<tr>
	  <td   height="30">
	  <input type="hidden" name="mod" value="phpcms">
	  <input type="hidden" name="file" value="tag">
	  <input type="hidden" name="action" value="quickoperate">
	  <input type="hidden" name="operate" value="preview">
	  <font color="red">标签快速操作：</font><input name="tagname" type="text" value="请输入标签名" size="30" onclick="if(this.value == '请输入标签名') this.value=''"> 
	  <input name="preview" type="button" value=" 预览 " onclick="$('operate').value='preview';myform.submit();"> &nbsp;&nbsp;
	  <input name="edit" type="button" value=" 编辑 " onclick="$('operate').value='edit';myform.submit();"> &nbsp;&nbsp;
	  <input name="copy" type="button" value=" 复制 " onclick="$('operate').value='copy';myform.submit();"> &nbsp;&nbsp;
	  <input name="delete" type="button" value=" 删除 " onclick="$('operate').value='delete';myform.submit();">
	  </td>
	</tr>
</table>
</form>

<table cellpadding="0" cellspacing="1" class="table_list">
<caption>标签列表</caption>
<tr >
<th>标签名称</th>
<th>站内标签调用</th>
<th>跨站JS调用</th>
<th>管理操作</th>
</tr>
<?php 
foreach($tags AS $tagname=>$tag)
{
?>
<tr title="提示：双击鼠标复制标签内容至剪贴板...">
<td>
<a href="?mod=<?=$mod?>&file=<?=$file?>&action=edit&tagname=<?=urlencode($tagname)?>"><?=$tagname?></a>
</td>
<td align="left">
<input type='text' value="{tag_<?=$tagname?>}" size='25' name='tag<?=$tagname?>a' onDblClick="clipboardData.setData('text',this.value); alert(this.value +'已复制到剪贴板');"><br/>
</td>
<td align="left">
<input type='text' value="<script type='text/javascript' src='<?=SITE_URL?>api/js.php?tagname=<?=urlencode($tagname)?>'></script>" size='45' onDblClick="clipboardData.setData('text',this.value); alert(this.value +'已复制到剪贴板');">
</td>
<td><a href="?mod=<?=$mod?>&file=tag&action=preview&module=<?=$module?>&tagname=<?=urlencode($tagname)?>">预览</a> | <a href="?mod=<?=$mod?>&file=<?=$file?>&action=edit&function=<?=$function?>&module=<?=$module?>&tagname=<?=urlencode($tagname)?>">修改</a> | <a href="?mod=<?=$mod?>&file=<?=$file?>&action=copy&module=<?=$module?>&tagname=<?=urlencode($tagname)?>">复制</a> | <a href="###" onClick="javascript:confirmurl('?mod=<?=$mod?>&file=<?=$file?>&action=delete&module=<?=$module?>&tagname=<?=urlencode($tagname)?>','确认删除此标签吗？如果您在模板中使用了此标签或JS调用，则请不要删除！')">删除</a></td>
</tr>
<?php 
}
?>
</table>

<div id="pages"><?=$t->pages?></div>

<table cellpadding="0" cellspacing="1" class="table_form">
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
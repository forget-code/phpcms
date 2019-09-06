<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<?=$menu?>
<table cellpadding="2" cellspacing="1" border="0" align=center class="tableBorder" >
  <tr>
    <td class="submenu" align="center"><?=$functions[$function]?>标签管理</td>
  </tr>
  <tr>
    <td class="tablerow"><b>管理选项：</b><a href="?mod=<?=$mod?>&file=<?=$file?>&action=add&function=<?=$function?>">添加标签</a> | <a href="?mod=<?=$mod?>&file=<?=$file?>&action=manage&function=<?=$function?>">管理标签</a></td>
  </tr>
</table>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
	<tr>
		<td></td>
	</tr>
</table>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=6><?=$functions[$function]?>标签管理</th>
  </tr>
<form method="post" name="myform">
<tr align="center">
<td class="tablerowhighlight"  width="20%" rowspan="2">标签名称</td>
<td class="tablerowhighlight" width="65%" colspan="2">标签调用代码（复制后插入模板相应位置）</td>
<td class="tablerowhighlight"  width="15%" rowspan="2">管理操作</td>
</tr>
<tr align="center">
<td class="tablerowhighlight">html标签（站内调用）</td>
<td class="tablerowhighlight">JS调用代码（跨站调用）</td>
</tr> 
  
<?php print_r($tagconfigs);
if(is_array($tagconfigs))
foreach($tagconfigs as $tagname=>$tagconfig)
{
?>
<tr align="center" onMouseOut="this.style.backgroundColor='#F1F3F5'" onMouseOver="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5' title="提示：双击复制标签内容至剪贴板...">
<td align="left" height="60">
<a href="?mod=<?=$mod?>&file=<?=$file?>&action=edit&tagname=<?=urlencode($tagname)?>"><?=$tagname?></a>
</td>
<td align="left">
&nbsp;html标签调用(站内调用)：<input type='text' value="<?=$tag['tag']?>" size='40' name='tag<?=$tagname?>a' onDblClick="clipboardData.setData('text',this.value); alert(this.value + '已复制到剪贴板');"></td>
<td align="left">
&nbsp;JS 调 用(跨站调用)：<input type='text' value="&lt;script type=&#34;text/javascript&#34; src=&#34;<?=$PHP_SITEURL?><?=$MOD['linkurl']?>js.php?tag=<?=urlencode($tagname)?>&#34;>&lt;/script&gt;" size='40' name='js<?=$tagname?>' onDblClick="clipboardData.setData('text',this.value); alert(this.value+'已复制到剪贴板');"></td>
<td><a href="###" onclick="window.location='?mod=<?=$mod?>&file=tag&action=preview&eval='+$F('<?=$tag['tag']?>')" title="提示:您可以先在左边长标签输入框中修改相关参数后再预览效果！">预览</a> | <a href="?mod=<?=$mod?>&file=<?=$file?>&action=edit&function=<?=$m[1]?>&tagname=<?=urlencode($tagname)?>">修改</a> | <a href="###" onClick="javascript:confirmurl('?mod=<?=$mod?>&file=<?=$file?>&action=delete&tagname=<?=urlencode($tagname)?>','确认删除此标签吗？如果您在模板中使用了短标签或JS调用，则请不要删除！')">删除</a></td>
</tr>
<? } ?>
</table>
</form>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
	<tr>
		<td></td>
	</tr>
</table>
<table cellpadding="2" cellspacing="1" border="0" align=center class="tableBorder" >
  <tr>
    <td class="submenu" align="center">提示信息</td>
  </tr>
  <tr>
    <td class="tablerow">
	您可以先设置好参数，然后把标签或者JS代码复制粘贴到模板中的相应位置，这样就可以在该位置显示信息。标签和JS调用显示的结果相同，您需要根据实际情况来决定选择哪一种调用方式。下面就标签调用与JS调用特点做一下讲解：<p>
	<b>标签调用：</b><br/>
	优点：在调用页产生html，有利于搜索收录，下载速度快<br/>
	缺点：如果您设置了生成html，html生成速度慢，需要经常更新页面才能保持最新，不能跨站或者跨频道调用<p>
	<b>JS调用：</b><br/>
	优点：可以跨站调用，自动更新，html生成速度快<br/>
	缺点：搜索收录差，速度相对html要慢一点（相差不大）<p>

	<b>我们的建议：</b><br/>
    在商城首页、栏目首页使用标签调用；<br/>
    栏目信息列表、商品信息具体页中的推荐信息、热点信息等使用JS调用
	</td>
  </tr>
</table>
</body>
</html>
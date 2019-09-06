<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
	<tr>
		<td></td>
	</tr>
</table>
<table cellpadding='2' cellspacing='1' border='0' align='center' class='tableBorder'>
  <tr>
    <td class='pagemenu'>模块：
<?php
$i = 1;
foreach($modules as $m=>$name)
{
?>
     <a href="?mod=<?=$m?>&file=tag&action=manage" class='pagelink'><?=$name?></a>
<?php 
if($i%15==0) echo '<br/>'; else echo ' | ';
$i++;
}
?>
	</td>
  </tr>
</table>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
	<tr>
		<td></td>
	</tr>
</table>
<form method="get" name="myform">
<table cellpadding="2" cellspacing="1" class="tableborder">
	<tr>
	  <td class="tablerow" align="center"  height="30">
	  <input type="hidden" name="mod" value="phpcms">
	  <input type="hidden" name="file" value="tag">
	  <input type="hidden" name="action" value="quickoperate">
	  <input type="hidden" name="operate" value="preview">
	  <input type="hidden" name="channelid" value="<?=$channelid?>">
	  <font color="red">标签快速操作：</font><input name="tagname" type="text" value="请输入标签名" size="30" onclick="if(this.value == '请输入标签名') this.value=''"> 
	  <input name="preview" type="button" value=" 预览 " onclick="$('operate').value='preview';myform.submit();"> &nbsp;&nbsp;
	  <input name="edit" type="button" value=" 编辑 " onclick="$('operate').value='edit';myform.submit();"> &nbsp;&nbsp;
	  <input name="copy" type="button" value=" 复制 " onclick="$('operate').value='copy';myform.submit();"> &nbsp;&nbsp;
	  <input name="delete" type="button" value=" 删除 " onclick="$('operate').value='delete';myform.submit();">
	  </td>
	</tr>
</table>
</form>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
	<tr>
		<td></td>
	</tr>
</table>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=6>标签管理</th>
  </tr>
<tr align="center">
<td class="tablerowhighlight" width="18%">标签名称</td>
<td class="tablerowhighlight" width="20%">站内标签调用</td>
<td class="tablerowhighlight" width="30%">跨站JS调用</td>
<td class="tablerowhighlight" width="10%">所属模块</td>
<td class="tablerowhighlight" width="18%">管理操作</td>
</tr>
<?php 
foreach($tags AS $tagname=>$tag)
{
	preg_match("/^(([a-z0-9]+)[_][^(]+)[(]/", $tag, $m);
	$function = $m[1];
	$tagmod = $m[2];
	$jscode = strpos($tag, '$') ? '无' : '&lt;script type=&#34;text/javascript&#34; src=&#34;'.$PHP_SITEURL.'js.php?tag='.urlencode($tagname).'&#34;>&lt;/script&gt;';
?>
<tr align="center" onMouseOut="this.style.backgroundColor='#F1F3F5'" onMouseOver="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
<td align="center"><a href="?mod=<?=$mod?>&file=<?=$file?>&action=quickoperate&operate=edit&tagname=<?=urlencode($tagname)?>"><?=$tagname?></td>
<td align="left">
<input type='text' value="{tag_<?=$tagname?>}" size='24' name='tag<?=$tagname?>a' title="提示：双击鼠标复制标签内容至剪贴板..." onclick="this.select()" onDblClick="clipboardData.setData('text',this.value); alert(this.value +'已复制到剪贴板');"><br/>
</td>
<td align="left">
<input type='text' value="<?=$jscode?>" size='37' name='js<?=$tagname?>' title="提示：双击鼠标复制标签内容至剪贴板..." onclick="this.select()" onDblClick="clipboardData.setData('text',this.value); alert(this.value +'已复制到剪贴板');">
</td>
<td align="center"><a href="?mod=<?=$tagmod?>&file=tag&action=manage&function=<?=$function?>"><?=$MODULE[$tagmod]['name']?></a></td>
<td>
<a href="?mod=<?=$mod?>&file=<?=$file?>&action=quickoperate&operate=preview&tagname=<?=urlencode($tagname)?>">预览</a> | 
<a href="?mod=<?=$mod?>&file=<?=$file?>&action=quickoperate&operate=edit&tagname=<?=urlencode($tagname)?>">编辑</a> | 
<a href="?mod=<?=$mod?>&file=<?=$file?>&action=quickoperate&operate=copy&tagname=<?=urlencode($tagname)?>">复制</a> | 
<a href="###" onClick="javascript:confirmurl('?mod=<?=$mod?>&file=<?=$file?>&action=delete&tagname=<?=urlencode($tagname)?>&forward=<?=urlencode($PHP_URL)?>','确认删除此标签吗？如果您在模板中使用了短标签或JS调用，则请不要删除！')">删除</a></td>
</tr>
<?php 
}
?>
</table>
<br/>
<table cellpadding="2" cellspacing="1" border="0" class="tableborder">
  <tr>
    <td class="submenu" align="center">提示信息</td>
  </tr>
  <tr>
    <td class="tablerow">
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
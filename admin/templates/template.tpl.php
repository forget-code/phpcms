<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<?=$menu?>
<?php if(isset($_grade) && $_grade==0){ ?>
<table cellpadding='2' cellspacing='1' border='0' align='center' class='tableBorder'>
  <tr>
    <td class='pagemenu'>
<?php
$i = 1;
foreach($modules as $m=>$name)
{
?>
		<a href="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>&module=<?=$m?>&projectid=<?=$project?>" class='pagelink'><?=$name?></a>
<?php 
if($i%15==0) echo '<br/>'; else echo ' | ';
$i++;
}
?>
	</td>
  </tr>
</table>
<?php } ?>
<form name="search" method="get">
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="30">
  <tr>
    <td>当前位置：<a href="?mod=phpcms&file=templateproject&action=manage">模板方案</a> > <a href="?mod=phpcms&file=template&action=manage&project=<?=$project?>&module=<?=$module?>"><?=$projectname?>-<?=$MODULE[$module]['name']?>模板</a></td>
    <td align="right">
	<input type="hidden" name="mod" value="<?=$mod?>">
	<input type="hidden" name="file" value="<?=$file?>">
	<input type="hidden" name="action" value="<?=$action?>">
	<input type="hidden" name="module" value="<?=$module?>">
	<select name="searchtype">
	<option value="templatename" <?=($searchtype == 'templatename' ? 'selected' : '')?>>模板名称</option>
	<option value="filename" <?=($searchtype == 'filename' ? 'selected' : '')?>>模板文件名</option>
	</select>
	<input type="text" name="keyword" value="<?=$keyword?>" size="12">
	<input type="submit" name="dosubmit" value="搜索模板">
	</td>
  </tr>
</table>
</form>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=8>模板管理</th>
  </tr>
<form name="myform" method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=update&module=<?=$module?>">
<tr align="center">
<td width="20%" class="tablerowhighlight">模板名称</td>
<td width="23%" class="tablerowhighlight">文件名</td>
<td width="15%" class="tablerowhighlight">模板类型</td>
<td width="5%" class="tablerowhighlight">新建</td>
<td width="22%" class="tablerowhighlight">模板嵌套代码</td>
<td width="15%" class="tablerowhighlight">管理操作</td>
</tr>
<?php 
if(is_array($templates)){
	foreach($templates as $template){
?>
<tr align="center" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
<td><input type="text" name="templatename[<?=$template['file']?>]" size="22" value="<?=$template['name']?>"></td>
<td align="left"><a href="?mod=<?=$mod?>&file=<?=$file?>&action=edit&channelid=<?=$channelid?>&template=<?=$template['template']?>&module=<?=$module?>&project=<?=$project?>" title="上次修改时间：<?=date("Y-m-d H:i:s",$template['mtime'])?>"><?=$template['file']?></a></td>
<td align="left"><a href="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>&module=<?=$module?>&searchtype=filename&keyword=<?=$template['type']?>"><?=$template['type']?></a></td>
<td><?php if($template['isdefault']){?><a href="?mod=phpcms&file=template&action=add&module=<?=$module?>&project=<?=$project?>&templatename=<?=urlencode($template['name'])?>&templatetype=<?=$template['type']?>" title="新建<?=$template['name']?>类型模板(<?=$template['type']?>)" style="color:red">+</a><?php }?></td>
<td><input type="text" name="function<?=$template['template']?>" size="25" value="{template '<?=$module?>','<?=$template['template']?>'}" onfocus="document.myform.elements['function<?=$template['template']?>'].select();"></td>
<td><a href="?mod=<?=$mod?>&file=<?=$file?>&action=down&channelid=<?=$channelid?>&template=<?=$template['template']?>&module=<?=$module?>&project=<?=$project?>" title="上次修改时间：<?=date("Y-m-d H:i:s",$template['mtime'])?>">下载</a> | <a href="?mod=<?=$mod?>&file=<?=$file?>&action=edit&channelid=<?=$channelid?>&template=<?=$template['template']?>&module=<?=$module?>&project=<?=$project?>" title="上次修改时间：<?=date("Y-m-d H:i:s",$template['mtime'])?>">修改</a> | <a href="?mod=<?=$mod?>&file=<?=$file?>&action=delete&channelid=<?=$channelid?>&template=<?=$template['template']?>&module=<?=$module?>&project=<?=$project?>" title="上次修改时间：<?=date("Y-m-d H:i:s",$template['mtime'])?>">删除</a></td>
</tr>
<?php 
	}
}
?>
</table>
<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left">&nbsp;&nbsp;<input type="submit" name="submit" value=" 更新模板名称 "></td>
  </tr>
</table>
</form>
<br/>
<table cellpadding="2" cellspacing="1" border="0" align="center" class="tableBorder" >
  <tr>
    <td class="submenu" align="center">提示信息</td>
  </tr>
  <tr>
    <td class="tablerow">
	1、当前模板保存在 <font color="red">./templates/<?=$project?>/<?=$module?>/</font>  目录（如需在线修改，请通过ftp将 ./templates/ 目录设置为 777 并应用到子目录）<br/>
	2、同类型模板都以模板类型为前缀，后面以中划线分割（命名规则：<font color="blue">模板类型-</font><font color="red">特征名</font>，同类型模板特征名不同）。<br/>
	例如：tag_article_slide.html 和 tag_article_slide-js.html 是 tag_article_slide 类型模板，且 tag_article_slide.html 是该类型默认模板
<p>
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
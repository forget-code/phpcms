<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<form name="search" method="get">
<table cellpadding="0" cellspacing="1" class="table_form">
  <caption>模板搜索</caption>
  <tr>
    <td><span style="float:right">
	<input type="hidden" name="mod" value="<?=$mod?>">
	<input type="hidden" name="file" value="<?=$file?>">
	<input type="hidden" name="action" value="<?=$action?>">
	<input type="hidden" name="module" value="<?=$module?>">
	<select name="searchtype">
	<option value="templatename" <?=($searchtype == 'templatename' ? 'selected' : '')?>>模板名称</option>
	<option value="filename" <?=($searchtype == 'filename' ? 'selected' : '')?>>模板文件名</option>
	<option value="data" <?=($searchtype == 'data' ? 'selected' : '')?>>模板代码</option>
	</select>
	<input type="text" name="keyword" value="<?=$keyword?>" size="20">
	<input type="submit" name="dosubmit" value="搜索"></span>
	<a href="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>&module=<?=$module?>">全部模板</a> |
	<a href="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>&module=<?=$module?>&istag=0">普通模板</a> |
	<a href="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>&module=<?=$module?>&istag=1">标签模板</a>
	</td>
  </tr>
</table>
</form>
<form name="myform" method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=update&module=<?=$module?>">
<table cellpadding="0" cellspacing="1" class="table_list">
  <caption>模板管理</caption>
<tr>
<th width="150">模板名称</th>
<th>文件名</th>
<th width="40">新建</th>
<th width="180">模板嵌套代码</th>
<th width="180">管理操作</th>
</tr>
<?php 
if(is_array($templates)){
	foreach($templates as $template){
?>
<tr>
<td class="align_c" width="150"><input type="text" name="templatename[<?=$template['file']?>]" value="<?=$template['name']?>" style="width:100%"></td>
<td class="align_left"><a href="?mod=<?=$mod?>&file=<?=$file?>&action=edit&template=<?=$template['template']?>&module=<?=$module?>&project=<?=$project?>" title="上次修改时间：<?=date("Y-m-d H:i:s",$template['mtime'])?>"><?=$template['file']?></a></td>
<td class="align_c" width="40"><?php if($template['isdefault']){?><a href="?mod=phpcms&file=template&action=add&module=<?=$module?>&project=<?=$project?>&templatename=<?=urlencode($template['name'])?>&templatetype=<?=$template['type']?>" title="新建<?=$template['name']?>类型模板(<?=$template['type']?>)" style="color:red">+</a><?php }?></td>
<td width="180"><input type="text" name="function<?=$template['template']?>" value="{template '<?=$module?>','<?=$template['template']?>'}" onfocus="document.myform.elements['function<?=$template['template']?>'].select();" style="width:100%"></td>
<td class="align_c" width="180">
<a href="?mod=<?=$mod?>&file=<?=$file?>&action=edit&template=<?=$template['template']?>&module=<?=$module?>&project=<?=$project?>" title="上次修改时间：<?=date("Y-m-d H:i:s",$template['mtime'])?>">修改</a> | 
<?php if(substr($template['template'], 0, 4) == 'tag_'){ ?>
<font color="#cccccc">可视化</font> | 
<?php }else{ ?>
<a href="?mod=<?=$mod?>&file=<?=$file?>&action=tag&template=<?=$template['template']?>&module=<?=$module?>&project=<?=$project?>" title="可视化编辑中文标签和碎片">可视化</a> | 
<?php } ?>
<a href="?mod=<?=$mod?>&file=<?=$file?>&action=down&template=<?=$template['template']?>&module=<?=$module?>&project=<?=$project?>" title="上次修改时间：<?=date("Y-m-d H:i:s",$template['mtime'])?>">下载</a> | 
<a href="javascript:confirmurl('?mod=<?=$mod?>&file=<?=$file?>&action=delete&template=<?=$template['template']?>&module=<?=$module?>&project=<?=$project?>','确认删除模板“<?=$template['template']?>.html”吗？')" title="上次修改时间：<?=date("Y-m-d H:i:s",$template['mtime'])?>">删除</a>
</td>
</tr>
<?php 
	}
}
?>
</table>
<div class="button_box" style="padding-left:30px">
   <input type="submit" name="submit" value=" 更新模板名称 ">
</div>
</form>
<table cellpadding="0" cellspacing="1" class="table_info">
  <caption>提示信息</caption>
  <tr>
    <td>
	当前模板保存在 <font color="red">./templates/<?=$project?>/<?=$module?>/</font>  目录
	<?php if(!is_writeable($templatedir)){ ?>（如需在线修改，请通过ftp将 ./templates/ 目录设置为 777 并应用到子目录）<?php } ?><br/>
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
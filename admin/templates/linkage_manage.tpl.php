<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<?=$menu?>
<form method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=listorder">
<table cellpadding="0" cellspacing="1" class="table_list">
    <caption>联动菜单管理</caption>
<tr>
<th width="5%"><strong>ID</strong></th>
<th width="20%"><strong>联动菜单名称</strong></th>
<th width="*"><strong>描述</strong></th>
<th width="*"><strong>（在模板中）调用代码</strong></th>
<th width="30%"><strong>管理操作</strong></th>
</tr>
<?php 
if(is_array($infos)){
	foreach($infos as $info){
?>
<tr>
<td class="align_c"><?=$info['linkageid']?></td>
<td class="align_c"><span style="<?=$info['style']?>"><?=$info['name']?></span></td>
<td class="align_c"><?=$info['description']?></td>
<td class="align_c"><input type="text" value="{menu_linkage(<?=$info['linkageid']?>,'L_<?=$info['linkageid']?>')}" style="width:200px;"></td>
<td class="align_c">
<a href="?mod=<?=$mod?>&file=<?=$file?>&action=manage_submenu&keyid=<?=$info['linkageid']?>">管理子菜单</a> | 
<a href="?mod=<?=$mod?>&file=<?=$file?>&action=edit&linkageid=<?=$info['linkageid']?>">修改</a> | <a href="javascript:confirmurl('?mod=<?=$mod?>&file=<?=$file?>&action=delete&linkageid=<?=$info['linkageid']?>', '是否删除该类型')">删除</a> </td>
</tr>
<?php 
	}
}
?>
</table>
</form>
<form action="?mod=<?=$mod?>&file=<?=$file?>&action=add" method="post" name="myform">
<table cellpadding="0" cellspacing="1" class="table_form">
    <caption>添加联动菜单</caption>
	<tr> 
      <th><strong>菜单名称</strong></th>
      <td><input type="text" name="info[name]" size="30"> <?=form::style('info[style]')?> <font color="red">*</font></td>
    </tr>
	<tr> 
      <th><strong>菜单描述</strong></th>
      <td><textarea name="info[description]" rows="2" cols="20" id="description" class="inputtext" style="height:45px;width:300px;"></textarea></td>
    </tr>
    <tr> 
      <th></th>
      <td> 
	  <input type="submit" name="dosubmit" value=" 确定 ">
	  </td>
    </tr>
</table>
</form>
<table cellpadding="0" cellspacing="1" class="table_info">
	<caption>使用说明</caption>
    <tr>
    	<td>1、在模板文件中，可以使用 {menu_linkage(40,'L_40')} 来自动产生无限级菜单选择框。<BR>
		其中 <font color='red'>L_40</font> 为字段的名称，可修改。例如：{menu_linkage(40,'city')}
		<BR>
		2、在模型字段中可选择添加联动菜单字段来关联</td>
    </tr>
</table>

</body>
</html>
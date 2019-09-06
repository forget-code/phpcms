<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<?=$menu?>
<form method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=listorder">
<table cellpadding="0" cellspacing="1" class="table_list">
    <caption><?=$keyname?>-联动菜单管理</caption>
<tr>
<th width="5%"><strong>排序</strong></th>
<th width="5%"><strong>ID</strong></th>
<th width="20%"><strong>联动菜单名称</strong></th>
<th width="*"><strong>描述</strong></th>
<th width="30%"><strong>管理操作</strong></th>
</tr>
<?=$infos?>
</table>
<div class="button_box"><input name="dosubmit" type="submit" value=" 排序 "></div>
</form>
<form action="?mod=<?=$mod?>&file=<?=$file?>&action=addsub" method="post" name="myform">
<a name="addsubmunu">
<table cellpadding="0" cellspacing="1" class="table_form">
    <caption>添加联动（子菜单）</caption>
	<tr>
  <th><font color="red">*</font>  <strong>上级菜单</strong></th>
  <td>
<?=form::select_linkage($keyid, 0, 'info[parentid]', 'parentid', '无（作为一级栏目）', $linkageid)?>

  </td>
  </tr>
	<tr <?php if($linkageid) echo "style='background-color:#CEDEE3;'";?>> 
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
	  <input type="hidden" name="info[keyid]" value="<?=$keyid?>">
	  <input type="submit" name="dosubmit" value=" 确定 ">
	  </td>
    </tr>
</table>
</form>
</body>
</html>
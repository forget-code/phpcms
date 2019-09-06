<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<?=$menu?>
<form action="?mod=<?=$mod?>&file=<?=$file?>&action=edit" method="post" name="myform">
<table cellpadding="0" cellspacing="1" class="table_form">
    <caption>修改联动菜单</caption>
<?php
if(isset($parentid)) { ?>
<tr>
  <th><font color="red">*</font>  <strong>上级菜单</strong></th>
  <td>
<?=form::select_linkage($info['keyid'], 0, 'info[parentid]', 'parentid', '无（作为一级栏目）', $parentid)?>
  </td>
  </tr>
  <?php } ?>
	<tr> 
      <th><strong>菜单名称</strong></th>
      <td><input type="text" name="info[name]" size="30" value="<?=$info['name']?>"> <?=form::style('info[style]',$info['style'])?> <font color="red">*</font></td>
    </tr>
	<tr> 
      <th><strong>菜单描述</strong></th>
      <td><textarea name="info[description]" rows="2" cols="20" id="description" class="inputtext" style="height:45px;width:300px;"><?=$info['description']?></textarea></td>
    </tr>
    <tr> 
      <th></th>
      <td> 
	  <input type="hidden" name="linkageid" value="<?=$linkageid?>">
	  <input type="hidden" name="info[keyid]" value="<?=$keyid?>">
	  <input type="submit" name="dosubmit" value=" 确定 ">
	  </td>
    </tr>
</table>
</form>
</body>
</html>
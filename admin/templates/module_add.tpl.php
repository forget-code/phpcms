<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>

<body>
<?=$menu?>
<table cellpadding="2" cellspacing="1" class="table_form">
<form action="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>" method="post" name="myform">
    <caption>新建模块</caption>
      <th width="30%"><strong>模块中文名</strong> <font color="red">*</font></th>
      <td><input type="text" name="info[name]" size="30"></td>
    </tr>
	<tr> 
      <th><strong>模块英文名</strong> <font color="red">*</font></th>
      <td><input type="text" name="info[module]" size="30"></td>
    </tr>
	<tr> 
      <th><strong>模块访问网址</strong> <font color="red">*</font><br />例：http://news.***.com/ 如果不绑定域名，请留空</th>
      <td><input type="text" name="info[url]" size="30"></td>
    </tr>
	<tr> 
      <th><strong>版本号</strong> <font color="red">*</font></th>
      <td><input type="text" name="info[version]" size="30" value="1.0.0"></td>
    </tr>
	<tr> 
      <th><strong>作者</strong> <font color="red">*</font></th>
      <td><input type="text" name="info[author]" size="30"></td>
    </tr>
	<tr> 
      <th><strong>E-mail</strong> <font color="red">*</font></th>
      <td><input type="text" name="info[email]" size="30"></td>
    </tr>
	<tr> 
      <th><strong>网站地址</strong> <font color="red">*</font></th>
      <td><input type="text" name="info[site]" size="30"></td>
    </tr>
	<tr> 
      <th><strong>功能说明</strong> <font color="red">*</font></th>
      <td><textarea name="info[description]" id="description" cols="60" rows="8"></textarea><?=form::editor('description', 'introduce', 700, 200)?></td>
    </tr>
	<tr> 
      <th><strong>许可协议</strong></th>
      <td><textarea name='info[license]' id="license" cols='60' rows='8'></textarea><?=form::editor('license', 'introduce', 700, 200)?></td>
    </tr>
	<tr> 
      <th><strong>使用帮助</strong></th>
      <td><textarea name='info[faq]' id="faq" cols='60' rows='10'></textarea><?=form::editor('faq', 'introduce', 700, 200)?></td>
    </tr>
    <tr> 
      <th></th>
      <td> 
	  <input type="hidden" name="forward" value="?mod=<?=$mod?>&file=<?=$file?>&action=manage"> 
	  <input type="submit" name="dosubmit" value=" 确定 "> 
      &nbsp; <input type="reset" name="reset" value=" 清除 ">
	  </td>
    </tr>
	</form>
</table>
</body>
</html>
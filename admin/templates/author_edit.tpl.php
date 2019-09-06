<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<table cellpadding="2" cellspacing="1" class="table_form">
<form action="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>&authorid=<?=$authorid?>" method="post" name="myform">
    <caption>编辑作者</caption>
 	<tr> 
      <th><strong>用户名</strong></th>
      <td><input type="text" name="info[username]" value="<?=$username?>" size="20"> <font color="red">*</font></td>
    </tr>
	<tr> 
      <th><strong>姓名</strong></th>
      <td><input type="text" name="info[name]" value="<?=$name?>" size="15"> <font color="red">*</font></td>
    </tr>
	<tr> 
      <th><strong>照片</strong></th>
      <td><?=form::upload_image('info[photo]', 'photo', $photo, 40)?></td>
    </tr>
	<tr> 
      <th><strong>性别</strong></th>
      <td><input type="radio" name="info[gender]" value="1" checked> 男 <input type="radio" name="info[gender]" value="0"> 女</td>
    </tr>
	<tr> 
      <th><strong>生日</strong></th>
      <td><?=form::date('info[birthday]', $birthday)?></td>
    </tr>
	<tr> 
      <th><strong>E-mail</strong></th>
      <td><input type="text" name="info[email]" value="<?=$email?>" size="30"></td>
    </tr>
	<tr> 
      <th><strong>QQ</strong></th>
      <td><input type="text" name="info[qq]" value="<?=$qq?>" size="20"></td>
    </tr>
	<tr> 
      <th><strong>MSN</strong></th>
      <td><input type="text" name="info[msn]" value="<?=$msn?>" size="30"></td>
    </tr>
	<tr> 
      <th><strong>主页</strong></th>
      <td><input type="text" name="info[homepage]" value="<?=$homepage?>" size="50"></td>
    </tr>
	<tr> 
      <th><strong>电话</strong></th>
      <td><input type="text" name="info[telephone]" value="<?=$telephone?>" size="20"></td>
    </tr>
	<tr> 
      <th><strong>地址</strong></th>
      <td><input type="text" name="info[address]" value="<?=$address?>" size="50"></td>
    </tr>
	<tr> 
      <th><strong>邮编</strong></th>
      <td><input type="text" name="info[postcode]" value="<?=$postcode?>" size="6"></td>
    </tr>
	<tr> 
      <th><strong>个人简介</strong></th>
      <td><textarea name="info[introduce]" id="introduce"><?=$introduce?></textarea><?=form::editor('introduce', 'basic', '100%', 350)?></td>
    </tr>
	<tr> 
      <th><strong>是否禁用</strong></th>
      <td><input type="radio" name="info[disabled]" value="1"> 是 <input type="radio" name="info[disabled]" value="0" checked> 否</td>
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
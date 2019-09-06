<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>

<body>
<?=$menu?>
<table cellpadding="2" cellspacing="1" class="tableborder">
<form action="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>" method="post" name="myform">
  <tr>
    <th colspan=2>新建模块</th>
  </tr>
	<tr> 
      <td width="30%" class="tablerow">模块中文名 <font color="red">*</font></td>
      <td class="tablerow"><input type="text" name="name" size="30"></td>
    </tr>
	<tr> 
      <td class="tablerow">模块英文名 <font color="red">*</font></td>
      <td class="tablerow"><input type="text" name="module" size="30"></td>
    </tr>
	<tr> 
      <td class="tablerow">是否可基于此模块建立频道 <font color="red">*</font></td>
      <td class="tablerow"><input type="radio" name="iscopy" value="1" onclick="$('moduledomain').style.display='none'"> 是 <input type="radio" name="iscopy" value="0"  onclick="$('moduledomain').style.display='block'" checked> 否</td>
    </tr>
	<tr> 
      <td class="tablerow">是否可在网站频道间共享 <font color="red">*</font></td>
      <td class="tablerow"><input type="radio" name="isshare" value="1"> 是 <input type="radio" name="isshare" value="0" checked> 否</td>
    </tr>
	<tr> 
      <td class="tablerow">模块目录 <font color="red">*</font></td>
      <td class="tablerow"><input type="text" name="moduledir" size="30"></td>
    </tr>
	<tr id='moduledomain'> 
      <td class="tablerow">绑定域名 <font color="red">*</font></td>
      <td class="tablerow"><input type="text" name="moduledomain" size="30"></td>
    </tr>
	<tr> 
      <td class="tablerow">版本号 <font color="red">*</font></td>
      <td class="tablerow"><input type="text" name="version" size="30" value="1.0.0"></td>
    </tr>
	<tr> 
      <td class="tablerow">作者 <font color="red">*</font></td>
      <td class="tablerow"><input type="text" name="author" size="30"></td>
    </tr>
	<tr> 
      <td class="tablerow">E-mail <font color="red">*</font></td>
      <td class="tablerow"><input type="text" name="email" size="30"></td>
    </tr>
	<tr> 
      <td class="tablerow">网站地址 <font color="red">*</font></td>
      <td class="tablerow"><input type="text" name="site" size="30"></td>
    </tr>
	<tr> 
      <td class="tablerow">功能说明 <font color="red">*</font></td>
      <td class="tablerow"><textarea name="introduce" id="introduce" cols="60" rows="8"></textarea>  <?=editor('introduce','introduce',400,200)?></td>
    </tr>
	<tr> 
      <td class="tablerow">许可协议</td>
      <td class="tablerow"><textarea name='license' cols='60' rows='8'></textarea>  <?=editor('license','introduce',400,200)?></td>
    </tr>
	<tr> 
      <td class="tablerow">使用帮助</td>
      <td class="tablerow"><textarea name='faq' cols='60' rows='10'></textarea>  <?=editor('faq','introduce',400,300)?></td>
    </tr>
    <tr> 
      <td class="tablerow"></td>
      <td class="tablerow"> 
	  <input type="hidden" name="forward" value="?mod=<?=$mod?>&file=<?=$file?>&action=manage"> 
	  <input type="submit" name="dosubmit" value=" 确定 "> 
      &nbsp; <input type="reset" name="reset" value=" 清除 ">
	  </td>
    </tr>
	</form>
</table>
</body>
</html>
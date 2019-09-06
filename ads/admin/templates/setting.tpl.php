<?php defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td></td>
  </tr>
</table>
<form name="myform" method="post" action="?mod=<?=$mod?>&file=<?=$file?>">
<table cellpadding="2" cellspacing="1" class="tableborder">
  <th colspan=2>广告模块配置</th>
 	<tr>
      <td class='tablerow'><strong>是否统计广告点击次数</strong></td>
      <td class='tablerow'>
	  <input type='radio' name='setting[enableadsclick]' value='1'  <?php if($enableadsclick){ ?>checked <?php } ?>> 是&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='setting[enableadsclick]' value='0'  <?php if(!$enableadsclick){ ?>checked <?php } ?>> 否
	 </td>
    </tr>
	<tr>
      <td class='tablerow' width="20%"><strong>html和js存放目录</strong></td>
      <td class='tablerow'>./data/<input name='setting[htmldir]' type='text' id='htmldir' value='<?=$htmldir?>' size='12' maxlength='50'>/ &nbsp;&nbsp;&nbsp;&nbsp; 修改广告html存放目录名可以防止广告被客户端浏览器屏蔽
	 </td>
    </tr>
    <tr>
      <td class='tablerow'><strong>模块绑定域名</strong></td>
      <td class='tablerow'><input name='setting[moduledomain]' type='text' id='moduledomain' value='<?=$moduledomain?>' size='40' maxlength='50'></td>
    </tr>
</table>
<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
  <tr>
     <td width='40%'></td>
     <td><input type="submit" name="dosubmit" value=" 确定 ">&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="reset" value=" 重置 "></td>
  </tr>
</table>
</form>
</body>
</html>
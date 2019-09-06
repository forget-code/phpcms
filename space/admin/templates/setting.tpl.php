<?php defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<form name="myform" method="post" action="?mod=<?=$mod?>&file=<?=$file?>">
<table cellpadding="0" cellspacing="1" class="table_form">
  <caption><?=$M['name']?>模块配置</caption>
      <th><strong>模块访问网址（URL）</strong></th>
      <td><input name='setting[url]' type='text' id='url' value='<?=$url?>' size='40' maxlength='50'></td>
    </tr>
  	<tr>
     <td colspan="2">
     <div class="button_box">
     <input type="submit" name="dosubmit" value=" 确定 ">&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="reset" value=" 重置 ">
     </div>
     </td>
  </tr>
</table>
</form>
</body>
</html>
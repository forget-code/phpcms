<?php defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>



<form name="myform" method="post" action="?mod=<?=$mod?>&file=<?=$file?>">
<table cellpadding="0" cellspacing="1" class="table_form">
  <caption>
  基本信息
  </caption>
  <tr>
    <th width="30%"><strong>是否开始积分</strong><br />为提供错误报告的会员增加积分，0是不启动，<br>填写数字表示审核通过给会员加入的积分</th>
    <td><input type='text' name='setting[ispoint]' id='ispoint' value="<?=$ispoint?>" /></td>
  </tr>
  <tr>
    <th width="30%"><strong>提交错误报告是否开启验证码</strong></th>
    <td><input type='radio' name='setting[enablecheckcode]' id='enablecheckcode' value='1' <?php echo $enablecheckcode == 1 ? 'checked' : '' ?>>是<input type='radio' name='setting[enablecheckcode]' id='enablecheckcode' value='0' <?php echo $enablecheckcode == 0 ? 'checked' : '' ?>>否</td>
  </tr>
  <tr>
    <th>&nbsp;</th>
    <td><input type="submit" name="dosubmit" value="确定">&nbsp;&nbsp;<input type="reset" name="reset" value="重置"></td>
  </tr>
</table>
</form>
</body>
</html>
<?php defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<form name="myform" method="post" action="?mod=<?=$mod?>&file=<?=$file?>">
<table cellpadding="0" cellspacing="1" class="table_form">
<caption>基本信息</caption>
<tr>
  <th width="25%"><strong>是否允许游客发表评论</strong></th>
  <td width="75%"><input type='radio' name='setting[ischecklogin]' id='ischecklogin' value='1' <?php echo $ischecklogin == 1 ? 'checked' : '' ?>> 是 <input type='radio' name='setting[ischecklogin]' id='ischecklogin' value='0' <?php echo $ischecklogin == 0 ? 'checked' : '' ?>> 否</td>
</tr>
<tr>
  <th><strong>评论是否需要审核</strong></th>
  <td><input type='radio' name='setting[ischeckcomment]' id='ischeckcomment' value='1' <?php echo $ischeckcomment == 1 ? 'checked' : '' ?>> 是 <input type='radio' name='setting[ischeckcomment]' id='ischeckcomment' value='0' <?php echo $ischeckcomment == 0 ? 'checked' : '' ?>> 否</td>
</tr>
<tr>
  <th><strong>提交评论是否开启验证码</strong></th>
  <td><input type='radio' name='setting[enablecheckcode]' id='enablecheckcode' value='1' <?php echo $enablecheckcode == 1 ? 'checked' : '' ?>> 是 <input type='radio' name='setting[enablecheckcode]' id='enablecheckcode' value='0' <?php echo $enablecheckcode == 0 ? 'checked' : '' ?>> 否</td>
</tr>
<tr>
  <th><strong>每页最大评论数</strong></th>
  <td><input type="text" name='setting[maxnum]' value="<?=$maxnum ?>" ></td>
</tr>
<tr>
    <th>&nbsp;</th>
    <td><input type="submit" name="dosubmit" value="确定">&nbsp;&nbsp;<input type="reset" name="reset" value="重置"></td>
</tr>
</table>
</form>
</body>
</html>
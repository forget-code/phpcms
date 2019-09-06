<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<?=$menu?>
<form name="myform" method="post" action="">
<table cellpadding="0" cellspacing="1" class="table_form">
  <caption>管理远程公告</caption>
  <tr>
    <th width="19%" class="td_right"><font color="#FF0000">*</font> <strong>公告内容：</strong></th>
    <td class="td_left">
	<textarea name="content" id="content" style="display:none"><?=$content?></textarea>
	<?=form::editor('content','basic','100%',200,0)?></td>
  </tr>
   <tr>
    <th width="19%" class="td_right"><font color="#FF0000">*</font> <strong>修改时间：</strong></th>
    <td class="td_left"><?=$edittime?> <font color="red">公告内容将会在商务中心首页显示</font></td>
  </tr>
 <tr>
    <td width="15%" class="td_right">
	</td>
    <td class="td_left" height="25">
	<input type="submit" name="dosubmit" value=" 确认修改 " />
	</td>
  </tr>
</table>
</form>
</body>
</html>
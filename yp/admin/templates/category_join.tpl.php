<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<?=$menu?>
<table cellpadding="0" cellspacing="1" class="table_form">
<caption>
  合并栏目
</caption>
<form method="post" action="?mod=ask&file=category&action=join">
<tr ><td colspan=2 class="tablerowhighlight">源栏目的问题全部转入目标栏目，同时删除源栏目和其子栏目</td></tr>
<tr>
<th width="45%">源栏目</td>
<td>
<?=form::select_category($mod, 0, 'sourcecatid', 'sourcecatid', '请选择', $catid)?>  <font color="red">*</font>
</td>
</tr>
<tr><th>目标栏目</th>
<td  width="60%">
<?=form::select_category($mod, 0, 'targetcatid', 'targetcatid', '请选择', $catid)?>  <font color="red">*</font>
</td></tr>
<tr ><td  colspan=2 ><input type="submit" name="dosubmit" value=" 合并 "></td></tr>
</form>
</table>
</body>
</html>
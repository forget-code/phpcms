<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<?=$menu?>
<form name="myform" action="" method="post">
<input type="hidden" name="mod" value="<?=$mod?>" />
<input type="hidden" name="file" value="<?=$file?>" />
<input type="hidden" name="action" value="<?=$action?>" />
<table width="100%" cellpadding="3" cellspacing="1"  class="table_form">
	<caption>批量删除</caption>
    <tr>
    	<th><strong>用户名：</strong></th>
        <td><input type="text" name="username"  /></td>
    </tr>
    <tr>
    	<th><strong>问题发布时间：</strong></th>
        <td><?=form::date('addtime')?> - <?=form::date('endtime')?></td>
    </tr>
    <tr>
    	<th><strong>问题是否过期：</strong></th>
        <td>
        	<input type="radio" name="ischeck" value="1" />是
            <input type="radio" name="ischeck" value="0" />否
        </td>
    </tr>
    <tr>
    	<th></th>
        <td>
        <input type="submit" name="dosubmit" value="提交"  onClick="if(confirm('确认批量删除吗？该操作不可恢复')) $('form').submit()" />
        <input type="reset" name="reset" value="重置" />
        </td>
    </tr>
</table>
</form>
</body>
</html>
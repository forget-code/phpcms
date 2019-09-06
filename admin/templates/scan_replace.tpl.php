<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<form action="?mod=phpcms&file=safe&action=replace&dosubmit=1" method="POST">
<table width="95%" cellpadding="0" class="table_form" cellspacing="1">
 <caption>批量替换</caption>
 <tr>
 <td>要替换的内容</td>
 <td><input type="text" name="html" id="html" size="40"></td>
 </tr>
 <tr>
 <td>替换成</td>
 <td><input type="text" name="replace" id="replace" size="40"></td>
 </tr>
 <tr>
 <td></td>
 <td><input type="submit" value="提交"></td>
 </tr>
 </table>
</form>
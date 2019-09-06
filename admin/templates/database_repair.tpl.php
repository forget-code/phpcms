<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<form method="post" name="myform" id="myform" action="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>">
<table cellpadding="2" cellspacing="1" class="table_list">
    <caption>数据表优化和修复</caption>
<tr>
<th><strong>选中</strong></th>
<th><strong>数据表名</strong></th>
</tr>
<?php
if(is_array($tables)){
	foreach($tables as $id => $table){
?>
  <tr>
    <td  class="align_c"><input type="checkbox" name="tables[]" value="<?=$table?>"></td>
    <td><?=$table?></td>
	</td>
</tr>
<?php
	}
}
?>
  <tr>
    <td class="align_c"><a href="###" onClick="javascript:$('input[type=checkbox]').attr('checked', true)">全选</a>/<a href="###" onClick="javascript:$('input[type=checkbox]').attr('checked', false)">取消</a></td>
      <td>
      <input type="radio" name="operation" value="repair">修复表&nbsp;&nbsp;
      <input type="radio" name="operation" value="optimize" checked>优化表&nbsp;&nbsp;
	  <input type="submit" name="dosubmit" value=" 提交 "></td>
  </tr>
	</form>
</table>
</body>
</html>


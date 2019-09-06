<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<table cellpadding="2" cellspacing="1" class="table_form">
<form action="?" method="post" name="myform">
  <input type="hidden" name="mod" value="<?=$mod?>"> 
  <input type="hidden" name="file" value="<?=$file?>"> 
  <input type="hidden" name="action" value="<?=$action?>"> 
  <input type="hidden" name="forward" value="<?=URL?>"> 
  <input type="hidden" name="dosubmit" value="1"> 
  <tr>
    <caption>更新栏目页</caption>
  <tr>
	<th width="25%"><strong>选择栏目</strong><br />可以同时选择多个栏目</th>
	<td><?=form::select_category($mod, 0, 'catids[]', 'catids', '所有栏目', 0, ' multiple="multiple"  style="height:200px;width:250px;" title="按住“Ctrl”或“Shift”键可以多选，按住“Ctrl”可取消选择"', 2)?></td>
  </tr>
	<tr> 
      <th><strong>列表页每页信息条数</strong></th>
      <td><?=$PHPCMS['pagesize']?> 条（<a href="?mod=phpcms&file=setting&tab=2">修改设置</a>）</td>
    </tr>
	<tr> 
      <th><strong>列表页最大更新页数</strong></th>
      <td><?=$PHPCMS['maxpage']?> 页（<a href="?mod=phpcms&file=setting&tab=2">修改设置</a>）</td>
    </tr>
	<tr> 
      <th><strong>每轮更新页数</strong></th>
      <td><input type="text" name="pagesize" value="50" size="4"> 页</td>
    </tr>
	<tr> 
      <td></td>
      <td><input type="submit" name="dosubmit" value=" 开始更新 "></td>
    </tr>
	</form>
</table>
</body>
</html>
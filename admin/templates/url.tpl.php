<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<table cellpadding="2" cellspacing="1" class="table_list">
<form action="?" method="post" name="myform">
  <input type="hidden" name="mod" value="<?=$mod?>"> 
  <input type="hidden" name="file" value="<?=$file?>"> 
  <input type="hidden" name="action" value="<?=$action?>"> 
  <input type="hidden" name="forward" value="<?=$forward?>"> 
  <input type="hidden" name="dosubmit" value="1"> 
  <input type="hidden" name="type" value="lastinput"> 
  <tr>
    <caption>更新URL链接</caption>
  <tr>
	<th width="40%">选择栏目范围</th>
	<th>更新内容页链接地址</th>
  </tr>
	<tr> 
      <td rowspan="5"><?=form::select_category($mod, 0, 'catids[]', 'catids', '不限栏目', 0, ' multiple="multiple"  style="height:200px;width:250px;" title="按住“Ctrl”或“Shift”键可以多选，按住“Ctrl”可取消选择"', 2)?></td>
      <td><font color="red">每轮更新 <input type="text" name="pagesize" value="100" size="4"> 条信息</font></td>
    </tr>
	<tr> 
      <td>更新所有信息 <input type="button" name="dosubmit1" value=" 开始更新 " onclick="myform.type.value='all';myform.submit();"></td>
    </tr>
	<tr> 
      <td>更新最新发布的 <input type="text" name="number" value="100" size="5"> 条信息 <input type="button" name="dosubmit2" value=" 开始更新 " onclick="myform.type.value='lastinput';myform.submit();"></td>
    </tr>
	<tr> 
      <td>更新发布时间从 <?=form::date('fromdate')?> 到 <?=form::date('todate')?> 的信息 <input type="button" name="dosubmit3" value=" 开始更新 " onclick="myform.type.value='date';myform.submit();"></td>
    </tr>
	<tr> 
      <td>更新ID从 <input type="text" name="fromid" value="0" size="8"> 到 <input type="text" name="toid" size="8"> 的信息 <input type="button" name="dosubmit4" value=" 开始更新 " onclick="myform.type.value='id';myform.submit();"></td>
    </tr>
	</form>
</table>
</body>
</html>
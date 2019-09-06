<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<table width="95%" cellpadding="0" cellspacing="1" class="table_list">
<caption>栏目访问统计</caption>
<tr>
<form action="?" method="GET" onsubmit="return checkbox()">
<input type="hidden" name="mod" value="phpcms">
<input type="hidden" name="file" value="count">
<input type="hidden" name="action" value="search">
<td class="align_c">
栏目：<select name="catid" id="catid">
<option value="">请选择</option>
<?php echo $selected?>
</select>
起始时间：<?php echo form::date('starttime')?> 结束时间：<?php echo form::date('stoptime')?> <input type="submit" value="查询">
</td>
</form>
</tr>
</table>
<table width="95%" cellpadding="0" cellspacing="1" class="table_list">
<caption>栏目统计报表</caption>
    <tr>
        <th>栏目</th>
        <th width="10%">今天</th>
        <th width="10%">昨天</th>
        <th width="10%">本周</th>
        <th width="10%">本月</th>
        <th width="10%">本年</th>
        <th width="10%">总数</th>
    </tr>
<?php echo $html?>
</table>
<script type="text/javascript">
function checkbox()
{
		if($('#catid').val()=='')
		{
			alert('请选择栏目');
			$("#catid").focus();
			return false;
		}
		return true;
}
</script>
</body>
</html>
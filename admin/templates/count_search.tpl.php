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
起始时间：<?php echo form::date('starttime',$starttime)?> 结束时间：<?php echo form::date('stoptime', $stoptime)?> <input type="submit" value="查询">
</td>
</form>
</tr>
</table>
<table cellpadding="0" cellspacing="1" class="table_list">
<caption><?php echo $val['catname']?>栏目访问统计</caption>
<tr>
<th width="50%">日期</th>
<th>PV</th>
</tr>
<?php foreach ($list as $key=>$val):?>
<tr>
<td class="align_c"><?php echo $val['date']?></td>
<td class="align_c"><?php echo $val['hits']?></td>
</tr>
<?php endforeach;?>
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